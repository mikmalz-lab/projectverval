# Aplikasi Verifikasi & Validasi (Verval) Berkas Pegawai

Aplikasi ini dibangun menggunakan **Laravel 12** dengan desain premium Bootstrap 5.

## Fitur Utama
- **Role Management**: Super Admin, Admin BKD, Admin OPD, Pegawai.
- **Upload Dokumen**: Pegawai dapat mengupload berkas (PDF/Image) dengan versioning.
- **Verifikasi**: Admin OPD melakukan verifikasi awal.
- **Validasi**: Admin BKD melakukan validasi final.
- **Dashboard**: Statistik realtime sesuai role.

## Cara Instalasi

1. **Setup Environment**
   ```bash
   composer install
   cp .env.example .env
   # Edit .env, set DB_CONNECTION=sqlite dan DB_DATABASE ke full path file database.sqlite Anda
   ```

2. **Setup Database**
   ```bash
   touch database/database.sqlite
   php artisan migrate
   php artisan db:seed
   ```
   *Catatan: Jika seeding gagal, Anda dapat mendaftar akun baru melalui halaman Register.*

3. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   ```
   Akses di `http://localhost:8000`

## Akun Demo (Jika Seeding Berhasil)
- **Super Admin**: `admin@verval.com` / `password`
- **Admin OPD**: `opd@verval.com` / `password`
- **Pegawai**: `budi@verval.com` / `password`

## Dokumen Teknis
Aplikasi menggunakan:
- `spatie/laravel-permission` untuk RBAC.
- `barryvdh/laravel-dompdf` untuk export PDF.
- `maatwebsite/excel` untuk laporan Excel.
- Desain antarmuka responsif dengan Bootstrap 5.
