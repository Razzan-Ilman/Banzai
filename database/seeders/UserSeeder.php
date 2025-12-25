<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * UserSeeder
 * 
 * Seeder untuk membuat akun default.
 * Password sudah di-hash menggunakan bcrypt.
 * 
 * Jalankan: php artisan db:seed --class=UserSeeder
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            // =====================================================
            // ADMIN ACCOUNTS
            // =====================================================
            [
                'name' => 'Admin BANZAI',
                'email' => 'admin@banzai.com',
                'password' => 'admin123',  // Ganti di production!
                'role' => 'admin',
            ],
            
            // =====================================================
            // CORE ACCOUNTS (Anggota Inti)
            // =====================================================
            [
                'name' => 'Core User',
                'email' => 'core@banzai.com',
                'password' => 'core123',
                'role' => 'core',
            ],
            
            // =====================================================
            // MEMBER ACCOUNTS (Anggota Biasa)
            // =====================================================
            [
                'name' => 'Member User',
                'email' => 'member@banzai.com',
                'password' => 'member123',
                'role' => 'member',
            ],
            
            // =====================================================
            // PUBLIC ACCOUNTS (Pengunjung)
            // =====================================================
            [
                'name' => 'Public User',
                'email' => 'public@banzai.com',
                'password' => 'public123',
                'role' => 'public',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make($userData['password']),
                    'role' => $userData['role'],
                    'email_verified_at' => now(),
                ]
            );
        }

        $this->command->info('✅ Default users created/updated!');
        $this->command->table(
            ['Name', 'Email', 'Role', 'Password'],
            collect($users)->map(fn($u) => [
                $u['name'],
                $u['email'],
                $u['role'],
                $u['password'],
            ])->toArray()
        );
    }
}
