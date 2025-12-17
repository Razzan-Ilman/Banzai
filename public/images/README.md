# BANZAI Image Assets

Folder ini berisi aset gambar statis untuk website BANZAI.

## Struktur Folder

```
images/
├── hero/        → Background untuk hero section
├── logo/        → Logo BANZAI (PNG/SVG)
├── patterns/    → Pattern Jepang (sakura, seigaiha, dll)
├── placeholder/ → Placeholder untuk preview
├── divisions/   → Gambar per divisi
├── members/     → Foto anggota (opsional)
└── activities/  → Foto kegiatan statis
```

## Cara Penggunaan

Di file Blade:
```html
<img src="{{ asset('images/hero/background.jpg') }}" alt="...">
```

## Format yang Disarankan

- **Hero**: JPG/WebP, 1920x1080 atau lebih
- **Logo**: PNG (transparan) atau SVG
- **Pattern**: SVG (scalable)
- **Foto**: JPG/WebP, compressed

## Tips

1. Kompres gambar sebelum upload (gunakan TinyPNG atau Squoosh)
2. Gunakan WebP untuk performance lebih baik
3. Sediakan versi mobile (lebih kecil) jika perlu
