<?php

namespace Database\Seeders;


use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;


class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $homeownerRole = Role::firstOrCreate(['name' => 'homeowner']);
        $tradespersonRole = Role::firstOrCreate(['name' => 'tradesperson']);

        // Admin User (only create if not exists)
        $adminEmail = 'admin@gmail.com';
        $adminUser = User::firstOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Admin User',
                'password' => Hash::make('123456789'),
            ]
        );

        // Assign admin role
        $adminUser->assignRole($adminRole);
    }
}
