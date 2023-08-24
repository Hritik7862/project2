<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TaskController;
use App\Models\Task;

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



Route::get('/user', [UserController::class, 'index'])->name('users.index')->middleware('auth');
Route::delete('/user/{user}', [UserController::class,'destroy'])->name('user.destroy')->middleware('auth');



Route::put('/user/{id}',[ UserController::class,'update'])->name('user.update');
Route::post('/promote-admin', [UserController::class, 'promoteToAdmin'])->name('promote.admin');
Route::get('/admin-listing', [UserController::class,'showAdminListing'])->name('user.admin-listing');

});

 Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('auth');
 Route::post('/register', [RegisterController::class, 'register'])->middleware('auth');


 Route::get('/task/create', [TaskController::class, 'create'])->name('task.create')->middleware('auth');
 Route::post('/task', [TaskController::class, 'store'])->name('task.store')->middleware('auth');
 Route::get('/task', [TaskController::class, 'index'])->name('task.index')->middleware('auth');
 Route::delete('task/{id}', [TaskController::class, 'destroy'])->name('task.destroy')->middleware('auth');
 Route::get('/task/{id}/edit', [TaskController::class ,'edit'])->name('task.edit')->middleware('auth');
 Route::put('/task/{id}', [TaskController::class, 'update'])->name('task.update')->middleware('auth');
Route::get('/projects/getName',[ProjectsController::class,'getName']);
 
Route::resource('/project',ProjectsController::class)->middleware('auth');
Route::post('/project', [ProjectsController::class ,'store'])->name('projects.store')->middleware('auth');
Route::get('/project-index', [ProjectsController::class ,'index'])->name('projects.index')->middleware('auth');
Route::get('/projects/{id}/edit', [ProjectsController::class,'edit'])->name('project-edit')->middleware('auth');
Route::put('/project/{id}', [ ProjectsController::class,'update'])->name('project-update')->middleware('auth');





