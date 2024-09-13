<?php

namespace Database\Seeders;

use App\Models\Api\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the user
        $user = User::create([
            'name' => 'Muhammed Salama',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456')
        ]);

        // Create Admin role if it doesn't exist
        $role = Role::firstOrCreate(['name' => 'Admin']);

        // Define permissions
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete'
        ];

        // Create permissions if they do not exist
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Sync all permissions to the Admin role
        $role->syncPermissions(Permission::all());

        // Assign the Admin role to the user
        $user->assignRole('Admin');
    }
}
