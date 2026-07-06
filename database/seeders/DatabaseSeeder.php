<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
  public function run(): void
{
    // الأدمن الأول (حسابك)
    \App\Models\User::create([
        'name' => 'Alaa',
        'email' => 'alaa@example.com',
        'password' => \Illuminate\Support\Facades\Hash::make('123456'),
        'is_admin' => 1,
    ]);

    // الأدمن الجديد 
    \App\Models\User::create([
        'name' => 'New Admin', 
        'email' => 'newadmin@example.com',
        'password' => \Illuminate\Support\Facades\Hash::make('password123'),
        'is_admin' => 1,
    ]);
}
