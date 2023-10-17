<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'project-list',
            'project-create',
            'project-edit',
            'project-delete'
            
 
         ];
      
         foreach ($permission as $permissions) {
              Permission::create(['name' => $permissions]);
         }
    }
}
