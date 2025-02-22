<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Jose Eduardo',
            'last_name' => 'Zapana Soto',
            'document_type' => 1,
            'document_number' => '12345678',
            'email' => 'jezs715@gmail.com',
            'phone' => '987654321',
            'password' => bcrypt('12345678'),
                    ]);
        
        
        
    }
}

