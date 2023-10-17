<?php

use App\Models\Task;
use App\Mail\YourTestEmail;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\PhoneAuthController;
use App\Http\Controllers\PermissionController;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ManPermissionController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('/home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::middleware(['auth', 'admin'])->group(function () {

   

   

    Route::get('phone-auth', [PhoneAuthController::class, 'index']);
    Route::get('/user', [UserController::class, 'index'])->name('users.index')->middleware('auth');
    Route::post('permissions/store', [PermissionController::class, 'store'])->name('permissions.store');

    Route::get('/manage-permission', [PermissionController::class, 'index'])->name('manage.permissions');

    Route::post('/assign-roles', [PermissionController::class, 'create'])->name('assign.roles');
    Route::delete('/permissions/delete/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    Route::post('/permissions/assignRoles', [PermissionController::class,'assignRoles'])->name('permissions.assignRoles');


});
Route::group(['middleware' => ['auth']], function() {

 Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('auth');
 Route::post('/register', [RegisterController::class, 'register'])->middleware('auth');




Route::put('/user/{id}',[ UserController::class,'update'])->name('user.update');
Route::post('/promote-admin', [UserController::class, 'promoteToAdmin'])->name('promote.admin');
Route::get('/admin-listing', [UserController::class,'showAdminListing'])->name('user.admin-listing');
Route::delete('/user/{user}', [UserController::class,'destroy'])->name('user.destroy')->middleware('auth');

 Route::get('/task/create', [TaskController::class, 'create'])->name('task.create')->middleware('auth');
 Route::post('/task', [TaskController::class, 'store'])->name('task.store')->middleware('auth');
 Route::get('/task', [TaskController::class, 'index'])->name('task.index')->middleware('auth');
 Route::delete('task/{id}', [TaskController::class, 'destroy'])->name('task.destroy')->middleware('auth');
 Route::get('/task/{id}/edit', [TaskController::class ,'edit'])->name('task.edit')->middleware('auth');
 Route::put('/task/{id}', [TaskController::class, 'update'])->name('task.update')->middleware('auth');
  Route::post('/tasks/{task}/complete', [TaskController::class ,'complete'])->name('task.complete');
  Route::get('remarks', [AdminController::class, 'index'])->name('admin.remarks'); 
// Route::get('admin/remarks/ajax', [AdminController::class, 'index'])->name('admin.remarks.ajax');

Route::get('/projects/getName',[ProjectsController::class,'getName']);
 
Route::resource('/project',ProjectsController::class)->middleware('auth');
Route::post('/project', [ProjectsController::class ,'store'])->name('projects.store')->middleware('auth');
Route::get('/projects-datatable', [ProjectsController::class, 'index'])->name('projects-datatable');
Route::get('/projects/{id}/edit', [ProjectsController::class,'edit'])->name('project-edit')->middleware('auth');
Route::put('/project/{id}', [ ProjectsController::class,'update'])->name('project-update')->middleware('auth');


  
Route::get('/manpermissions', [ManPermissionController::class, 'index'])->name('manpermissions.index')->middleware('auth');
Route::get('/manpermissions/create', [ManPermissionController::class, 'create'])->name('manpermissions.create')->middleware('auth');
Route::post('/manpermissions', [ManPermissionController::class,'store'])->name('manpermissions.store')->middleware('auth');
Route::delete('manpermissions/{id}', [ManPermissionController::class, 'destroy'])->middleware('auth');
Route::get('permissions/{id}/edit', [ManPermissionController::class, 'edit'])->name('permissions.edit')->middleware('auth');
Route::put('/permissions/{id}', [ManPermissionController::class, 'update'])->name('permissions.update')->middleware('auth');

Route::delete('/members/{id}',[ MemberController::class ,'destroy'])->name('members.destroy');
Route::get('/members', [MemberController::class,'index'])->name('members.index');
Route::get('/members/{id}/edit',[ MemberController::class ,'edit'])->name('members.edit');
Route::put('/members/{id}', [MemberController::class , 'update'])->name('members.update');
Route::get('/generate-pdf', [MemberController::class ,'generatePDF'])->name('generate-pdf');

Route::post('/save-completion/{taskId}', [NotificationController::class,'saveTaskCompletion'])->name('saveTaskCompletion');
Route::get('/notifications/{taskId}', [NotificationController::class, 'index'])->name('notifications.index');

// web.php




});

;


Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


Route::get('auth/facebook', [SocialController::class, 'facebookRedirect']);
Route::get('auth/facebook/callback', [SocialController::class, 'facebookCallback']);
 
Route::get('send-mail', [MailController::class, 'index']);

// routes/web.php

Route::get('/profile', [ProfileController::class,'show'])->name('profile');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
// Route::post('/remove-remark/{notificationId}', [NotificationController::class, 'removeRemark']);
Route::post('/mark-as-read/{notificationId}', [NotificationController::class ,'markAsRead'])->name('notifications.markAsRead');;
Route::get('/project-users', [ProjectsController::class ,'showProjectUsers'])->name('project-users');
Route::get('/project-details/{project}', [ProjectsController::class ,'projectDetails'])->name('project-details');
Route::get('/project-details/{id}',[ ProjectsController::class ,'projectDetails'])->name('project-details');
Route::get('/project-details/{projectId}', [ProjectController::class, 'getProjectDetails'])->name('project-details');

Route::get('/messageread/{id}',[NotificationController::class,'markRead']);

