<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'patient-list',
            'patient-create',
            'patient-edit',
            'patient-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'service-list',
            'service-create',
            'service-edit',
            'service-delete',
            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'patientservices-list',
            'patientservices-create',
         ];
 
 
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
    }
}
