<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // الأدمن الأول (القديم)
        User::create([
            'name' => 'Alaa',
            'email' => 'alaa@example.com',
            'password' => Hash::make('123456'),
            'is_admin' => 1,
        ]);

        // الأدمن الجديد
        User::create([
            'name' => 'New Admin', 
            'email' => 'newadmin@example.com',
            'password' => Hash::make('password123'),
            'is_admin' => 1,
        ]);
    }
}
