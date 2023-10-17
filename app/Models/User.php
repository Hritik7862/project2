<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Projects;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , SoftDeletes, HasRoles; 
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_name',
        'email',
        'password',
        'mobile',
        'is_active',
        'admin',
        'gauth_id',
        'gauth_type',
        'fb_id',
        'profile_picture',
        'isVerified'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function projects()
    {
        return $this->belongsToMany(Projects::class, 'project_user', 'user_id', 'project_id' );
    }
    // public function Admin()
    // {
    //     return $this->admin === 1; 
    // }
    public function isAdmin()
    {
        return $this->hasRole('admin') || $this->hasRole('superadmin');
    }
    
public function isSuperAdmin()
{
    return $this->role === 'superadmin'; 
}


}



