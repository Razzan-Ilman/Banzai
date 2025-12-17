<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisions = [
            [
                'name' => 'Divisi Bahasa',
                'slug' => 'bahasa',
                'description' => 'Divisi yang fokus pada pembelajaran dan pengembangan kemampuan bahasa Jepang, mulai dari hiragana, katakana, kanji, hingga percakapan sehari-hari.',
                'tagline' => 'Bahasa adalah jendela berpikir',
                'icon' => '📖',
                'color' => '#0891B2', // Cyan
                'character' => 'The Scholar',
                'motion_type' => 'slide-left',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Divisi Budaya',
                'slug' => 'budaya',
                'description' => 'Divisi yang mempelajari dan melestarikan budaya Jepang, termasuk upacara minum teh, origami, kaligrafi, festival, dan tradisi lainnya.',
                'tagline' => 'Budaya adalah jiwa yang dilestarikan',
                'icon' => '🎎',
                'color' => '#7C3AED', // Violet
                'character' => 'The Artist',
                'motion_type' => 'fade-scale',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Divisi Media Sosial',
                'slug' => 'medsos',
                'description' => 'Divisi yang mengelola komunikasi digital dan publikasi kegiatan BANZAI ke berbagai platform media sosial.',
                'tagline' => 'Menghubungkan BANZAI ke dunia',
                'icon' => '📱',
                'color' => '#F59E0B', // Amber
                'character' => 'The Connector',
                'motion_type' => 'snap-right',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($divisions as $division) {
            Division::create($division);
        }
    }
}
