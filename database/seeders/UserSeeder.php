<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user = \App\Models\User::factory()->create([
            'name' => 'Developer',
            'email' => 'developer@example.com',
            'password' => Hash::make('123456789'),
        ]);
        $user->syncRoles('developer');


        $user = \App\Models\User::factory()->create([
            'name' => 'Admin App',
            'email' => 'admin@example.com',
            'password' => Hash::make('123456789'),
        ]);
        $user->syncRoles('admin');

        $user = \App\Models\User::factory()->create([
            'name' => 'Guest',
            'email' => 'user@example.com',
            'password' => Hash::make('123456789'),
        ]);
        $user->syncRoles('guest');

    }
}
