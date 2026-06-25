<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'name'     => 'Sang Owner',
            'email'    => 'owner@gallerypuan.com', 
            'password' => Hash::make('ownerrahasia123'), // Ingat-ingat password ini!
            'is_owner' => true,
        ]);
    }
}