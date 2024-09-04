<?php

namespace App\Http\Controllers;

use App\Models\AccountName;
use App\Models\Earning;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\PostPayment;
use App\Models\StartingBalance;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        return view('backend.pages.account.index');
    }
    public function accountData(Request $request)
    {
        // Fetch accounts with their starting balance
        $accounts = AccountName::with('startingBalance')->orderBy('name', 'asc');

        return DataTables::of($accounts)
            ->filter(function ($query) use ($request) {
                if ($request->has('search.value')) {
                    $searchValue = $request->input('search.value');
                    $query->where('name', 'like', "%{$searchValue}%")->orWhereHas('startingBalance', function ($q) use ($searchValue) {
                        $q->where('amount', 'like', "%{$searchValue}%");
                    });
                }
            })
            ->addColumn('name', function ($account) {
                return $account->name;
            })
            ->addColumn('starting_balance', function ($account) {
                return "$" . number_format($account->startingBalance ? $account->startingBalance->amount : 0, 2, '.', '');
            })
            ->addColumn('actions', function ($account) {
                if (Auth::user()->can('Edit Account')) {
                    $data['edit'] = url('edit-account/' . $account->id);
                }
                if (Auth::user()->can('Delete Account')) {
                    $data['delete'] = url('delete-account/' . $account->id);
                }
                return view('backend.includes.actions', $data)->render();
            })
            ->rawColumns(['starting_balance', 'actions'])
            ->make(true);
    }

    public function addAccount()
    {
        return view('backend.pages.account.add_account');
    }

    public function storeAccount(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:256|unique:account_names',
            'balance' => 'required|numeric|min:0',
        ];

        $messages = [
            'name.required' => 'The name field is mandatory.',
            'name.string' => 'The name must be a valid string.',
            'name.max' => 'The name may not be greater than 256 characters.',
            'balance.required' => 'The balance field is mandatory.',
            'balance.numeric' => 'The balance must be a number.',
            'balance.min' => 'The balance must be at least 0.',
        ];

        $validatedData = $request->validate($rules, $messages);

        $account = new AccountName();
        $account->name = $validatedData['name'];
        $account->created_by = Auth::id();
        $account->save();

        if ($account) {
            $startingBalance = new StartingBalance();
            $startingBalance->date = Carbon::now();
            $startingBalance->amount = $validatedData['balance'];
            $startingBalance->account_id = $account->id;
            $startingBalance->created_by = Auth::id();
            $startingBalance->save();

            $transection = new Transaction();
            $transection->starting_balance_id = $startingBalance->id;
            $transection->date = Carbon::now();
            $transection->amount = $validatedData['balance'];
            $transection->account_id = $account->id;
            $transection->notes = 'Staring Balance';
            $transection->transaction_status = 5;
            $transection->created_by = Auth::id();
            $transection->save();
        }

        return redirect()
            ->back()
            ->with(['success' => 'Accout successfully added.']);
    }

    public function updateAccount(Request $request, $id)
    {
        $rules = [
            'name' => 'required|string|max:256|unique:account_names,name,' . $id,
            'balance' => 'required|numeric|min:0',
        ];

        $messages = [
            'name.required' => 'The name field is mandatory.',
            'name.string' => 'The name must be a valid string.',
            'name.max' => 'The name may not be greater than 256 characters.',
            'balance.required' => 'The balance field is mandatory.',
            'balance.numeric' => 'The balance must be a number.',
            'balance.min' => 'The balance must be at least 0.',
        ];

        $validatedData = $request->validate($rules, $messages);

        $account = AccountName::findOrFail($id);
        $account->name = $validatedData['name'];
        $account->created_by = Auth::id();
        $account->save();

        if ($account) {
            $startingBalance = StartingBalance::where('account_id', $account->id)->first();
            $startingBalance->amount = $validatedData['balance'];
            $startingBalance->account_id = $account->id;
            $startingBalance->updated_by = Auth::id();
            $startingBalance->save();

            
            $transection = Transaction::where('starting_balance_id', $startingBalance->id)->first();
            $transection->starting_balance_id = $startingBalance->id;
            $transection->amount = $validatedData['balance'];
            $transection->account_id = $account->id;
            $transection->notes = 'Staring Balance';
            $transection->transaction_status = 5;
            $transection->updated_by = Auth::id();
            $transection->save();
        }

        return redirect()
            ->back()
            ->with(['success' => 'Accout successfully updated.']);
    }

    public function editAccount($id)
    {
        $data['account'] = AccountName::findOrfail($id);
        return view('backend.pages.account.edit_account', $data);
    }
    public function deleteAccount($id)
    {
        AccountName::findOrfail($id)->delete();
        $startingBalance = StartingBalance::where('account_id', $id)->first();
        Transaction::where('starting_balance_id', $startingBalance->id)->delete();
        $startingBalance->delete();
        return redirect()
            ->back()
            ->with(['message' => 'Account deleted successfully.']);
    }

    public function indexPostOffering()
    {
        return view('backend.pages.post_offering.index_offering');
    }

    public function addNewPostOffering()
    {
        $data['payment_types'] = PaymentType::orderBy('payment_type_name', 'ASC')->get();
        $data['accounts'] = AccountName::with('startingBalance')->orderBy('name', 'ASC')->get();
        $data['members'] = User::orderBy('name', 'asc')->get();
        return view('backend.pages.post_offering.post_offering', $data);
    }

    public function editEmaring($id)
    {
        $data['earning'] = Earning::findOrfail($id);
        $data['payment_types'] = PaymentType::orderBy('payment_type_name', 'ASC')->get();
        $data['accounts'] = AccountName::with('startingBalance')->orderBy('name', 'ASC')->get();
        $data['members'] = User::orderBy('name', 'asc')->get();

        return view('backend.pages.post_offering.edit_offering', $data);
    }
    public function getDataEarning(Request $request)
    {
        $searchValue = $request->input('search.value'); // Get search value

        // Eager load relationships and prepare the query
        $earnings = Earning::with(['member', 'paymentType', 'account'])
            ->select(['id', 'date', 'amount', 'check_number', 'type_id', 'account_id', 'created_by', 'member_id'])
            ->orderBy('date', 'desc'); // Use column 'date' directly

        // Apply search filter if needed
        if (!empty($searchValue)) {
            $searchId = memberId($searchValue);
            $earnings->where(function ($query) use ($searchValue, $searchId) {
                $query
                    ->whereHas('member', function ($q) use ($searchValue, $searchId) {
                        $q->where('id', 'like', "%{$searchId}%");
                    })
                    ->orWhere('amount', 'like', "%{$searchValue}%")
                    ->orWhere('check_number', 'like', "%{$searchValue}%")
                    ->orWhereHas('paymentType', function ($q) use ($searchValue) {
                        $q->where('payment_type_name', 'like', "%{$searchValue}%");
                    })
                    ->orWhereHas('account', function ($q) use ($searchValue) {
                        $q->where('name', 'like', "%{$searchValue}%");
                    })
                    ->orWhereRaw("DATE_FORMAT(date, '%m-%d-%Y') LIKE ?", ["%{$searchValue}%"]);
            });
        }

        // Generate the DataTable
        return DataTables::of($earnings)
            ->addColumn('member_name', function ($earning) {
                return encriptMemberId($earning->member_id);
            })
            ->addColumn('date', function ($earning) {
                return Carbon::parse($earning->date)->format('m-d-Y');
            })
            ->addColumn('amount', function ($earning) {
                return "$" . number_format($earning->amount, 2);
            })
            ->addColumn('payment_type', function ($earning) {
                return $earning->paymentType->payment_type_name ?? 'N/A';
            })
            ->addColumn('check_number', function ($earning) {
                return $earning->check_number ?? 'N/A';
            })
            ->addColumn('account_name', function ($earning) {
                return $earning->account->name ?? 'N/A';
            })
            ->addColumn('actions', function ($earning) {
                if (Auth::user()->can('Edit Offering')) {
                    $data['edit'] = url('edit-earning/' . $earning->id);
                }
                if (Auth::user()->can('Delete Offering')) {
                    $data['delete'] = url('delete-earning/' . $earning->id);
                }
                return view('backend.includes.actions', $data)->render();
            })
            ->rawColumns(['member_name', 'actions'])
            ->make(true);
    }
    public function addOfferingAjax(Request $request)
    {
        $data['id'] = $request->id;
        $data['payment_types'] = PaymentType::orderBy('payment_type_name', 'ASC')->get();
        $data['accounts'] = AccountName::with('startingBalance')->orderBy('name', 'ASC')->get();
        $view = View::make('backend.pages.post_offering.add_offering_ajax', $data)->render();
        return response()->json(['html' => $view]);
    }

    public function storePostOffering(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'member' => 'required|exists:users,id',
            'date' => 'required|date_format:m/d/Y',
            'amount.*' => 'required|numeric|min:0',
            'account.*' => 'required|exists:account_names,id',
            'type.*' => 'required|exists:payment_types,id',
            'check_number.*' => 'nullable|string|max:255',
        ]);

        // Convert date format
        $date = Carbon::createFromFormat('m/d/Y', $validatedData['date'])->format('Y-m-d');

        // Loop through each amount and create an Earning record
        foreach ($validatedData['amount'] as $index => $amount) {
            $earning = new Earning();
            $earning->member_id = $validatedData['member'];
            $earning->date = $date;
            $earning->amount = $amount;
            $earning->check_number = $validatedData['check_number'][$index] ?? null;
            $earning->type_id = $validatedData['type'][$index];
            $earning->account_id = $validatedData['account'][$index];
            $earning->created_by = Auth::id();
            $earning->save();

            $transection = new Transaction();
            $transection->member_id = $validatedData['member'];
            $transection->post_offering_id = $earning->id;
            $transection->date = $date;
            $transection->amount = $amount;
            $transection->check_number = $validatedData['check_number'][$index] ?? null;
            $transection->type_id = $validatedData['type'][$index];
            $transection->account_id = $validatedData['account'][$index];
            $transection->transaction_status = 1;
            $transection->created_by = Auth::id();
            $transection->save();
        }

        return redirect('/add-new-post-offering')->with('success', 'Earnings have been successfully stored.');
    }

    public function updatePostOffering(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'member' => 'required|exists:users,id',
            'date' => 'required|date_format:m/d/Y',
            'amount' => 'required|numeric|min:0',
            'account' => 'required|exists:account_names,id',
            'type' => 'required|exists:payment_types,id',
            'check_number' => 'nullable|string|max:255',
        ]);

        // Convert date format
        $date = Carbon::createFromFormat('m/d/Y', $validatedData['date'])->format('Y-m-d');

        $earning = Earning::findOrFail($id);
        $earning->member_id = $validatedData['member'];
        $earning->date = $date;
        $earning->amount = $request->amount;
        $earning->check_number = $validatedData['check_number'] ?? null;
        $earning->type_id = $validatedData['type'];
        $earning->account_id = $validatedData['account'];
        $earning->updated_by = Auth::id();
        $earning->save();

        return redirect('/post-offering')->with('success', 'Earnings have been successfully stored.');
    }

    public function deletePostOffering($id)
    {
        Earning::findOrfail($id)->delete();

        return redirect()
            ->back()
            ->with(['message' => 'Post Offering deleted successfully.']);
    }
    public function storePaymentWithdrawal(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'payable_to' => 'required|string|max:255',
            'date' => 'required|date_format:m/d/Y', // Ensure this matches your DB format
            'amount' => 'required|numeric|min:0',
            'from_account' => 'required|integer|exists:account_names,id',
            'type' => 'required|integer|exists:payment_types,id',
            'check_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:999', // Align with your schema's length
        ]);

        $payment = new Payment();

        $payment->payable_to = $validatedData['payable_to']; // Corresponds to 'payable_to'
        $payment->date = \Carbon\Carbon::createFromFormat('m/d/Y', $validatedData['date'])->format('Y-m-d');
        $payment->amount = $validatedData['amount'];
        $payment->from_account = $validatedData['from_account']; // Corresponds to 'from_account'
        $payment->type_id = $validatedData['type']; // Corresponds to 'type_id'
        $payment->check_number = $validatedData['check_number'] ?? null;
        $payment->notes = $validatedData['notes'] ?? null;
        $payment->created_by = Auth::id();
        $payment->save();

        $transection = new Transaction();
        $transection->payable_to = $validatedData['payable_to'];
        $transection->payment_id = $payment->id;
        $transection->date = \Carbon\Carbon::createFromFormat('m/d/Y', $validatedData['date'])->format('Y-m-d');
        $transection->amount = $validatedData['amount'];
        $transection->check_number = $validatedData['check_number'] ?? null;
        $transection->type_id = $validatedData['type'];
        $transection->account_id = $validatedData['from_account'];
        $transection->notes = $validatedData['notes'] ?? null;
        $transection->transaction_status = 2;
        $transection->created_by = Auth::id();
        $transection->save();

        return redirect()->route('payment-withdrawal')->with('success', 'Payment record created successfully.');
    }

    public function getDataPayment(Request $request)
    {
        $searchValue = $request->input('search.value'); // Get search value

        $payments = Payment::with(['type', 'Account']) // Eager load relationships
            ->select(['id', 'payable_to', 'date', 'amount', 'type_id', 'from_account', 'check_number', 'notes'])
            ->orderBy('date', 'desc');

        if (!empty($searchValue)) {
            $payments->where(function ($query) use ($searchValue) {
                $query
                    ->where('amount', 'like', "%{$searchValue}%")
                    ->orWhere('payable_to', 'like', "%{$searchValue}%")
                    ->orWhereHas('type', function ($q) use ($searchValue) {
                        $q->where('payment_type_name', 'like', "%{$searchValue}%");
                    })
                    ->orWhereHas('Account', function ($q) use ($searchValue) {
                        $q->where('name', 'like', "%{$searchValue}%");
                    })
                    ->orWhere('check_number', 'like', "%{$searchValue}%")
                    ->orWhere('notes', 'like', "%{$searchValue}%");

                try {
                    $date = Carbon::createFromFormat('m-d-Y', $searchValue)->format('Y-m-d');
                    $query->orWhere('date', 'like', "%{$date}%");
                } catch (\Exception $e) {
                    // If the search value is not a valid date in the expected format, skip this condition
                }
            });
        }

        return DataTables::of($payments)
            ->addColumn('payable_to', function ($payment) {
                return $payment->payable_to; // Use the relationship to get the name of the payable user
            })
            ->addColumn('date', function ($payment) {
                return formatedDate($payment->date); // Format the date as needed
            })
            ->addColumn('amount', function ($payment) {
                return "$" . number_format($payment->amount, 2); // Format the amount as a decimal
            })
            ->addColumn('type.payment_type_name', function ($payment) {
                return $payment->type ? $payment->type->payment_type_name : ''; // Use the relationship to get the payment type name
            })
            ->addColumn('from_account.name', function ($payment) {
                return $payment->Account->name; // Use the relationship to get the account name
            })
            ->addColumn('check_number', function ($payment) {
                return $payment->check_number ?? 'N/A'; // Show the check number
            })
            ->addColumn('notes', function ($payment) {
                return $payment->notes; // Show the notes
            })
            ->addColumn('actions', function ($payment) {
                if (Auth::user()->can('Edit Payment')) {
                    $data['edit'] = url('edit-payment/' . $payment->id);
                }
                if (Auth::user()->can('Delete Payment')) {
                    $data['delete'] = url('delete-payment/' . $payment->id);
                }
                return view('backend.includes.actions', $data)->render();
            })
            ->rawColumns(['actions']) // Mark the actions column that contains HTML as raw
            ->make(true);
    }

    public function indexPayment()
    {
        return view('backend.pages.accounts_payable.index');
    }
    public function paymentWithdrawal()
    {
        $data['payment_types'] = PaymentType::orderBy('payment_type_name', 'ASC')->get();
        $data['accounts'] = AccountName::with('startingBalance')->orderBy('name', 'ASC')->get();
        $data['members'] = User::orderBy('name', 'asc')->get();
        return view('backend.pages.accounts_payable.payment_withdrawal', $data);
    }

    public function editPayment($id)
    {
        $data['payment'] = Payment::findOrFail($id);
        $data['payment_types'] = PaymentType::orderBy('payment_type_name', 'ASC')->get();
        $data['accounts'] = AccountName::with('startingBalance')->orderBy('name', 'ASC')->get();
        $data['members'] = User::orderBy('name', 'asc')->get();
        return view('backend.pages.accounts_payable.edit_payment', $data);
    }

    public function updatePaymentWithdrawal(Request $request, $id)
    {
        $validatedData = $request->validate([
            'payable_to' => 'required|string|max:255',
            'date' => 'required|date_format:m/d/Y', // Ensure this matches your DB format
            'amount' => 'required|numeric|min:0',
            'from_account' => 'required|integer|exists:account_names,id',
            'type' => 'required|integer|exists:payment_types,id',
            'check_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:999', // Align with your schema's length
        ]);

        $payment = Payment::findOrfail($id);

        $payment->payable_to = $validatedData['payable_to']; // Corresponds to 'payable_to'
        $payment->date = \Carbon\Carbon::createFromFormat('m/d/Y', $validatedData['date'])->format('Y-m-d');
        $payment->amount = $validatedData['amount'];
        $payment->from_account = $validatedData['from_account']; // Corresponds to 'from_account'
        $payment->type_id = $validatedData['type']; // Corresponds to 'type_id'
        $payment->check_number = $validatedData['check_number'] ?? null;
        $payment->notes = $validatedData['notes'] ?? null;
        $payment->created_by = Auth::id();
        $payment->save();

        $transection = Transaction::where('payment_id', $payment->id)->first();
        $transection->payable_to = $validatedData['payable_to'];
        $transection->date = \Carbon\Carbon::createFromFormat('m/d/Y', $validatedData['date'])->format('Y-m-d');
        $transection->amount = $validatedData['amount'];
        $transection->check_number = $validatedData['check_number'] ?? null;
        $transection->type_id = $validatedData['type'];
        $transection->account_id = $validatedData['from_account'];
        $transection->notes = $validatedData['notes'] ?? null;
        $transection->transaction_status = 2;
        $transection->created_by = Auth::id();
        $transection->save();

        return redirect()->route('payment-withdrawal')->with('success', 'Payment record Updated successfully.');
    }

    public function deletePayment($id)
    {
        $payment = Payment::findOrfail($id)->delete();
        $transection = Transaction::where('payment_id', $id)->delete();

        return redirect()
            ->back()
            ->with(['message' => 'Payment deleted successfully.']);
    }

    public function amountCheckFromAccount(Request $request)
    {
        $earning = Earning::where('account_id', $request->account_id)->sum('amount');
        $payment = Payment::where('from_account', $request->account_id)->sum('amount');
        $startingBalance = StartingBalance::where('account_id', $request->account_id)->sum('amount');
        $transferAmount = PostPayment::where('from_account', $request->account_id)->sum('amount');
        $addAmmount = PostPayment::where('to_account', $request->account_id)->sum('amount');

        $availableBalance = $startingBalance + $earning - $payment - $transferAmount + $addAmmount;
        return response()->json(['available_balance' => $availableBalance]);
    }
}
