<?php

namespace App\Http\Controllers;

use App\Models\AccountName;
use App\Models\Earning;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Yajra\DataTables\DataTables;

class MemberController extends Controller
{
    public function index()
    {
        $data['members'] = User::orderBy('name', 'asc')->get();
        return view('backend.pages.members.index', $data);
    }

    public function getData(Request $request)
    {
        $searchValue = $request->input('search.value'); // Get search value
        $members = User::select(['id', 'name', 'address', 'birthday', 'phone', 'city', 'state', 'zip'])
            ->orderBy('name', 'asc');
    
            if (!empty($searchValue)) {
                $id = memberId($searchValue);
                $members->where(function ($query) use ($searchValue, $id) {
                    $query->where('name', 'like', "%{$searchValue}%")
                        ->orWhere('id', 'like', "%{$id}%")
                        ->orWhere('address', 'like', "%{$searchValue}%");
                        
                        try {
                            $birthday = Carbon::createFromFormat('m-d-Y', $searchValue)->format('Y-m-d');
                            $query->orWhere('birthday', 'like', "%{$birthday}%");
                        } catch (\Exception $e) {
                            // If the search value is not a valid date in the expected format, skip this condition
                        }

                        $query->orWhere('phone', 'like', "%{$searchValue}%")
                        ->orWhereRaw("
                            CONCAT(
                                address, '<br/>', 
                                COALESCE(city, ''), 
                                CASE WHEN city != '' AND (state != '' OR zip != '') THEN ', ' ELSE '' END, 
                                COALESCE(state, ''), 
                                CASE WHEN state != '' AND zip != '' THEN ' ' ELSE '' END, 
                                COALESCE(zip, '')
                            ) LIKE ?
                        ", ["%{$searchValue}%"]) // Concatenate address fields with HTML formatting for search
                        ->orWhereRaw("CONCAT('prefix-', id) LIKE ?", ["%{$searchValue}%"]); // Example for custom member_id search
                });
            }
        return DataTables::of($members)
            ->addColumn('member_id', function ($member) {
                return $member->getMemberId();
            })
            ->addColumn('name', function ($member) {
                return '<a href="' . url('members/payment-log/' . $member->getMemberId()) . '">' . $member->name . '</a>';
            })
            ->addColumn('address', function ($member) {
                return $member->address . "<br/>" . $member->city . ", " . $member->state . " " . $member->zip;
            })
            ->addColumn('birthday', function ($member) {
                return formatedDate($member->birthday);
            })
            ->addColumn('phone', function ($member) {
                return $member->phone;
            })
            ->addColumn('actions', function ($member) {
                if(Auth::user()->can('Edit Member'))
                {
                    $data['edit'] = url('edit-member/' . $member->id);
                }
                if(Auth::user()->can('Delete Member'))
                {
                    if ($member->getRoleNames()->contains('Admin')) {
                    } else {
                        $data['delete'] = url('delete-member/' . $member->id);
                    }
                }
                return view('backend.includes.actions', $data)->render();
            })
            ->rawColumns(['name', 'actions', 'address']) // Mark the columns that contain HTML as raw
            ->make(true);
    }

    public function addMember()
    {
        return view('backend.pages.members.add_member');
    }

    public function storeMember(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:256',
            'birthday' => 'required|string|max:256',
            'address' => 'required|string|max:256',
            'city' => 'required|string|max:256',
            'state' => 'required|string|max:256',
            'zip' => 'required|string|max:256',
            'phone' => ['sometimes', 'string', 'max:256', 'unique:' . User::class, 'required_without:email'],
            'email' => ['sometimes', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class, 'required_without:phone'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
        
        $messages = [
            'name.required' => 'The name field is required.',
            'birthday.required' => 'The birthday field is required.',
            'address.required' => 'The address field is required.',
            'city.required' => 'The city field is required.',
            'state.required' => 'The state field is required.',
            'zip.required' => 'The zip code field is required.',
            'phone.required_without' => 'The phone field is required when the email is not provided.',
            'email.required_without' => 'The email field is required when the phone is not provided.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'The password field is required.',
            'password.confirmed' => 'The password confirmation does not match.',
            'string' => 'The :attribute field must be a string.',
            'max' => 'The :attribute may not be greater than :max characters.',
        ];
        
        // Validate the request
        $validatedData = $request->validate($rules, $messages);
        

        // Create a new user with the validated data
        $user = new User();
        $user->name = $validatedData['name'];
        $user->birthday = Carbon::parse($validatedData['birthday']);
        $user->address = $validatedData['address'];
        $user->city = $validatedData['city'];
        $user->state = $validatedData['state'];
        $user->zip = $validatedData['zip'];
        $user->phone = $validatedData['phone'] ?? null;
        $user->email = $validatedData['email'] ?? null;
        $user->role = $validatedData['role'] ?? null;
        $user->password = Hash::make($validatedData['password']);

        // Save the new user to the database
        $user->save();
        // Redirect with a success message
        return redirect()->route('members')->with('success', 'Member has been successfully added.');
    }

    public function editMember($id)
    {
        $data['member'] = User::findOrFail($id);
        return view('backend.pages.members.edit_member', $data);
    }

    public function updateMember(Request $request, $id)
    {
        // Define validation rules and messages
        $rules = [
            'name' => 'required|string|max:256',
            'birthday' => 'required|string|max:256',
            'address' => 'required|string|max:256',
            'city' => 'required|string|max:256',
            'state' => 'required|string|max:256',
            'zip' => 'required|string|max:256',
            'phone' => [
                'sometimes',
                'string',
                'max:256',
                'regex:/^(\+?[\d\s\-()]+)$/', // Basic phone number validation
                'unique:' . User::class . ',phone,' . $id, // Exclude the current user ID
                'required_without:email',
            ],
            'email' => [
                'sometimes',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:' . User::class . ',email,' . $id, // Exclude the current user ID
                'required_without:phone',
            ],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ];

        $messages = [
            'name.required' => 'The name field is required.',
            'birthday.required' => 'The birthday field is required.',
            'address.required' => 'The address field is required.',
            'city.required' => 'The city field is required.',
            'state.required' => 'The state field is required.',
            'zip.required' => 'The zip code field is required.',
            'phone.required_without' => 'The phone field is required when the email is not provided.',
            'phone.regex' => 'Please provide a valid phone number.',
            'phone.unique' => 'This phone number is already registered.',
            'email.required_without' => 'The email field is required when the phone is not provided.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.confirmed' => 'The password confirmation does not match.',
            'string' => 'The :attribute field must be a string.',
            'max' => 'The :attribute may not be greater than :max characters.',
        ];

        // Validate the request
        $validatedData = $request->validate($rules, $messages);

        // Assuming you have a User model or similar model for members
        $member = User::findOrFail($id);

        // Update member attributes with validated data
        $member->name = $validatedData['name'];
        $member->birthday = Carbon::parse($validatedData['birthday']);
        $member->address = $validatedData['address'];
        $member->city = $validatedData['city'];
        $member->state = $validatedData['state'];
        $member->zip = $validatedData['zip'];
        $member->phone = $validatedData['phone'] ?? $member->phone; // Only update if provided
        $member->email = $validatedData['email'] ?? $member->email; // Only update if provided

        // Update password only if provided
        if (!empty($validatedData['password'])) {
            $member->password = bcrypt($validatedData['password']);
        }

        // Save the updated member
        $member->save();

        // Return a success response or redirect
        return redirect()
            ->route('members')
            ->with(['message' => 'Member updated successfully.']);
    }

    public function deleteMember($id)
    {
        $earning = Earning::where('member_id', $id)->first();
        if (!$earning) {
            $member = User::findOrFail($id);
            $member->delete();
            
            return redirect()
            ->back()
            ->with(['message' => 'Member deleted successfully.']);
        } 

        
        return redirect()
        ->back()
        ->with(['message' => 'Member is not deletable.']);
    }

    public function membersPaymentLog(Request $request, $id)
    {
        $data['member'] = User::findOrFail(memberId($id));
        $account = $request->input('account');
        $dateRange = $request->input('from_and_to_date');
        $query = Earning::with('member', 'paymentType', 'account')->where('member_id', memberId($id))->orderBy('date', 'desc');

        if ($account) {
            $query->where('account_id', $account);
        }

        if ($dateRange) {
            [$startDate, $endDate] = explode(' - ', $dateRange);
            $startDate = Carbon::createFromFormat('m/d/Y', $startDate)->startOfDay();
            if (strtolower($endDate) === 'current') {
                $endDate = Carbon::now()->endOfDay();
            } else {
                $endDate = Carbon::createFromFormat('m/d/Y', $endDate)->endOfDay();
            }
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        $data['earnings'] = $query->get();
        $data['accounts'] = AccountName::with('startingBalance', 'earnings')->orderBy('name', 'ASC')->get();
        return view('backend.pages.members.payment_log', $data);
    }

}
