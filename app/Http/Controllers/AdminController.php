<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $adminId = Auth::user()->id;
    
        $remarks = Task::where(function ($query) use ($adminId) {
                $query->where('assigned_by', $adminId)
                      ->orWhere(function ($query) use ($adminId) {
                          $query->where('assigned_to', $adminId)
                                ->where('assigned_by', '<>', $adminId);
                      });
            })
            ->whereNotNull('remarks')->with('assignedTo')
            ->get();

        // $remarks=Task::with('')->where('assigned_to',$adminId)->orWhere('assigned_by',$adminId)->get();
        
        return response()->json($remarks);
    }
    
} 
