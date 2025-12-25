# Quiz System - Developer Documentation

## 📖 Overview

Sistem quiz kepribadian BANZAI untuk menentukan kelompok Jepang anggota berdasarkan jawaban quiz.

## 🏗 Arsitektur

```
┌─────────────────────────────────────────────────────────────┐
│                     QUIZ SYSTEM                              │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  ┌──────────────┐    ┌──────────────┐    ┌──────────────┐  │
│  │   Member     │───▶│   Quiz       │───▶│   Result     │  │
│  │   Dashboard  │    │   Controller │    │   Page       │  │
│  └──────────────┘    └──────┬───────┘    └──────────────┘  │
│                             │                               │
│         ┌───────────────────┼───────────────────┐          │
│         ▼                   ▼                   ▼          │
│  ┌─────────────┐    ┌─────────────┐    ┌─────────────┐    │
│  │   Scoring   │    │   Group     │    │   Title     │    │
│  │   Service   │    │   Resolver  │    │   Service   │    │
│  └─────────────┘    └─────────────┘    └──────┬──────┘    │
│         │                   │                  │           │
│         └───────────────────┼──────────────────┘           │
│                             ▼                               │
│                    ┌─────────────┐                         │
│                    │ Consistency │                         │
│                    │   Service   │                         │
│                    └─────────────┘                         │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

## 📁 Struktur File

```
app/
├── Http/Controllers/
│   ├── Member/
│   │   └── QuizController.php      # Controller utama quiz member
│   └── Admin/
│       └── QuizHistoryController.php # Controller admin history
│
├── Models/
│   ├── QuizResult.php              # Hasil quiz per bulan
│   ├── Title.php                   # Title yang bisa didapat
│   ├── UserTitleHistory.php        # Riwayat pemberian title
│   └── User.php                    # User dengan relasi title
│
├── Services/Quiz/                  # SERVICE LAYER
│   ├── QuizScoringService.php      # Hitung skor (10-40)
│   ├── QuizGroupResolver.php       # Tentukan kelompok dari skor
│   ├── QuizConsistencyService.php  # Check rolling consistency
│   └── TitleService.php            # Award/revoke title
│
└── config/
    └── quiz.php                    # Konfigurasi quiz (buat file ini)

database/
├── migrations/
│   ├── *_add_borderline_to_quiz_results.php
│   ├── *_create_titles_table.php
│   ├── *_create_user_title_histories_table.php
│   └── *_add_title_to_users.php
└── seeders/
    └── TitleSeeder.php             # Seed 4 title

resources/views/
├── member/quiz/
│   ├── index.blade.php             # Form quiz
│   └── result.blade.php            # Hasil quiz
└── admin/quiz-history/
    └── index.blade.php             # Admin view
```

## ⚙️ Konfigurasi

### Range Skor (di `QuizGroupResolver.php`)
```php
RANGES = [
    'MUSASHI'       => ['min' => 10, 'max' => 17],  // Analitis
    'AME-NO-UZUME'  => ['min' => 18, 'max' => 25],  // Kreatif
    'FUJIN'         => ['min' => 26, 'max' => 33],  // Dinamis
    'YAMATO'        => ['min' => 34, 'max' => 40],  // Harmonis
];

BORDERLINE_SCORES = [17, 18, 25, 26, 33, 34];  // Edge cases
```

### Konsistensi (di `QuizConsistencyService.php`)
```php
ROLLING_MONTHS = 4;   // Check 4 bulan terakhir
MIN_SAME_COUNT = 3;   // Minimal 3 sama untuk title
```

## 🔄 Alur Quiz

```
1. Member buka /member/quiz
2. Jawab 10 pertanyaan (skor 1-4 per jawaban)
3. QuizScoringService.calculate() → total skor
4. QuizGroupResolver.fromScore() → kelompok + borderline flag
5. Simpan ke quiz_results
6. TitleService.evaluate() → check title eligibility
7. Redirect ke result page
```

## 🏆 Alur Title

```
1. Setiap quiz submit → TitleService.evaluate()
2. Check 4 bulan terakhir (QuizConsistencyService)
3. Jika 3+ bulan sama kelompok → eligible
4. Award title + create history record
5. Jika ganti kelompok → title bisa dicabut
```

## 📊 Database Schema

### quiz_results
| Column | Type | Deskripsi |
|--------|------|-----------|
| user_id | FK | User yang quiz |
| group_id | FK | Kelompok hasil |
| month, year | int | Periode quiz |
| answers | json | Jawaban [1-4, ...] |
| total_score | int | Total skor |
| is_borderline | bool | Flag edge case |

### titles
| Column | Type | Deskripsi |
|--------|------|-----------|
| name | string | Nama (Kensei) |
| name_kanji | string | Kanji (剣聖) |
| group | string | Kelompok (MUSASHI) |

## 🧪 Testing

```bash
# Run migrations
php artisan migrate

# Seed titles
php artisan db:seed --class=TitleSeeder

# Test quiz (login sebagai member)
# Akses /member/quiz
```

## ✏️ Mengedit Pertanyaan

Pertanyaan ada di `QuizController.php` method `getQuizQuestions()`.

```php
[
    'question' => 'Text pertanyaan...',
    'options' => [
        ['text' => 'Opsi 1', 'score' => 1],  // Skor terendah
        ['text' => 'Opsi 2', 'score' => 2],
        ['text' => 'Opsi 3', 'score' => 3],
        ['text' => 'Opsi 4', 'score' => 4],  // Skor tertinggi
    ],
],
```

## 🔧 Menambah Kelompok Baru

1. Update `RANGES` di `QuizGroupResolver.php`
2. Tambah group di tabel `groups`
3. Tambah title di `TitleSeeder.php`
4. Run seeder: `php artisan db:seed --class=TitleSeeder`

## 📝 Catatan Penting

- Quiz hanya bisa 1x per bulan per user
- Jika submit ulang di bulan sama → replace hasil lama
- Title dihitung dari 4 bulan terakhir (rolling)
- Borderline flag hanya untuk info, tidak mengubah logika
