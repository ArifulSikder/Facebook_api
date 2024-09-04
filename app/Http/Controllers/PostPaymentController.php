<?php

namespace App\Http\Controllers;

use App\Models\AccountName;
use App\Models\PostPayment;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PostPaymentController extends Controller
{
    public function index()
    {
        return view('backend.pages.post_payments.index_post_payment');
    }
    public function postPaymentData(Request $request)
    {
        // Fetch payments with related accounts
        $payments = PostPayment::with(['postPaymentsFrom', 'postPaymentsTo'])->orderBy('id', 'desc');

        $searchValue = $request->input('search.value'); 

        if (!empty($searchValue)) {
            $date = Carbon::createFromFormat('m-d-Y', $searchValue)->format('Y-m-d');
            if ( $date ) {
                $payments->orWhere('date', 'like', "%{$date}%");
            } else {
                $payments->whereHas('postPaymentsFrom', function ($query) use ($searchValue) {
                    $query->where('name', 'like', "%{$searchValue}%")
                          ->whereNull('deleted_at'); // Ensure it matches your raw SQL
                })->orWhereHas('postPaymentsTo', function ($query) use ($searchValue) {
                    $query->where('name', 'like', "%{$searchValue}%")
                          ->whereNull('deleted_at'); // Ensure it matches your raw SQL
                })->orWhere('amount', 'like', "%{$searchValue}%")
                ->orWhere('notes', 'like', "%{$searchValue}%");
            }
          
        }
        

        // Use DataTables to return the data
        return DataTables::of($payments)
            ->addColumn('from_account.name', function ($payment) {
                return optional($payment->postPaymentsFrom)->name ?? 'N/A'; // Use null coalescing operator for safety
            })
            ->addColumn('to_account.name', function ($payment) {
                return optional($payment->postPaymentsTo)->name ?? 'N/A'; // Use null coalescing operator for safety
            })
            ->addColumn('date', function ($payment) {
                return formatedDate($payment->date); // Ensure `formatedDate` function is defined
            })
            ->addColumn('amount', function ($payment) {
                return number_format($payment->amount, 2, '.', ''); // Ensure `formatedDate` function is defined
            })
            ->addColumn('actions', function ($payment) {
                if(Auth::user()->can('Edit Transfer Funds'))
                {
                    $data['edit'] = url('edit-transfer-funds/' . $payment->id);
                }
                if(Auth::user()->can('Delete  Transfer Funds'))
                {
                    $data['delete'] = url('delete-post-payment/' . $payment->id);
                }
                return view('backend.includes.actions', $data)->render();
            })
            ->rawColumns(['actions']) // This allows raw HTML in the actions column
            ->make(true);
    }

    public function addNewPostPayment()
    {
        $data['accounts'] = AccountName::with('startingBalance')->orderBy('name', 'ASC')->get();
        return view('backend.pages.post_payments.add_new_post_payment', $data);
    }

    public function storePostPayment(Request $request)
    {
        // Step 1: Validate the request data
        $validatedData = $request->validate([
            'from_account' => 'required|exists:account_names,id|different:to_account',
            'date' => 'required|date_format:m/d/Y',
            'to_account' => 'required|exists:account_names,id',
            'amount' => 'required|numeric|min:0.01',
            'notes' => 'nullable|string|max:255',
        ]);

        // Step 2: Store the data in the database
        $payment = new PostPayment();
        $payment->from_account = $validatedData['from_account'];
        $payment->date = \Carbon\Carbon::createFromFormat('m/d/Y', $validatedData['date'])->format('Y-m-d');
        $payment->to_account = $validatedData['to_account'];
        $payment->amount = $validatedData['amount'];
        $payment->notes = $validatedData['notes'];
        $payment->created_by = Auth::id();
        $payment->save();

        
        $transection = new Transaction();
        $transection->tranfer_id = $payment->id;
        $transection->date = \Carbon\Carbon::createFromFormat('m/d/Y', $validatedData['date'])->format('Y-m-d');
        $transection->amount = $validatedData['amount'];
        $transection->account_id = $validatedData['from_account'];
        $transection->notes = $validatedData['notes'] ?? null;
        $transection->transaction_status = 4;
        $transection->created_by = Auth::id();
        $transection->save();

        
        $transection = new Transaction();
        $transection->tranfer_id = $payment->id;
        $transection->date = \Carbon\Carbon::createFromFormat('m/d/Y', $validatedData['date'])->format('Y-m-d');
        $transection->amount = $validatedData['amount'];
        $transection->account_id = $validatedData['to_account'];
        $transection->notes = $validatedData['notes'] ?? null;
        $transection->transaction_status = 3;
        $transection->created_by = Auth::id();
        $transection->save();
        
        return redirect('/transfer-funds')->with('success', 'Transfer Funds recorded successfully.');
    }

    public function updatePostPayment(Request $request, $id)
    {
        // Step 1: Validate the request data
        $validatedData = $request->validate([
            'from_account' => 'required|exists:account_names,id|different:to_account',
            'date' => 'required|date_format:m/d/Y',
            'to_account' => 'required|exists:account_names,id',
            'amount' => 'required|numeric|min:0.01',
            'notes' => 'nullable|string|max:255',
        ]);

        // Step 2: Store the data in the database
        $payment = PostPayment::findOrFail($id);
        $payment->from_account = $validatedData['from_account'];
        $payment->date = \Carbon\Carbon::createFromFormat('m/d/Y', $validatedData['date'])->format('Y-m-d');
        $payment->to_account = $validatedData['to_account'];
        $payment->amount = $validatedData['amount'];
        $payment->notes = $validatedData['notes'];
        $payment->updated_by = Auth::id();
        $payment->save();

        
        $transection = Transaction::where('tranfer_id', $payment->id)->where('transaction_status', 4)->first();
        $transection->date = \Carbon\Carbon::createFromFormat('m/d/Y', $validatedData['date'])->format('Y-m-d');
        $transection->amount = $validatedData['amount'];
        $transection->account_id = $validatedData['from_account'];
        $transection->notes = $validatedData['notes'] ?? null;
        $transection->transaction_status = 4;
        $transection->updated_by = Auth::id();
        $transection->save();
        
        $transection = Transaction::where('tranfer_id', $payment->id)->where('transaction_status', 3)->first();
        $transection->tranfer_id = $payment->id;
        $transection->date = \Carbon\Carbon::createFromFormat('m/d/Y', $validatedData['date'])->format('Y-m-d');
        $transection->amount = $validatedData['amount'];
        $transection->account_id = $validatedData['to_account'];
        $transection->notes = $validatedData['notes'] ?? null;
        $transection->transaction_status = 3;
        $transection->updated_by = Auth::id();
        $transection->save();

        return redirect('/transfer-funds')->with('success', 'Transfer Funds recorded successfully.');
    }

    public function editPostPayment($id)
    {
        $data['payment'] = PostPayment::with(['postPaymentsFrom', 'postPaymentsTo'])->findOrFail($id);
        $data['accounts'] = AccountName::with('startingBalance')->orderBy('name', 'ASC')->get();
        return view('backend.pages.post_payments.edit_post_payment', $data);
    }

    public function deletePostPayment($id)
    {
        $payment = PostPayment::findOrFail($id);
        Transaction::where('tranfer_id', $id)->where('transaction_status', 4)->delete();
        Transaction::where('tranfer_id', $id)->where('transaction_status', 3)->delete();

        $payment->delete();
        return redirect()
            ->back()
            ->with(['message' => 'Transfer Funds deleted successfully.']);
    }
}
