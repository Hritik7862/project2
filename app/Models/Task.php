<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'assigned_by',
        'assigned_to',
        'description',
        'task_datetime',
        'task_name',
        'task_status',
        'is_active',
    ];
    
    public function project()
    {
        return $this->belongsTo(Projects::class,'project_id','id');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by', 'id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to' , 'id');
    }
}
