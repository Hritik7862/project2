<?php

namespace App\Http\Controllers;
use App\Models\Notification;
use App\Models\Task;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
   
    public function index(Request $request)
{

    if ($request->ajax()){

        $user = Auth::user();

        $notifications = Notification::whereHas('task', function ($query) use ($user) {
            $query->where(function ($subQuery) use ($user) {
                $subQuery->where('assigned_to', $user->id)
                    ->orWhere('assigned_by', $user->id);
            });
        })
        ->with(['task']) 
        ->get();
    
        return response()->json($notifications);

    }
    $user = Auth::user();


    $notifications = Notification::whereHas('task', function ($query) use ($user) {
        $query->where(function ($subQuery) use ($user) {
            $subQuery->where('assigned_to', $user->id)
                ->orWhere('assigned_by', $user->id);
        });
    })
    ->with(['task']) 
    ->get();

    return view('layouts.app',compact($notifications));

}


    
    public function saveTaskCompletion(Request $request, $taskId)
    {
      
        $notification = new Notification;
        $notification->task_id = $taskId;
        $notification->remark = $request->input('remark');
        $notification->is_completed = $request->has('is_completed') ? 1 : 0;
        $notification->read = 0;
        $notification->save();
    
    
        return redirect()->back()->with('success', 'Task completion saved successfully');
    }

    public function markRead(Request $request,$id){

        
        $findid=Notification::find($id);
        $findid->read=1;
        $findid->update();
        return response()->json(['data'=>$findid,'success'=>'data updated successfully']);
    }
   

}




