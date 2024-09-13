<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Faker\Factory as Faker;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Create some fake permissions
        for ($i = 0; $i < 10; $i++) {
            $permission = new Permission();
            $permission->name = $faker->unique()->word . '_permission';
            $permission->guard_name = 'api'; // Or whatever guard you're using
            $permission->save();
        }

        // Create some fake roles and assign permissions to them
        for ($i = 0; $i < 5; $i++) {
            $role = new Role();
            $role->name = $faker->unique()->word . '_role';
            $role->guard_name = 'api'; // Or whatever guard you're using
            $role->save();

            // Attach random permissions to this role
            $permissions = Permission::inRandomOrder()->take(rand(1, 5))->pluck('id');
            $role->permissions()->sync($permissions);
        }
    }
}
