<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Contoh data admin dengan role
         Admin::create([
            'name' => 'admin',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status_login' => 'offline',
        ]);
    }
}
