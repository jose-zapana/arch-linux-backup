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

        Permission::create(['name' => 'admin.home'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'admin.users.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.users.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.users.edit'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.post.categories.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.post.categories.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.post.categories.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.post.categories.destroy'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.tags.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.tags.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.tags.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.tags.destroy'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.blogs.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.blogs.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.blogs.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.blogs.destroy'])->syncRoles([$role1, $role2]);
    }
}
