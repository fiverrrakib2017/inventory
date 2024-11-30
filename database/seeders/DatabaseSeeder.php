<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        \App\Models\Admin::create([
            'name' => 'Rakib Mahmud',
            'email' => 'rakibas375@gmail.com',
            'username' => 'rakibas375',
            'user_type' => '1',
            'password' => Hash::make('12345678'),
        ]);
        \App\Models\Admin::create([
            'name' => 'Shamim Khan',
            'email' => 'shamim@gmail.com',
            'username' => 'shamim',
            'user_type' => '2',
            'password' => Hash::make('12345678'),
        ]);
        \App\Models\Admin::create([
            'name' => 'Ismail Hossain',
            'email' => 'ismail@gmail.com',
            'username' => 'ismail',
            'user_type' => '2',
            'password' => Hash::make('12345678'),
        ]);
    }
}
