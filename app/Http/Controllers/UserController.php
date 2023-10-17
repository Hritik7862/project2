<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use League\Flysystem\Visibility;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
    

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    // Fetch all users
    $users = User::all();

    $regularUsers = $users->where('role', 'user');
    $adminUsers = $users->where('role', 'admin');

    return view('users.index', compact('users'));
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function update(Request $request, $id)
{
    
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'user_name' => 'required|string|max:50|unique:users,user_name,' . $id,
        'email' => 'required|email|max:255|unique:users,email,' . $id,
        'mobile' => 'required|numeric|max:9999999999|unique:users,mobile,' . $id,
        'is_active' => 'required|boolean',
    ]);
    
    // Fetch the user by ID
    $user = User::find($id);

    // Update the user data
    $user->name = $request->input('name');
    $user->user_name = $request->input('user_name');
    $user->email = $request->input('email');
    $user->mobile = $request->input('mobile');
    $user->is_active = $request->input('is_active');

    $user->save();

    return response()->json([
        'name' => $user->name,
        'user_name' => $user->user_name,
        'email' => $user->email,
        'mobile' => $user->mobile,
        'is_active' => $user->is_active,
        'message' => 'User updated successfully.',
    ]);
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        //
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
    public function promoteToAdmin(Request $request)
{
    $userIds = $request->input('users');

    User::whereIn('id', $userIds)->update(['admin' => true]);

    return response()->json(['message' => 'Selected users have been promoted to admin.']);
}


public function showAdminListing()
{
    $adminUsers = User::where('admin', true)->get(); 
    return view('users.admin-listing', compact('adminUsers'));
}

public function updatePermissions(Request $request)
{
    $permissions = $request->input('permissions');

    foreach ($permissions as $roleName => $permissionNames) {
        $role = Role::where('name', $roleName)->first();

        if ($role) {
            $role->syncPermissions($permissionNames);
        }
    }

    return redirect()->route('manage.permissions')->with('success', 'Permissions updated successfully');
}

}




   