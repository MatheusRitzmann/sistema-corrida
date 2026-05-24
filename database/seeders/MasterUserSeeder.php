<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MasterUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Master',
            'email'    => 'master@corrida.com',
            'password' => Hash::make('master123'),
            'role'     => 'master',
        ]);
    }
}