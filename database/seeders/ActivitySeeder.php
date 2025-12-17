<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = [
            [
                'title' => 'Pelatihan Hiragana & Katakana Dasar',
                'slug' => 'pelatihan-hiragana-katakana-dasar',
                'description' => 'Workshop intensif untuk mempelajari huruf dasar Jepang, Hiragana dan Katakana, bagi anggota baru.',
                'content' => 'Kegiatan pelatihan yang diadakan setiap awal tahun ajaran untuk memperkenalkan sistem penulisan Jepang kepada anggota baru BANZAI.',
                'date' => now()->subMonths(2),
                'location' => 'Ruang Lab Bahasa SMKN 13 Bandung',
                'is_published' => true,
                'is_featured' => true,
            ],
            [
                'title' => 'Festival Budaya Jepang 2024',
                'slug' => 'festival-budaya-jepang-2024',
                'description' => 'Perayaan tahunan memperkenalkan budaya Jepang kepada seluruh warga sekolah.',
                'content' => 'Festival tahunan yang menampilkan berbagai aspek budaya Jepang termasuk upacara minum teh, origami, cosplay, dan pertunjukan tari tradisional.',
                'date' => now()->subMonth(),
                'location' => 'Aula SMKN 13 Bandung',
                'is_published' => true,
                'is_featured' => true,
            ],
            [
                'title' => 'Pengenalan Kanji Level N5',
                'slug' => 'pengenalan-kanji-level-n5',
                'description' => 'Sesi belajar kanji dasar sesuai standar JLPT N5.',
                'content' => 'Pembelajaran 100 kanji dasar yang sering digunakan dalam percakapan sehari-hari dan ujian JLPT N5.',
                'date' => now()->subWeeks(2),
                'location' => 'Ruang Kelas XI KA 1',
                'is_published' => true,
                'is_featured' => false,
            ],
        ];

        foreach ($activities as $activity) {
            Activity::create($activity);
        }
    }
}
