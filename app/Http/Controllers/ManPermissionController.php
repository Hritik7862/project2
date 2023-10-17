<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\ManPermission;
use Illuminate\Routing\Controller;

class ManPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //dd($request->all());
       
        $permission = new Permission();
        $permission->name=$request->name;
        $permission->guard_name=$request->guard_name;
        $permission->save();
        
    
        return redirect()->route('manpermissions.index')
                        ->with('success', 'Permission created successfully');
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
        //dd($id);
            $permission = Permission::findOrFail($id);
            return view('permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
 * Update the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function update(Request $request, $id)
{
    //dd($request);
    // Find the permission by ID
    $permission = Permission::findOrFail($id);

    // Update the permission data with the new values from the form
    $permission->name = $request->input('name');
    $permission->guard_name = $request->input('guard_name');
    
    // Save the updated permission
    $permission->save();

    return redirect()->route('manpermissions.index')
->with('success', 'Permission updated successfully');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the permission by ID
        // dd($id);
   
      
    
        $permission = Permission::findOrFail($id);
    
        // Delete the permission
        $permission->delete();
    
        return redirect()->route('manpermissions.index')
        ->with('success','Permission deleted Successfully!');
        
    }
    
}
