<?php

namespace Database\Seeders;

use App\Models\Title;
use Illuminate\Database\Seeder;

class TitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $titles = [
            [
                'name' => 'Kensei',
                'name_kanji' => '剣聖',
                'group' => 'MUSASHI',
                'description' => 'Master of the Sword - Untuk anggota dengan karakter analitis, terstruktur, dan perfeksionis yang telah menunjukkan konsistensi.',
            ],
            [
                'name' => 'Maihime',
                'name_kanji' => '舞姫',
                'group' => 'AME-NO-UZUME',
                'description' => 'Dancing Princess - Untuk anggota dengan karakter kreatif, ekspresif, dan artistik yang telah menunjukkan konsistensi.',
            ],
            [
                'name' => 'Shippuu',
                'name_kanji' => '疾風',
                'group' => 'FUJIN',
                'description' => 'Swift Wind - Untuk anggota dengan karakter dinamis, adaptif, dan cepat yang telah menunjukkan konsistensi.',
            ],
            [
                'name' => 'Wakon',
                'name_kanji' => '和魂',
                'group' => 'YAMATO',
                'description' => 'Japanese Spirit - Untuk anggota dengan karakter harmonis, kolaboratif, dan menjadi pemersatu yang telah menunjukkan konsistensi.',
            ],
        ];

        foreach ($titles as $title) {
            Title::updateOrCreate(
                ['group' => $title['group']],
                $title
            );
        }
    }
}
