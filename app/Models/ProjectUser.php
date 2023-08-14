<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectUser extends Model
{
    protected $fillable = [
        'project_id',
        'user_id'
    ];
    
    protected $table = 'project_user';
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

    }
    public function projectMembers()
{
    return $this->hasMany(ProjectUser::class, 'project_id');
}


}
