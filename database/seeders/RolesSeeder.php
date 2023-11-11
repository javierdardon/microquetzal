<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_admin = Role::create(['name' => 'admin']);
        $role_standard = Role::create(['name' => 'standard']);

        $permission_manage = Permission::create(['name' => 'manage website']);
        $permission_visit = Permission::create(['name' => 'visit website']);

        $permissions_admin = [$permission_manage];

        $role_admin->syncPermissions($permissions_admin);
        $role_standard->givePermissionTo($permission_visit);
    }
}
