<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
 
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = \Spatie\Permission\Models\Permission::all();
        return view('permissions.manage', compact('permissions'));
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
        //  dd($request->all());
         $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permissions' => 'required',
        ]);
    
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permissions'));
    
        return redirect()->route('manage.permissions')
                        ->with('success','permission created successfully');

        // $newRoleName = $request->input('new_role');
        // Role::create(['name' => $newRoleName]);

        // return redirect()->route('permissions.index')->with('success', 'New role created successfully.');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    $permission = Permission::findOrFail($id);
    $permission->delete();

    // Retrieve the updated list of permissions
    $permissions = Permission::all();

    // Return the 'permissions.manage' view with the updated data and success message
    return View::make('permissions.manage', ['permissions' => $permissions])->with('success', 'Permission deleted successfully.');
}

public function assignRoles(Request $request)
{
    
    dd($request);
    // $data = [
    //     'permissions' => Permission::all(),
    //     'success' => 'Roles assigned successfully.'
    // ];

    // return view('permissions.manage', $data);
}
}   
