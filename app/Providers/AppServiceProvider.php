<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AppServiceProvider extends ServiceProvider
{
    // ...

    public function boot()
    {
        // Define roles if they don't exist
        Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        // ... Define other roles

        // Define permissions if they don't exist
        Permission::firstOrCreate(['name' => 'edit projects', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'delete projects', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'create projects', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'index projects', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'promote users to admin', 'guard_name' => 'web']);

        // Assign permissions to roles
        $superadmin = Role::findByName('superadmin');
        $superadmin->syncPermissions(Permission::all());

        $admin = Role::findByName('admin');
        $admin->givePermissionTo(['edit projects', 'delete projects']);

        $user = Role::findByName('user');
        $user->givePermissionTo('index projects' );
        Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        // ... Define other roles
        $superadmin = Role::findByName('superadmin');
       $superadmin->givePermissionTo('promote users to admin');


        // Define permissions if they don't exist
        Permission::firstOrCreate(['name' => 'edit tasks', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'delete tasks', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'create tasks', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'index tasks', 'guard_name' => 'web']);
        // ... Define other permissions

        // Assign permissions to roles
        $superadmin = Role::findByName('superadmin');
        $superadmin->syncPermissions(Permission::all());

        $admin = Role::findByName('admin');
        $admin->givePermissionTo(['edit tasks', 'delete tasks']);

        $user = Role::findByName('user');
        $user->givePermissionTo('index tasks');
    }
}