<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Blogcategory;
use App\Models\Tag;
//Config Ecommerce
use app\Models\Family;
use App\Models\Option;
use app\Models\Product;

use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Storage::deleteDirectory('public/posts');
        Storage::makeDirectory('public/posts');

        Storage::deleteDirectory('public/products');
        Storage::makeDirectory('public/products');

        $this->call([UserSeeder::class]);
        Blogcategory::factory(5)->create();
        Tag::factory(10)->create();
        $this->call([PostSeeder::class]);

        $this->call([
            FamilySeeder::class,
            OptionSeeder::class,
        ]);
        //Product::factory(50)->create();



    }
}



