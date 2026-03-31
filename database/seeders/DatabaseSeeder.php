<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Alaa',
            'email' => 'alaa@example.com',
            'password' => Hash::make('123456'),
            'is_admin' => 1,
        ]);
    }
}