# SIM HMSE — Sistem Informasi Manajemen Himpunan Mahasiswa

> Proyek Tingkat III — Tugas Besar

Aplikasi web untuk mengelola kegiatan organisasi Himpunan Mahasiswa Software Engineering (HMSE), mencakup manajemen program kerja, pengelolaan proposal kegiatan, keuangan, struktur organisasi, dan dokumentasi.

---

## 📌 Tentang Proyek

SIM HMSE adalah sistem informasi internal yang dibangun untuk membantu pengurus himpunan dalam mengelola operasional organisasi secara digital. Sistem ini terdiri dari dua bagian utama:

### 🌐 Halaman Publik (Landing Page)
- **Home** — Halaman utama dengan informasi umum himpunan
- **About** — Profil dan visi-misi himpunan
- **News** — Berita dan artikel kegiatan himpunan

### 🖥️ Dashboard Manajemen Internal
- **Dashboard Overview** — Ringkasan statistik dan aktivitas organisasi
- **Program Kerja (Proker)** — Pengelolaan program kerja per divisi (CRUD)
- **Proposal Kegiatan** — Pembuatan proposal, preview dokumen A4, dan alur approval bertahap (Ketua Panitia → Sekretaris → Ketua Hima → Pembina → Kaprodi) dengan tanda tangan digital
- **Keuangan** — Pengelolaan keuangan internal dan per-proker
- **SOTK** — Struktur Organisasi dan Tata Kerja / keanggotaan
- **Events** — Manajemen acara dan kegiatan
- **Dokumentasi** — Pengelolaan dokumen organisasi
- **Kalender** — Kalender kegiatan himpunan
- **Pengaturan** — Konfigurasi akun dan sistem

---

## 🛠️ Tech Stack

| Layer       | Teknologi                          |
| ----------- | ---------------------------------- |
| Backend     | PHP 8.2+, Laravel 12               |
| Frontend    | Blade, Tailwind CSS 4, Alpine.js   |
| Admin Panel | Filament 5                         |
| Build Tool  | Vite 7                             |
| PDF Export  | Laravel DomPDF                     |
| Excel       | Maatwebsite Excel                  |
| Realtime    | Livewire 4                         |

---

## 🚀 Instalasi & Menjalankan

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js & npm
- Database (MySQL / SQLite)

### Langkah Instalasi

```bash
# 1. Clone repository
git clone https://github.com/<username>/PT3-HMSE-TUP.git
cd PT3-HMSE-TUP/SIM\ HMSE

# 2. Jalankan setup otomatis (install dependencies, generate key, migrate, build assets)
composer setup

# 3. Jalankan development server
composer dev
```

Perintah `composer dev` akan menjalankan secara bersamaan:
- Laravel dev server (`php artisan serve`)
- Queue listener
- Log viewer (Pail)
- Vite dev server

Akses aplikasi di: **http://localhost:8000**

---

## 📁 Struktur Folder Utama

```
SIM HMSE/
├── app/Http/Controllers/     # Controller (PageController, DashboardController)
├── resources/views/
│   ├── components/           # Komponen Blade reusable
│   │   ├── dashboard/        # Sidebar, topbar, stepper, signature pad, dll.
│   │   ├── layouts/          # Layout dashboard & public
│   │   └── public/           # Navbar & footer publik
│   └── pages/
│       ├── auth/             # Halaman login
│       ├── dashboard/        # Halaman-halaman dashboard
│       │   ├── proker/       # Index, create, show
│       │   ├── proposal/     # Index, create, preview, show
│       │   ├── sotk/         # Index, create
│       │   ├── finance/      # Index
│       │   ├── events/       # Index
│       │   └── documents/    # Index
│       ├── home.blade.php    # Halaman utama publik
│       └── about.blade.php   # Halaman tentang
├── routes/web.php            # Definisi routing
└── public/                   # Asset publik
```

---

## 👥 Tim Pengembang

Proyek Tingkat III — Himpunan Mahasiswa Software Engineering (HMSE), Telkom University Purwokerto.
