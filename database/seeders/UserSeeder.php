<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::factory(10)->create();

        User::create([
            'name' => 'Super Admin',
            'email' => 'ibnugaming@gmail.com',
            'email_verified_at' => now(),
            'role' => 'admin',
            'password' => Hash::make('password'),
            'api_token' => Str::random(60)

        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'ibnuarifin@gmail.com',
            'email_verified_at' => now(),
            'role' => 'barber',
            'password' => Hash::make('password'),
            'api_token' => Str::random(60)
        ]);
    }
}
