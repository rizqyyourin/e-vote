# E-Voting Platform

Sebuah aplikasi voting online yang modern dan responsif dibangun dengan **Laravel 12**, **Livewire 3**, **Alpine.js**, dan **Tailwind CSS v4**.

---

## 📋 Daftar Isi

- [Fitur Utama](#fitur-utama)
- [Stack Teknologi](#stack-teknologi)
- [Prasyarat](#prasyarat)
- [Instalasi Lokal](#instalasi-lokal)
- [Konfigurasi](#konfigurasi)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)
- [Struktur Database](#struktur-database)
- [Panduan Penggunaan](#panduan-penggunaan)
- [Akun Test](#akun-test)

---

## 🎯 Fitur Utama

### Untuk Pembuat Voting (Admin)
- ✅ Membuat voting dengan menambahkan calon
- ✅ Menjadwalkan waktu mulai dan selesai voting
- ✅ Memulai dan menyelesaikan voting
- ✅ Melihat hasil voting real-time
- ✅ Mengunduh hasil dalam format PDF
- ✅ Menghapus voting

### Untuk Pemilih (Voter)
- ✅ Melihat daftar voting yang tersedia
- ✅ Mengikuti voting dengan memilih calon
- ✅ Melihat riwayat voting
- ✅ Melihat hasil voting yang sudah selesai
- ✅ Mengunduh hasil voting dalam PDF
- ✅ Mengatur akun dan zona waktu

### Fitur Umum
- ✅ Autentikasi (Login/Register)
- ✅ Manajemen profil pengguna
- ✅ Sistem notifikasi toast
- ✅ Desain responsif untuk mobile/tablet/desktop
- ✅ Paginasi dan filter voting
- ✅ Pencarian voting real-time
- ✅ Export hasil voting ke PDF

---

## 🛠️ Stack Teknologi

| Layer | Teknologi | Versi |
|-------|-----------|-------|
| **Backend** | Laravel | 12.0 |
| **Database** | SQLite | Latest |
| **Real-time** | Livewire | 3.4+ |
| **CSS Framework** | Tailwind CSS | 4.0 |
| **JavaScript** | Alpine.js | 3.x |
| **Template Engine** | Blade | Built-in |
| **Build Tool** | Vite | Latest |
| **PHP Version** | PHP | 8.3+ |

---

## 📦 Prasyarat

Sebelum memulai, pastikan Anda telah menginstal:

1. **PHP 8.3+** - [Download](https://www.php.net/downloads)
2. **Composer** - [Download](https://getcomposer.org/download/)
3. **Node.js & NPM** - [Download](https://nodejs.org/)
4. **Git** - [Download](https://git-scm.com/)

### Verifikasi Instalasi:
```bash
php --version
composer --version
node --version
npm --version
git --version
```

---

## 🚀 Instalasi Lokal

### 1. Clone Repository

```bash
git clone https://github.com/rizqyyourin/e-vote.git
cd e-vote
```

### 2. Install Composer Dependencies

```bash
composer install
```

### 3. Setup Environment File

```bash
# Copy .env.example ke .env
cp .env.example .env

# Atau jika menggunakan Windows PowerShell:
Copy-Item .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Setup Database

```bash
# Jalankan migration (membuat tabel di database)
php artisan migrate

# (Optional) Seed database dengan data test
php artisan db:seed
```

### 6. Install NPM Dependencies

```bash
npm install
```

### 7. Build Frontend Assets

```bash
# Development build dengan hot reload
npm run dev

# Production build (dalam terminal terpisah saat production)
npm run build
```

---

## ⚙️ Konfigurasi

### Konfigurasi Database (.env)

Database sudah dikonfigurasi untuk SQLite secara default. File database akan dibuat di `database/database.sqlite`.

```env
DB_CONNECTION=sqlite
DB_DATABASE=/full/path/to/database/database.sqlite
```

Jika ingin menggunakan database lain, ubah konfigurasi di `.env`:

```env
# MySQL
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=e_voting
DB_USERNAME=root
DB_PASSWORD=password

# PostgreSQL
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=e_voting
DB_USERNAME=postgres
DB_PASSWORD=password
```

### Konfigurasi Mail (Optional)

Jika ingin mengirim email notifikasi:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@evoting.app
```

### Konfigurasi App

```env
APP_NAME="E-Voting"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000
```

---

## 🎮 Menjalankan Aplikasi

### Terminal 1: Jalankan Server Laravel

```bash
php artisan serve
```

Server akan berjalan di `http://127.0.0.1:8000`

### Terminal 2: Jalankan Vite Dev Server (untuk hot reload)

```bash
npm run dev
```

### Akses Aplikasi

- **Website:** http://127.0.0.1:8000
- **Login:** Klik tombol "Masuk" atau langsung ke `/login`

---

## 🗄️ Struktur Database

### Tabel Pengguna (`users`)
```
- id: integer (primary key)
- name: string
- email: string (unique)
- password: string (bcrypt hashed)
- timezone: string
- created_at: timestamp
- updated_at: timestamp
```

### Tabel Voting (`votings`)
```
- id: integer (primary key)
- title: string
- description: text
- status: enum (not_started, ongoing, finished)
- started_at: timestamp
- ended_at: timestamp
- admin_id: foreign key (users.id)
- created_at: timestamp
- updated_at: timestamp
```

### Tabel Calon (`candidates`)
```
- id: integer (primary key)
- voting_id: foreign key (votings.id)
- name: string
- photo: string (path)
- created_at: timestamp
- updated_at: timestamp
```

### Tabel Suara (`votes`)
```
- id: integer (primary key)
- voting_id: foreign key (votings.id)
- voter_id: foreign key (users.id)
- candidate_id: foreign key (candidates.id)
- created_at: timestamp
- updated_at: timestamp
- unique(voting_id, voter_id) - Satu user hanya bisa voting sekali per voting
```

---

## 📖 Panduan Penggunaan

### Sebagai Pembuat Voting (Admin)

1. **Login/Register** → Buat akun di `/register`
2. **Buat Voting** → Klik "Buat Voting" di dashboard
3. **Tambah Calon** → Input nama calon di form
4. **Atur Jadwal** → Tentukan waktu mulai dan selesai
5. **Simpan** → Voting siap dimulai
6. **Mulai Voting** → Klik tombol "Mulai Voting"
7. **Selesaikan** → Klik tombol "Selesaikan Voting"
8. **Lihat Hasil** → Dashboard menampilkan hasil dengan grafik

### Sebagai Pemilih (Voter)

1. **Login/Register** → Buat akun di `/register`
2. **Lihat Voting** → Voting aktif ditampilkan di dashboard
3. **Pilih Calon** → Klik voting dan pilih calon yang diinginkan
4. **Konfirmasi** → Klik tombol "Pilih" untuk menyelesaikan
5. **Lihat Riwayat** → Tab "Riwayat Voting" menampilkan voting yang sudah diikuti
6. **Download PDF** → Klik "Unduh PDF" untuk mendapatkan hasil voting

---

## 🔐 Akun Test

Saat melakukan `php artisan db:seed`, sistem akan membuat akun test:

| Email | Password | Peran | Status |
|-------|----------|-------|--------|
| `rizqyyourin6@gmail.com` | `password` | Voter/Admin | Active |

Anda juga bisa membuat akun baru langsung di halaman register.

---

## 📱 Struktur Folder Penting

```
e-vote/
├── app/
│   ├── Http/Controllers/       # Controller aplikasi
│   ├── Livewire/              # Komponen Livewire
│   │   ├── Voter/             # Komponen voter
│   │   ├── Admin/             # Komponen admin
│   │   └── ConfirmModal.php    # Modal reusable
│   ├── Models/                # Model Eloquent
│   └── Services/              # Service layer
├── resources/
│   ├── css/
│   │   └── app.css            # Global styles
│   ├── js/
│   │   └── app.js             # Global JavaScript
│   └── views/
│       ├── layouts/           # Layout templates
│       ├── livewire/          # Livewire views
│       ├── auth/              # Auth pages
│       ├── voter/             # Voter pages
│       ├── voting/            # Voting pages
│       └── components/        # Blade components
├── routes/
│   └── web.php                # Web routes
├── database/
│   ├── migrations/            # Database migrations
│   ├── seeders/               # Database seeders
│   └── database.sqlite        # SQLite database
├── public/
│   ├── index.php              # Entry point
│   ├── robots.txt
│   └── build/                 # Vite build output
└── vite.config.js             # Vite configuration
```

---

## 🔧 Troubleshooting

### Error: "No application encryption key has been specified"
```bash
php artisan key:generate
```

### Error: "Database file not found"
```bash
php artisan migrate
```

### Error: "node_modules not found"
```bash
npm install
npm run dev
```

### Error: "Port 8000 already in use"
```bash
php artisan serve --port=8001
# Atau
lsof -i :8000
kill -9 <PID>
```

### Vite Hot Module Replacement tidak berfungsi
- Pastikan `npm run dev` berjalan di terminal terpisah
- Refresh halaman browser secara manual jika diperlukan
- Clear browser cache (Ctrl+Shift+Delete)

---

## 📞 Support & Kontribusi

Untuk pertanyaan atau masalah:
1. Buka issue di GitHub
2. Pull request disambut untuk perbaikan
3. Dokumentasi dapat diperbarui sesuai kebutuhan

---

## 📄 Lisensi

Aplikasi ini menggunakan lisensi MIT. Lihat file `LICENSE` untuk detail lengkap.

---

## ✨ Fitur Teknologi

- ✅ **Livewire 3** - Komponen reaktif tanpa JavaScript
- ✅ **Alpine.js** - DOM manipulation yang ringan
- ✅ **Tailwind CSS v4** - Utility-first CSS framework
- ✅ **Vite** - Build tool cepat
- ✅ **Laravel Blade** - Template engine yang powerful
- ✅ **Eloquent ORM** - Database abstraction
- ✅ **SQLite** - Database embedded (bisa diganti)

---

## 🎉 Selesai!

Aplikasi siap digunakan. Buka http://127.0.0.1:8000 di browser Anda.

**Happy Voting! 🗳️**

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
