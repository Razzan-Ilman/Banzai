<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Konsep: Kelompok = Identitas hidup anggota
     * - 4 kelompok total
     * - 3 mewakili divisi (Bahasa, Budaya, Medsos)
     * - 1 mewakili BANZAI keseluruhan
     * - Setiap kelompok punya warna unik, filosofi, dan karakter visual
     */
    public function run(): void
    {
        $groups = [
            // KELOMPOK 1 - MUSASHI (Divisi Bahasa)
            [
                'name' => 'MUSASHI',
                'kanji' => '宮本武蔵',
                'division_id' => null, // Will be linked later
                'color' => '#1E293B', // Deep Indigo (Primer)
                'particle_type' => 'straight_lines', // Simbol pedang & disiplin
                'motion_style' => 'slow_steady', // Tenang, presisi, lambat & mantap
                'description' => 'Miyamoto Musashi - Disiplin, pembelajaran, penguasaan diri. Filosofi: Bahasa adalah pedang pikiran. Karakter: Tenang, presisi, terstruktur.',
            ],
            
            // KELOMPOK 2 - AME-NO-UZUME (Divisi Budaya)
            [
                'name' => 'AME-NO-UZUME',
                'kanji' => '天宇受売命',
                'division_id' => null, // Will be linked later
                'color' => '#6D28D9', // Royal Violet (Primer)
                'particle_type' => 'sakura', // Kelopak sakura
                'motion_style' => 'organic_flow', // Organik, mengalir, lembut & natural
                'description' => 'Ame-no-Uzume - Dewi seni, ekspresi, ritual. Filosofi: Budaya menghidupkan jiwa. Karakter: Organik, mengalir, ekspresif.',
            ],
            
            // KELOMPOK 3 - FUJIN (Divisi Media Sosial)
            [
                'name' => 'FUJIN',
                'kanji' => '風神',
                'division_id' => null, // Will be linked later
                'color' => '#F59E0B', // Burnt Amber (Primer)
                'particle_type' => 'wind_spiral', // Spiral angin
                'motion_style' => 'quick_dynamic', // Dinamis, cepat, gesit & responsif
                'description' => 'Fujin - Dewa angin. Kecepatan, penyebaran, perubahan. Filosofi: Informasi adalah angin. Karakter: Dinamis, cepat, kontras tinggi.',
            ],
            
            // KELOMPOK 4 - YAMATO (Representasi BANZAI Keseluruhan)
            [
                'name' => 'YAMATO',
                'kanji' => '大和',
                'division_id' => null, // BANZAI keseluruhan (tidak terikat divisi)
                'color' => '#0F172A', // Ink Black (Primer)
                'particle_type' => 'sun_rays', // Matahari & pilar
                'motion_style' => 'regal_glow', // Stabil, berwibawa, sangat halus
                'description' => 'Yamato - Persatuan, identitas Jepang. Filosofi: Semua bermuara ke BANZAI. Karakter: Stabil, berwibawa, menyatukan. Simbol kehormatan tertinggi.',
            ],
        ];

        foreach ($groups as $group) {
            Group::create($group);
        }

        $this->command->info('✅ Created 4 Japanese Groups (Kelompok BANZAI):');
        $this->command->info('');
        $this->command->info('🥋 1. MUSASHI (宮本武蔵) - Divisi Bahasa');
        $this->command->info('   Color: Deep Indigo #1E293B');
        $this->command->info('   Karakter: Disiplin, presisi, tenang');
        $this->command->info('   Motion: Slow & Steady');
        $this->command->info('');
        $this->command->info('🌸 2. AME-NO-UZUME (天宇受売命) - Divisi Budaya');
        $this->command->info('   Color: Royal Violet #6D28D9');
        $this->command->info('   Karakter: Ekspresif, organik, mengalir');
        $this->command->info('   Motion: Organic Flow');
        $this->command->info('');
        $this->command->info('🌪️ 3. FUJIN (風神) - Divisi Media Sosial');
        $this->command->info('   Color: Burnt Amber #F59E0B');
        $this->command->info('   Karakter: Dinamis, cepat, adaptif');
        $this->command->info('   Motion: Quick & Dynamic');
        $this->command->info('');
        $this->command->info('🏯 4. YAMATO (大和) - BANZAI Keseluruhan');
        $this->command->info('   Color: Ink Black #0F172A');
        $this->command->info('   Karakter: Berwibawa, persatuan, stabil');
        $this->command->info('   Motion: Regal Glow');
        $this->command->info('');
        $this->command->info('💡 Konsep: Kelompok = Identitas hidup anggota');
        $this->command->info('   Quiz → Kelompok → UI berubah → Level → Medal');
    }
}
