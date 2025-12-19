# Konfigurasi MySQL untuk BANZAI

## File `.env` - Copy Paste Konfigurasi Ini

Buka file `.env` di root project dan ganti bagian database dengan:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=banzai_db
DB_USERNAME=root
DB_PASSWORD=
```

## Setelah Update `.env`

Jalankan command berikut:

```bash
# 1. Clear cache Laravel
php artisan config:clear

# 2. Migrate database
php artisan migrate:fresh --seed
```

## Jika Ada Error

### Error: "Access denied for user"
- Periksa `DB_USERNAME` dan `DB_PASSWORD`
- Pastikan MySQL service running

### Error: "Unknown database 'banzai_db'"
Buat database dulu:
```sql
CREATE DATABASE banzai_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Error: "SQLSTATE[HY000] [2002]"
- Pastikan MySQL service sudah running
- Cek port (default: 3306)
