<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\MemberProfile;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 3 test users with different levels
        
        // Level 1 - Initiate (Beginner)
        $user1 = User::create([
            'name' => 'Member Level 1',
            'email' => 'level1@banzai.test',
            'password' => bcrypt('password'),
            'role' => 'member',
        ]);
        
        MemberProfile::create([
            'user_id' => $user1->id,
            'member_number' => 'BNZ-2025-001',
            'level' => 1,
            'points' => 50,
            'xp' => 50,
            'is_active' => true,
        ]);

        // Level 2 - Adept (Intermediate)
        $user2 = User::create([
            'name' => 'Member Level 2',
            'email' => 'level2@banzai.test',
            'password' => bcrypt('password'),
            'role' => 'member',
        ]);
        
        MemberProfile::create([
            'user_id' => $user2->id,
            'member_number' => 'BNZ-2025-002',
            'level' => 2,
            'points' => 250,
            'xp' => 150,
            'is_active' => true,
        ]);

        // Level 3 - Master (Advanced)
        $user3 = User::create([
            'name' => 'Member Level 3',
            'email' => 'level3@banzai.test',
            'password' => bcrypt('password'),
            'role' => 'member',
        ]);
        
        MemberProfile::create([
            'user_id' => $user3->id,
            'member_number' => 'BNZ-2025-003',
            'level' => 3,
            'points' => 600,
            'xp' => 300,
            'is_active' => true,
        ]);

        $this->command->info('✅ Created 3 members with levels 1-3');
        $this->command->info('📧 Emails: level1@banzai.test, level2@banzai.test, level3@banzai.test');
        $this->command->info('🔑 Password: password');
    }
}
