<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_admin = Role::create(['name' => 'administrador']);
        $role_revisor = Role::create(['name' => 'revisor']);

        $permission_create_register = Permission::create(['name' => 'create registers']);
        $permission_read_register = Permission::create(['name' => 'read registers']);
        $permission_update_register = Permission::create(['name' => 'update registers']);
        $permission_delete_register = Permission::create(['name' => 'delete registers']);

        $permissions_admin = [$permission_create_register, $permission_read_register, $permission_update_register, $permission_delete_register];
        $permissions_revisor = [$permission_read_register];

        $role_admin->syncPermissions($permissions_admin);
        $role_revisor->syncPermissions($permissions_revisor);
 
    }
}
