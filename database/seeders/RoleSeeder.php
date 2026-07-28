<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Seed the roles and default admin & agent users.
     */
    public function run(): void
    {
        // Create roles (idempotent)
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'customer']);
        Role::firstOrCreate(['name' => 'agent']);

        // Create default admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@swiftdrop.ng'],
            [
                'name'     => 'Admin',
                'phone'    => '+234 800 SWIFT',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('admin');

        // Create default agent user
        $agent = User::firstOrCreate(
            ['email' => 'agent@swiftdrop.ng'],
            [
                'name'     => 'Agent',
                'phone'    => '+234 800 AGENT',
                'password' => Hash::make('password'),
            ]
        );
        $agent->assignRole('agent');
    }
}
