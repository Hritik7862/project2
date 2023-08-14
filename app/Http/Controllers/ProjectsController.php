<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Projects;
use App\Models\ProjectUser;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Auth\Events\Validated;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $projects = Projects::with('projectUser')->get();
      // dd($projects[3]->projectUser[1]->project_id);

    // dd($projects);
    $userdata = user::all();
        return view('project.index', compact('projects', 'userdata'));
        
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $userdata = User::all();
        return view('project.create', compact('userdata'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  
     public function store(Request $request)
     {
        
         $project = new Projects();
         $project->project_name = $request->project_name;
         $project->description = $request->description;
         $project->project_start_data = $request->project_start_data;
         $project->project_delivery_data = $request->project_delivery_data;
         $project->project_cost = $request->project_cost;
         $project->project_head = $request->project_head;
         $project->project_technology = $request->project_technology;
         $project->is_active = $request->is_active;
         $project->save();
         
         $projectMembers = explode(',', $request->project_members);
         foreach ($projectMembers as $member) {
             if (!empty($member)) {
                $project->projectMembers()->attach((int)$member);
             }
         }
        //  dd($request->all());

         return redirect()->route('project.index')->with('success', 'Project created successfully!');

     }
     

    // ... Other methods ...


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
        $project = Projects::findOrFail($id);
        $userdata = User::all();
        return view('project.edit', compact('project', 'userdata'));
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
    $project = Projects::findOrFail($id);

    // Update project data
    // dd($request);
    $project->project_name = $request->project_name;
    $project->description = $request->description;
    $project->project_start_data = $request->project_start_data;
    $project->project_delivery_data = $request->project_delivery_data;
    $project->project_cost = $request->project_cost;
    $project->project_head = $request->project_head;
    $project->project_technology = $request->project_technology;
    $project->is_active = $request->is_active;
    $projectMemberIdsString = $request->input('project_members', ''); 
    $projectMemberIdsArray = explode(',', $projectMemberIdsString); 
    $existingUserIds = User::whereIn('id', $projectMemberIdsArray)->pluck('id')->toArray();
    // $project->projectMembers()->sync($existingUserIds);

 
    $project->save();
    
//    $projectMembers = explode(',', $request->project_members);
//          foreach ($projectMembers as $member) {
//              if (!empty($member)) {
//                  $project->projectMembers()->attach((int)$member);
//              }
//          }


    return redirect()->route('project.index')->with('success', 'Project updated successfully!');
}
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $project = Projects::findOrFail($id);
        

        $project->delete();

        return response()->json(['message' => 'Project deleted successfully!']);
    }
}





