<?php

namespace App\Models;

use App\Models\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = ['task_id', 'remark', 'is_completed', 'read'];

    public function task()
{
    return $this->belongsTo(Task::class)->with('assignedTo' ,'assignedBy');
} 


}



