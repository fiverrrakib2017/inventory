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


        \App\Models\Admin::create([
            'name' => 'SHAMIM',
            'email' => 'shamim8087@gmail.com',
            'username' => 'shamim8087',
            'user_type' => '1',
            'password' => Hash::make('shamim@8087'),
        ]);
        \App\Models\Admin::create([
            'name' => 'SR TECHNOLOGY',
            'email' => 'srtech8087@gmail.com',
            'username' => 'srtech8087',
            'user_type' => '2',
            'password' => Hash::make('srtech@8087'),
        ]);
        \App\Models\Admin::create([
            'name' => 'STAR TECHNOLOGY',
            'email' => 'startech8087@gmail.com',
            'username' => 'startech8087',
            'user_type' => '2',
            'password' => Hash::make('startech@8087'),
        ]);
        $master_ledger_name = ['Income', 'Expense', 'Asset', 'Liabilities'];

        foreach ($master_ledger_name as $name) {
            \App\Models\Master_ledger::create([
                'name' => $name,
                'status' => 1,
            ]);
        }
    }
}
