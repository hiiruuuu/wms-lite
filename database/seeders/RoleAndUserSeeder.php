<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache permission
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Buat Roles
        $adminRole = Role::create(['name' => 'admin']);
        $managerRole = Role::create(['name' => 'manager']);
        $staffRole = Role::create(['name' => 'warehouse_staff']);

        // 2. Buat User Admin
        $admin = User::create([
            'name' => 'Admin WMS',
            'email' => 'admin@wms.com',
            'password' => Hash::make('password123'),
        ]);
        $admin->assignRole($adminRole);

        // 3. Buat User Manager
        $manager = User::create([
            'name' => 'Manager Gudang',
            'email' => 'manager@wms.com',
            'password' => Hash::make('password123'),
        ]);
        $manager->assignRole($managerRole);

        // 4. Buat User Staff Gudang
        $staff = User::create([
            'name' => 'Staff Lapangan',
            'email' => 'staff@wms.com',
            'password' => Hash::make('password123'),
        ]);
        $staff->assignRole($staffRole);
    }
}
