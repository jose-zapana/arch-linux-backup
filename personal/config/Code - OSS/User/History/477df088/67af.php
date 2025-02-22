<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'Admin']);

        $admin->syncPermissions([
            'access dashboard',
            'manage options',
            'manage families',
            'manage categories',
            'manage subcategories',
            'manage products',
            'manage covers',
            'manage drivers',
            'manage orders',
            'manage shipments',
            'manage quotes',
            'manage users',
            'manage roles',
            'manage tags',
            'manage blogcategories',
            'manage posts',
        ]);

        $user = User::find(1);
        $user->assignRole('admin');

        $driver = Role::create(['name' => 'Driver']);
        $driver->syncPermissions([
            'access dashboard',
            'manage shipments',
            'manage orders',
                                   
        ]);
    }
}
