<?php

/**
 * Quiz System Configuration
 * 
 * File ini berisi semua konfigurasi untuk sistem quiz BANZAI.
 * Ubah nilai di sini untuk menyesuaikan sistem tanpa mengubah code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Quiz Questions Count
    |--------------------------------------------------------------------------
    |
    | Jumlah pertanyaan dalam quiz. Setiap pertanyaan bernilai 1-4 poin.
    | Total skor = questions_count * 1 sampai questions_count * 4
    |
    */
    'questions_count' => 10,

    /*
    |--------------------------------------------------------------------------
    | Score Per Question
    |--------------------------------------------------------------------------
    |
    | Rentang skor untuk setiap jawaban pertanyaan.
    |
    */
    'score_per_question' => [
        'min' => 1,
        'max' => 4,
    ],

    /*
    |--------------------------------------------------------------------------
    | Group Ranges
    |--------------------------------------------------------------------------
    |
    | Range skor untuk setiap kelompok.
    | Format: 'NAMA_KELOMPOK' => ['min' => X, 'max' => Y]
    |
    | Dengan 10 pertanyaan × 4 poin = range 10-40
    |
    */
    'groups' => [
        'MUSASHI' => [
            'min' => 10,
            'max' => 17,
            'color' => '#6366F1',
            'description' => 'Analitis, terstruktur, perfeksionis',
        ],
        'AME-NO-UZUME' => [
            'min' => 18,
            'max' => 25,
            'color' => '#EC4899',
            'description' => 'Kreatif, ekspresif, artistik',
        ],
        'FUJIN' => [
            'min' => 26,
            'max' => 33,
            'color' => '#10B981',
            'description' => 'Dinamis, adaptif, cepat',
        ],
        'YAMATO' => [
            'min' => 34,
            'max' => 40,
            'color' => '#F59E0B',
            'description' => 'Harmonis, kolaboratif, pemimpin',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Borderline Scores
    |--------------------------------------------------------------------------
    |
    | Skor yang dianggap "borderline" (di perbatasan antar kelompok).
    | User dengan skor ini akan mendapat flag khusus.
    |
    */
    'borderline_scores' => [17, 18, 25, 26, 33, 34],

    /*
    |--------------------------------------------------------------------------
    | Title Consistency Settings
    |--------------------------------------------------------------------------
    |
    | Pengaturan untuk sistem title berdasarkan konsistensi.
    |
    */
    'title' => [
        // Berapa bulan terakhir yang dihitung untuk rolling consistency
        'rolling_months' => 4,
        
        // Minimal berapa kali kelompok sama untuk dapat title
        'min_same_count' => 3,
    ],

    /*
    |--------------------------------------------------------------------------
    | Quiz Limits
    |--------------------------------------------------------------------------
    |
    | Batasan untuk quiz.
    |
    */
    'limits' => [
        // Maksimal quiz per bulan per user (jika > 1, akan replace yang lama)
        'per_month' => 1,
    ],

];
