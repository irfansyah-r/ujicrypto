<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Membership;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Membership::create([
            'level'  => strtoupper('bronze'),
            'max_assets' => 0,
        ]);
        Membership::create([
            'level'  => strtoupper('silver'),
            'max_assets' => 1,
        ]);
        Membership::create([
            'level'  => strtoupper('gold'),
            'max_assets' => 2,
        ]);

        User::create([
            'membership_id' => NULL,
            'name'  => 'Admin',
            'email' => 'admin@gmail.com',
            'role'  => 'Admin',
            'password' => Hash::make('admin123'),
        ]);
    }
}
