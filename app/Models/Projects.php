<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    // Define the fillable attributes
    protected $fillable = [
        'project_name',
        'description',
        'project_start_data',
        'project_delivery_data',
        'project_cost',
        'project_head',
        'project_technologie',
        'project_status',
        'project_members',
        'is_active',
    ];

    // Define the casts for specific attributes
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the project members as an array.
     *
     * @param  string  $value
     * @return array
     */
    public function getProjectMembersAttribute($value)
    {
        return explode(',', $value);
    }

    /**
     * Define the relationship with project head.
     */
    public function projectHead()
    {
        return $this->belongsTo(User::class, 'project_head');
    }

    /**
     * Define the relationship with project members.
     */
 
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

    

}
