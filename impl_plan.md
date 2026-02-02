# Implementation Plan - Verval Berkas Pegawai

## 1. Project Initialization
- [x] Install Laravel (Latest)
- [ ] Configure Environment (Database: SQLite for ease of run, set up APP_NAME)
- [ ] Install Packages:
    - `spatie/laravel-permission`
    - `maatwebsite/excel`
    - `barryvdh/laravel-dompdf`
    - `laravel/ui` (for Bootstrap scaffolding)

## 2. Database Design & Migrations
- [ ] **Users Table**: Standard + foreign key to OPD (nullable for Super Admin).
- [ ] **OPD Table**: `kode`, `nama`, `alamat`.
- [ ] **Pegawai Table**: `user_id`, `nip`, `nama_lengkap`, `jabatan`, `golongan`, `status_kepegawaian`.
- [ ] **Dokumen Kategori Table**: `nama` (e.g., SK CPNS, Ijazah), `wajib` (boolean).
- [ ] **Dokumen Uploads Table**: `pegawai_id`, `kategori_id`, `file_path`, `tipe_file`, `ukuran`, `status` (draft, pending, valid, invalid), `catatan`, `version`.
- [ ] **Log Aktivitas**: `user_id`, `action`, `description`.

## 3. Authentication & Roles (Spatie)
- [ ] Roles: `Super Admin`, `Admin BKD`, `Admin OPD`, `Pegawai`, `BKN`.
- [ ] Seeder: Create default users for each role for testing.

## 4. Backend Logic (Controllers)
- [ ] **AuthController**: Default Laravel Auth, customized for roles.
- [ ] **DashboardController**: Logic to show different stats per role.
- [ ] **PegawaiController**: Profile management, list for Admins.
- [ ] **DokumenController**:
    - `index()`: List documents.
    - `store()`: Handle upload & versioning.
    - `show()`: Preview.
- [ ] **VerifikasiController**: For Admin OPD (Approve/Reject with notes).
- [ ] **ValidasiController**: For Admin BKD (Finalization).

## 5. Frontend (Blade + Bootstrap 5)
- [ ] **Layout**: Sidebar-based layout, responsive, "Premium" look (custom CSS on top of Bootstrap).
- [ ] **Pages**:
    - Login (Modern card design).
    - Dashboard (Cards with icons, charts if possible).
    - Upload Form (Clean file input with progress).
    - Verification Table (DataTables integration, badges for status).

## 6. Export & Reports
- [ ] Excel export for Pegawai status.
- [ ] PDF export for individual validation receipt.

## 7. Extras
- [ ] Activity Logging implementation.
- [ ] Basic "WhatsApp" notification mock (Service class).
