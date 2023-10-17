<?php

namespace App\Http\Controllers;
use App\Models\User; 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Projects;
use Illuminate\Support\Facades\Auth;    

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::id();

        $tasks = Task::select('tasks.*')
            ->leftJoin('users as assignedBy', 'tasks.assigned_by', '=', 'assignedBy.id')
            ->leftJoin('users as assignedTo', 'tasks.assigned_to', '=', 'assignedTo.id')
            ->whereNull('assignedBy.deleted_at')
            ->whereNull('assignedTo.deleted_at')
            ->where(function ($query) use ($userId) {
                $query->where('tasks.assigned_by', $userId)
                    ->orWhere('tasks.assigned_to', $userId);
            })
            ->get();
        return view('task.index', compact('tasks'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        
        $projects = Projects::with('projectMembers')->get();
        $users = User::all();

        return view('task.create', compact('projects','users'));
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
            'project_id' => 'required|exists:projects,id', 
            'assigned_by' => 'required|exists:users,id', 
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
        public function complete(Request $request, Task $task)
        {
            $request->validate([
                'remarks' => 'nullable|string',
            ]);
        
            $task->update([
                'is_completed' => !$task->is_completed,
                'remarks' => $request->input('remarks'), 
            ]);
        
            return redirect()->back()->with('success', 'Task marked as completed.');
        }
        
        
        
}







