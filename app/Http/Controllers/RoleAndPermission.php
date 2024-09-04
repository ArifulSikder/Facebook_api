<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermission extends Controller
{
    public function roleIndex()
    {
        $roles = Role::orderBy('name', 'asc')->paginate(10);
        return view('backend.pages.user.role_and_permission.indexRole', compact('roles'));
    }

    public function storeRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:roles'],
        ]);

        if ($validator->fails()) {
            $notification = [
                'error' => 'Something is wrong. Please Fill all the fill carefully',
            ];

            return redirect()->back()->withErrors($validator)->withInput()->with($notification);
        }
        $role = Role::create(['name' => $request->name]);

        if ($role == true) {
            $notification = [
                'success' => 'Role Created Successfully !',
            ];
        } else {
            $notification = [
                'error' => 'Unfortunately Role Not Created !',
            ];
        }

        return redirect()->back()->with($notification);
    }

    public function updateRole(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255|unique:roles,name,' . $request->id . ',id',
            ],
            [
                'name.required' => 'Please Enter Role Name!',
            ],
        );

        $role = Role::findOrFail($request->id)->update(['name' => $request->name]);

        if ($role == true) {
            $notification = [
                'success' => 'Role Updated Successfully !',
            ];
        } else {
            $notification = [
                'error' => 'Unfortunately Role Not Updated !',
            ];
        }

        return response()->json($notification);
    }

    //permission index
    public function indexPermission()
    {
        //  $permissions = Cache::rememberForever("permissions-data", function () {
        //     return  Permission::with('children')->orderBy('position', 'asc')->get();
        //  });

        $permissions = Permission::with('children', 'parent')->orderBy('position', 'asc')->paginate(50);
        $permission_data = Permission::with('children', 'parent')->orderBy('position', 'asc')->get();
        return view('backend.pages.user.role_and_permission.permission', compact('permissions', 'permission_data'));
    }

    //store permissions
    public function storePermission(Request $request)
    {
        Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
            ],
            [
                'name.required' => 'Permission url is required',
            ],
        )->validate();

        $parent_id = $request->parent_id == null ? 0 : $request->parent_id;

        $permission = Permission::create([
            'name' => $request->name,
            'parent_id' => $parent_id,
        ]);

        if ($permission == true) {
            $notification = [
                'success' => 'Permission Created Successfully !',
            ];
        } else {
            $notification = [
                'error' => 'Unfortunately Permission Not Created !',
            ];
        }
        Cache::forget('permissions-data');
        return redirect()->back()->with($notification);
    }

    //update permissions
    public function updatePermission(Request $request)
    {
        Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
            ],
            [
                'name.required' => 'Permission name is required',
            ],
        )->validate();

        $permission = Permission::findOrFail($request->id)->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id ?? 0,
        ]);

        if ($permission == true) {
            $notification = [
                'success' => 'Permission Updated Successfully !',
            ];
        } else {
            $notification = [
                'error' => 'Unfortunately Permission Not Updated !',
            ];
        }
        Cache::forget('permissions-data');
        return response()->json($notification);
    }

    //sort permissions data
    public function sortPermissionData(Request $request)
    {
        $sortData = Permission::all();
        foreach ($sortData as $sort) {
            foreach ($request->order as $order) {
                if ($order['id'] == $sort->id) {
                    $sort->update(['position' => $order['position']]);
                }
            }
        }
        Cache::forget('permissions-data');
        return response('Update Successfull', 200);
    }

    //give user role
    public function giveUserRole()
    {
        $data['users'] = User::orderBy('name', 'asc')->paginate(10);
        $data['roles'] = Role::orderBy('name', 'asc')->where('name', '!=', 'admin')->get();
        return view('backend.pages.user.role_and_permission.give_role_user', $data);
    }

    //give permission to user
    public function giveUserPermission(Request $request)
    {
        $data['permissions'] = Permission::orderBy('position', 'asc')->where('parent_id', 0)->get();
        $data['roles'] = Role::orderBy('name', 'asc')->where('name', '!=', 'admin')->get();
        $data['users'] = User::orderBy('name', 'asc')->get();
        return view('backend.pages.user.role_and_permission.give_user_permission', $data);
    }

    // update given user role
    public function updateGivenUserRole(Request $request)
    {
        $request->validate(
            [
                'user_id' => 'required|string|integer',
                'role_id' => 'required|string|integer',
            ],
            [
                'user_id.required' => 'User Is Required',
                'role_id.required' => 'Role Is Required',
            ],
        );

        $user = User::findOrFail($request->user_id);
        DB::table('model_has_roles')
            ->where('model_id', $user->id)
            ->delete();
        $role = Role::findOrfail($request->role_id);
        $user->assignRole($role->name);

        if ($user == true) {
            $notification = [
                'success' => 'Given Role Updated Successfully !',
            ];
        } else {
            $notification = [
                'error' => 'Opps! There Is A Problem !',
            ];
        }
        if ($request->without_ajax == 1) {
            return redirect()->back()->with($notification);
        } else {
            return response()->json($notification);
        }
    }

    // store user permission

    public function storeUserPermission(Request $request)
    {
        // Validate the incoming request
        $request->validate(
            [
                'user_id' => 'required|numeric',
                // 'permission_id' => 'required|array',
            ],
            [
                'user_id.required' => 'User Is Required',
                // 'permission_id.required' => 'Permission Is Required',
            ]
        );
    
        // Find the user or fail
        $user = User::findOrFail($request->user_id);
    
        // Retrieve the cart content from the session
        $cartContent = session('cart', []);
    
        if (count($cartContent) > 0) {
            // Delete existing permissions for the user
            DB::table('model_has_permissions')
                ->where('model_id', $request->user_id)
                ->delete();
    
            // Extract permission IDs from the cart content
            $permissions_id = collect($cartContent)
                ->where('id', $request->user_id)
                ->pluck('options.permission_id');
    
            // Assign the permissions to the user
            $user->givePermissionTo($permissions_id);
        } else {
            // If no permissions in the cart, delete existing permissions for the user
            DB::table('model_has_permissions')
                ->where('model_id', $request->user_id)
                ->delete();
        }
    
        // Prepare the notification message
        $notification = $user ? ['success' => 'Given Permission Successfully!'] : ['error' => 'Opps! There Is A Problem!'];
    
        // Redirect back with the notification
        return redirect()->back()->with($notification);
    }
    

    // public function userGivePermissionCheck(Request $request)
    // {
    //     $rolePermissions = Permission::join("model_has_permissions","model_has_permissions.permission_id","=","permissions.id")
    //         ->where("model_has_permissions.model_id", $request->user_id)
    //         ->pluck('model_has_permissions.permission_id');

    //     return response()->json($rolePermissions);

    // }

    public function userGivePermissionCheck(Request $request)
    {
        $permissions = Permission::orderBy('position', 'asc')->get();
        $permission = [];
        foreach ($permissions as $value) {
            $rolePermissions = Permission::join('model_has_permissions', 'model_has_permissions.permission_id', '=', 'permissions.id')
                ->where('model_has_permissions.model_id', $request->user_id)
                ->where('model_has_permissions.permission_id', $value->id)
                ->first();

            $checked = $rolePermissions == null ? false : true;
            $singlePermission = [
                'id' => $value->id,
                'pId' => $value->parent_id,
                'name' => $value->name,
                'open' => true,
                'checked' => $checked,
            ];
            array_push($permission, $singlePermission);
        }

        return response()->json($permission);
    }

    public function userExcessInCard(Request $request)
    {
        // Clear the session cart
        session()->forget('cart');

        // Decode the JSON nodes from the request
        $nodes = json_decode($request->nodes);

        if (count($nodes) > 0) {
            $cart = [];

            // Loop through the nodes and add each item to the cart array
            foreach ($nodes as $value) {
                $cart[] = [
                    'id' => $request->user_id,
                    'name' => 'permission checked',
                    'options' => ['permission_id' => $value->id],
                ];
            }

            // Store the cart data in the session
            session(['cart' => $cart]);
        }

        return response()->json('ok');
    }
}
