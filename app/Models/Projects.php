<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    protected $fillable = [
        'project_name',
        'description',
        'project_start_date',
        'project_delivery_date',
        'project_cost',
        'project_head',
        'project_technology',
        'project_status',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function projectHead()
    {
        return $this->belongsTo(User::class, 'project_head');
    }

    public function projectMembers()
    {
        return $this->belongsToMany(User::class, 'project_user', 'project_id', 'user_id');
    }

    public function projectUser(){
        return $this->hasMany(ProjectUser::class, 'project_id','id');
     }
     public function User(){
        return $this->belongsToMany(User::class, 'project_user','user_id','id');

     }
     public function users() {
        return $this->belongsToMany(User::class, 'project_user', 'project_id', 'user_id','project_user_table_name');
    }
    public function tasks()
    {
        return $this->hasMany(Task::class, 'project_id');   
    }
}

