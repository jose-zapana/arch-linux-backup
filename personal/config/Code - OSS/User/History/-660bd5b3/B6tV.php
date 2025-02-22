<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogCategory; 
use App\Models\Tag;
//Config Ecommerce
use App\Models\Family;
use App\Models\Option;
use App\Models\Product;

use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Contracts\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Storage::deleteDirectory('posts');
        Storage::makeDirectory('posts');

        Storage::deleteDirectory('products');
        Storage::makeDirectory('products');

        $this->call([UserSeeder::class]);
        Blogcategory::factory(10)->create();
        Tag::factory(10)->create();
        $this->call([PostSeeder::class]);

        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            FamilySeeder::class,
            OptionSeeder::class,
            ProductSeeder::class,
        ]);

        $user = User::find(1);
        $user->assignRole('admin');
      
        
    }
}



