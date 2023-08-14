<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Projects;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks=task::all();
        return view('task.index' ,compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $projects = Projects::all();

        // Fetch all users to populate the "Assign By" and "Assign To" dropdowns
        $users = User::all();

        return view('task.create', compact('projects', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function store(Request $request)
     {
       
        $rules = [
            'project_id' => 'required|exists:projects,id', // Assuming projects table has a column 'id'
            'assigned_by' => 'required|exists:users,id', // Assuming users table has a column 'id'
            'assigned_to' => 'required|exists:users,id',
            'description' => 'required|string',
            'task_datetime' => 'required|date',
            'task_name' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ];
            // dd($request->all());
        // Custom error messages (optional)
        $customMessages = [
            // Add any custom error messages here if needed
        ];

        // Validate the form data
        $validatedData = $request->validate($rules, $customMessages);

        $task = new Task();
        $task->project_id = $validatedData['project_id'];
        $task->assigned_by = $validatedData['assigned_by'];
        $task->assigned_to = $validatedData['assigned_to'];
        $task->description = $validatedData['description'];
        $task->task_datetime = $validatedData['task_datetime'];
        $task->task_name = $validatedData['task_name'];
        $task->is_active = $validatedData['is_active'];
        $task->save();

        return redirect()->route('task.index')->with('success', 'Task created successfully!');
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
    $task = Task::findOrFail($id);
    $projects = Projects::all();
    $users = User::all();

    return view('task.edit', compact('task', 'projects', 'users'));
}

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id )
    {
        //
        $task = Task::findOrFail($id);

        $rules = [
            'project_id' => 'required|exists:projects,id',
            'assigned_by' => 'required|exists:users,id',
            'assigned_to' => 'required|exists:users,id',
            'description' => 'required|string',
            'task_datetime' => 'required|date',
            'task_name' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ];
    
        $validatedData = $request->validate($rules);
    
        $task->update($validatedData);
    
        return redirect()->route('task.index')->with('success', 'Task updated successfully!');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  
        public function destroy($id)
        {
            $task = Task::findOrFail($id);
        
            if ($task->delete()) {
                return response()->json(['message' => 'Task deleted successfully.']);
            } else {
                return response()->json(['message' => 'Failed to delete task.'], 500);
            }
        }
   
        
}






