<?php

namespace Database\Seeders;

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
        $role1 = Role::create(['name' => 'Admin']);

        $role2 = Role::create(['name' => 'Blogger']);

        $role3 = Role::create(['name' => 'User']);

        Permission::create(['name' => 'admin.home']);

        Permission::create(['name' => 'admin.blogs.index']);
        Permission::create(['name' => 'admin.blogs.create']);
        Permission::create(['name' => 'admin.blogs.edit']);
        Permission::create(['name' => 'admin.blogs.destroy']);

        Permission::create(['name' => 'admin.post.categories.index']);
        Permission::create(['name' => 'admin.post.categories.create']);
        Permission::create(['name' => 'admin.post.categories.edit']);
        Permission::create(['name' => 'admin.post.categories.destroy']);

    }
}
