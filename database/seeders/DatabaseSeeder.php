<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user (without factory)
        User::create([
            'name' => 'Admin BANZAI',
            'email' => 'admin@banzai.sch.id',
            'password' => Hash::make('banzai2024'),
        ]);

        // Seed divisions first (members depend on them)
        $this->call([
            DivisionSeeder::class,
            MemberSeeder::class,
            ActivitySeeder::class,
        ]);
    }
}
