<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Division;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get division IDs
        $bahasaId = Division::where('slug', 'bahasa')->first()?->id;
        $budayaId = Division::where('slug', 'budaya')->first()?->id;
        $medsosId = Division::where('slug', 'medsos')->first()?->id;

        $members = [
            // Pengurus Inti
            [
                'name' => 'Akira',
                'class' => 'XI',
                'major' => 'Kimia Analisis',
                'position' => 'Ketua',
                'division_id' => null,
                'initial_color' => '#064E3B',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Hana',
                'class' => 'XI',
                'major' => 'Kimia Analisis',
                'position' => 'Wakil Ketua',
                'division_id' => null,
                'initial_color' => '#DB2777',
                'order' => 2,
                'is_active' => true,
            ],

            // Divisi Bahasa
            [
                'name' => 'Kenji',
                'class' => 'X',
                'major' => 'Kimia Analisis',
                'position' => 'Koordinator',
                'division_id' => $bahasaId,
                'initial_color' => '#0891B2',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Sora',
                'class' => 'XI',
                'major' => 'Kimia Industri',
                'position' => 'Anggota',
                'division_id' => $bahasaId,
                'initial_color' => '#0891B2',
                'order' => 4,
                'is_active' => true,
            ],

            // Divisi Budaya
            [
                'name' => 'Yuki',
                'class' => 'XI',
                'major' => 'Kimia Analisis',
                'position' => 'Koordinator',
                'division_id' => $budayaId,
                'initial_color' => '#7C3AED',
                'order' => 5,
                'is_active' => true,
            ],

            // Divisi Media Sosial
            [
                'name' => 'Riku',
                'class' => 'X',
                'major' => 'Kimia Analisis',
                'position' => 'Koordinator',
                'division_id' => $medsosId,
                'initial_color' => '#F59E0B',
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($members as $member) {
            Member::create($member);
        }
    }
}
