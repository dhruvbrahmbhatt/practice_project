<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::firstOrCreate(['name' => 'create project']);
        Permission::firstOrCreate(['name' => 'edit task']);
        Permission::firstOrCreate(['name' => 'view kanban']);

        // Create roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $manager = Role::firstOrCreate(['name' => 'manager']);
        $user = Role::firstOrCreate(['name' => 'user']);

        // Assign permissions
        $admin->givePermissionTo(Permission::all());

        $manager->givePermissionTo(['create project', 'view kanban']);
        $user->givePermissionTo(['view kanban']);
    }
}
