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
        // Check if admin already exists
        $adminExists = User::where('email', 'admin@banzai.com')->exists();
        
        if (!$adminExists) {
            User::create([
                'name' => 'Admin BANZAI',
                'email' => 'admin@banzai.com',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]);
            
            $this->command->info('✅ Admin user created successfully!');
            $this->command->info('📧 Email: admin@banzai.com');
            $this->command->info('🔑 Password: admin123');
        } else {
            $this->command->warn('⚠️  Admin user already exists.');
        }
    }
}
