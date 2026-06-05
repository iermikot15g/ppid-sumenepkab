# PPID Kabupaten Sumenep

Sistem Informasi Pejabat Pengelola Informasi dan Dokumentasi (PPID) Kabupaten Sumenep.

## 🚀 Fitur Utama

### 1. Manajemen Role (RBAC)
- **Super Admin**: Manajemen penuh sistem (OPD, Desa, Kategori, User, Audit Log)
- **PPID Utama**: Monitoring semua OPD, kelola konten global
- **PPID Pembantu**: Kelola dokumen dan CMS OPD sendiri
- **Pimpinan OPD**: Dashboard read-only untuk OPD yang dipimpin
- **Masyarakat**: Unduh dan preview dokumen publik

### 2. CMS (Content Management System)
- **Dokumen DIP**: Upload/unduh dokumen informasi publik (PDF, gambar)
- **Profil OPD**: Tentang OPD, Tugas Fungsi, Struktur, Dasar Hukum (teks + PDF)
- **Agenda Kegiatan**: CRUD agenda dengan status publish/unpublish
- **Galeri Foto**: Upload dan kelola galeri foto
- **Infografis**: Upload dan kelola infografis
- **Layanan Publik**: Kelola link layanan publik per OPD
- **Hero Slider**: Kelola slider di halaman beranda
- **Profil PPID**: Kelola halaman profil PPID Kabupaten
- **Standar Layanan**: Kelola halaman standar layanan

### 3. Halaman Publik
- Daftar Informasi Publik (DIP) dengan filter kategori, preview, dan unduh
- Direktori OPD (daftar OPD dan detail profil)
- Galeri Foto publik
- Infografis publik
- Agenda publik
- Profil PPID
- Standar Layanan

### 4. Dashboard
- Dashboard terpisah untuk setiap role
- Statistik dokumen (total, terpublikasi, dikecualikan, total unduhan)
- Indikator keaktifan OPD
- Tren publikasi 6 bulan terakhir (grafik)
- Dokumen terbaru

### 5. Manajemen Wilayah
- Data provinsi, kabupaten/kota, kecamatan (seeder)
- Pilihan wilayah dinamis pada form registrasi

### 6. Registrasi Masyarakat
- Data lengkap (NIK, alamat, pendidikan, pekerjaan, dll)
- Validasi NIK (16 digit, unik)
- Validasi email dan nomor kontak unik

## 🛠️ Tech Stack

| Komponen | Teknologi |
|----------|-----------|
| Framework | Laravel 12 |
| Database | MySQL |
| Frontend | Blade + Tailwind CSS |
| Auth | Laravel Breeze (custom) |
| Role & Permission | Spatie Laravel Permission |
| Charts | Chart.js |
| File Storage | Laravel Storage (public) |

## 📋 Persyaratan Sistem

- PHP >= 8.2
- Composer
- MySQL >= 5.7
- Node.js & NPM (untuk development)

## 🔧 Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/username/ppid-sumenepkab.git
cd ppid-sumenepkab