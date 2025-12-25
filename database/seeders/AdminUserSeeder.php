<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update Admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@banzai.com'],
            [
                'name' => 'Admin BANZAI',
                'password' => Hash::make('admin123'),
                'role' => 'admin',  // CRITICAL: Set admin role
                'email_verified_at' => now(),
            ]
        );
        
        $this->command->info('✅ Admin user ready!');
        $this->command->info('📧 Email: admin@banzai.com');
        $this->command->info('🔑 Password: admin123');
        $this->command->info('👤 Role: admin');
        
        // Create test users for each role
        $testUsers = [
            [
                'email' => 'member@banzai.sch.id',
                'name' => 'Test Member',
                'role' => 'member',
                'password' => 'member123',
            ],
            [
                'email' => 'core@banzai.sch.id',
                'name' => 'Test Core',
                'role' => 'core',
                'password' => 'core123',
            ],
        ];
        
        foreach ($testUsers as $userData) {
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make($userData['password']),
                    'role' => $userData['role'],  // CRITICAL: Set role
                    'email_verified_at' => now(),
                ]
            );
            
            $this->command->info("✅ {$userData['role']} user: {$userData['email']} / {$userData['password']}");
        }
    }
}
