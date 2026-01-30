<p align="center"><a href="https://bpsdm.komdigi.go.id/upt/makassar/" target="_blank"><img src="readme/Simagang.png" height="250" alt="Simagang Hero"></a></p>

<p align="center">
<a href="https://www.php.net/"><img src="https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php&logoColor=white" alt="PHP 8.2+"></a>
<a href="https://laravel.com"><img src="https://img.shields.io/badge/Laravel-10.x-FF2D20?logo=laravel&logoColor=white" alt="Laravel 10"></a>
<a href="https://www.mysql.com/"><img src="https://img.shields.io/badge/MySQL-5.7+-4479A1?logo=mysql&logoColor=white" alt="MySQL"></a>
<a href="https://nodejs.org/"><img src="https://img.shields.io/badge/Node.js-16+-339933?logo=node.js&logoColor=white" alt="Node.js"></a>
<a href="https://vitejs.dev/"><img src="https://img.shields.io/badge/Build-Vite-646CFF?logo=vite&logoColor=white" alt="Vite"></a>
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>

# Simagang - Sistem Manajemen Magang

Aplikasi web berbasis Laravel untuk mengelola sistem magang dengan fitur lengkap untuk Admin, Mentor, dan Intern.

## 📋 Daftar Isi

- [Fitur Utama](#fitur-utama)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi](#instalasi)
- [Konfigurasi](#konfigurasi)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)
- [Struktur Database](#struktur-database)
- [Penggunaan](#penggunaan)
- [Troubleshooting](#troubleshooting)

## ✨ Fitur Utama

### Untuk Admin
- Dashboard monitoring
- Manajemen Mentor dan Intern
- Monitoring kehadiran (Attendance)
- Monitoring logbook
- Monitoring laporan akhir
- Manajemen Micro Skill
- Leaderboard Micro Skill

### Untuk Mentor
- Dashboard mentor
- Monitoring intern yang dibimbing
- Review kehadiran intern
- Review logbook intern
- Review dan grading laporan akhir
- Monitoring Micro Skill submission
- Leaderboard Micro Skill

### Untuk Intern
- Dashboard intern
- Absensi check-in/check-out dengan foto
- Manajemen logbook harian
- Submission Micro Skill
- Submission laporan akhir
- Leaderboard Micro Skill
- Edit profil

## 🔧 Persyaratan Sistem

- **PHP**: >= 8.2
- **Composer**: >= 2.0
- **Node.js**: >= 16.x
- **NPM** atau **Yarn**: Versi terbaru
- **Database**: MySQL 5.7+ atau MariaDB 10.3+
- **Web Server**: Apache atau Nginx (atau gunakan PHP built-in server untuk development)
- **Extension PHP yang diperlukan**:
  - OpenSSL
  - PDO
  - Mbstring
  - MySqli
  - Tokenizer
  - XML
  - Ctype
  - Curl
  - JSON
  - BCMath
  - Fileinfo
  - GD atau Imagick (untuk manipulasi gambar)
  - Zip

## 📦 Instalasi

### 1. Clone Repository

```bash
git clone <repository-url>
cd Simagang-Komdigi-2026
```

### 2. Install Dependencies PHP

```bash
composer install
```

### 3. Install Dependencies JavaScript

```bash
npm install
```

atau jika menggunakan Yarn:

```bash
yarn install
```

### 4. Setup Environment File

Copy file `.env.example` menjadi `.env`:

```bash
copy .env.example .env
```

Atau di Linux/Mac:

```bash
cp .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=simagang
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Buat Database

Buat database baru di MySQL:

```sql
CREATE DATABASE simagang CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 8. Jalankan Migration

```bash
php artisan migrate
```

### 9. (Opsional) Jalankan Seeder

Jika ada seeder untuk data awal:

```bash
php artisan db:seed
```

### 10. Buat Storage Link

```bash
php artisan storage:link
```

### 11. Set Permissions (Linux/Mac)

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## ⚙️ Konfigurasi

### Konfigurasi Environment (.env)

Pastikan konfigurasi berikut sudah benar di file `.env`:

```env
APP_NAME=Simagang
APP_ENV=local
APP_KEY=base64:... (akan di-generate oleh artisan key:generate)
APP_DEBUG=true
APP_URL=http://localhost

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=simagang
DB_USERNAME=root
DB_PASSWORD=

# Mail Configuration (jika diperlukan)
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@simagang.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Konfigurasi Storage

Pastikan folder `storage` dan `bootstrap/cache` memiliki permission yang tepat untuk menulis file.

## 🚀 Menjalankan Aplikasi

### Development Mode

1. **Jalankan Laravel Development Server**:

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

2. **Jalankan Vite Dev Server** (di terminal terpisah):

```bash
npm run dev
```

atau:

```bash
yarn dev
```

### Production Mode

1. **Build Assets**:

```bash
npm run build
```

atau:

```bash
yarn build
```

2. **Optimize Application**:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. **Jalankan dengan Web Server** (Apache/Nginx)

Konfigurasi web server untuk menunjuk ke folder `public` sebagai document root.

## 📊 Struktur Database

Aplikasi menggunakan beberapa tabel utama:

- `users` - Tabel pengguna (Admin, Mentor, Intern)
- `interns` - Data intern/mahasiswa magang
- `mentors` - Data mentor/pembimbing
- `attendances` - Data kehadiran
- `logbooks` - Data logbook harian
- `final_reports` - Laporan akhir magang
- `micro_skill_submissions` - Submission micro skill

Untuk melihat struktur lengkap, lihat file migration di folder `database/migrations/`.

## 👥 Penggunaan

### Membuat User Admin Pertama

Anda dapat membuat user admin pertama melalui seeder atau tinker:

```bash
php artisan tinker
```

Kemudian jalankan:

```php
$user = \App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@simagang.com',
    'password' => bcrypt('password'),
    'role' => 'admin'
]);
```

### Akses Aplikasi

1. Buka browser dan akses `http://localhost:8000`
2. Login dengan kredensial yang sudah dibuat
3. Pilih role sesuai kebutuhan (Admin/Mentor/Intern)

## 🔍 Troubleshooting

### Error: "Fonts Poppins pada sertifikat tidak terbaca"

Jika saat membuka / mencetak sertifikat font **Poppins** tidak muncul dengan benar (fallback ke font standar), lakukan langkah berikut:

1. **Pastikan file font sudah disimpan di storage**

   Simpan file TTF Poppins ke:

   ```text
   storage/app/fonts/
   ```

   Contoh:
   - `storage/app/fonts/Poppins-Extralight.ttf`
   - `storage/app/fonts/Poppins-Regular.ttf`
   - `storage/app/fonts/Poppins-SemiBold.ttf`

2. **Sesuaikan path font di route `/convert-font`**

   Buka file:

   ```text
   routes/web.php
   ```

   Lalu ubah nilai `$fontPath` sesuai font yang ingin di-convert, misalnya:

   ```php
   // ...existing code...
   Route::get('/convert-font', function () {
       // Sesuaikan nama file font yang akan di-convert
       $fontPath = storage_path('app/fonts/Poppins-Extralight.ttf');

       TCPDF_FONTS::addTTFfont(
           $fontPath,
           'TrueTypeUnicode',
           '',
           32
       );

       return 'Poppins Extralight berhasil di-convert';
   });
   // ...existing code...
   ```

3. **Jalankan konversi font lewat browser**

   - Pastikan server sudah berjalan:

     ```bash
     php artisan serve
     ```

   - Akses di browser:

     ```text
     http://localhost:8000/convert-font
     ```

   - Jika berhasil, akan muncul pesan seperti:
     `Poppins Extralight berhasil di-convert`.

4. **Ulangi untuk setiap varian font Poppins**

   Untuk setiap varian font yang digunakan di sertifikat:

   - Ubah `$fontPath` ke nama file font lain (misal `Poppins-Regular.ttf`, `Poppins-SemiBold.ttf`, dll).
   - Refresh kembali URL:

     ```text
     http://localhost:8000/convert-font
     ```

   - Lakukan sampai semua font yang dipakai di sertifikat sudah di-convert.

5. **Cek ulang tampilan sertifikat**

   Setelah semua font dikonversi:
   - Buka kembali halaman sertifikat di aplikasi.
   - Pastikan font Poppins sudah terbaca dan tampil sesuai desain.

### Error: "Class 'PDO' not found"

Install extension PDO untuk PHP:

```bash
# Ubuntu/Debian
sudo apt-get install php-pdo php-mysql

# CentOS/RHEL
sudo yum install php-pdo php-mysql
```

### Error: "The stream or file could not be opened"

Pastikan folder `storage` dan `bootstrap/cache` memiliki permission write:

```bash
chmod -R 775 storage bootstrap/cache
```

### Error: "SQLSTATE[HY000] [2002] Connection refused"

Pastikan:
1. MySQL/MariaDB sudah berjalan
2. Konfigurasi database di `.env` sudah benar
3. Database sudah dibuat

### Error: "Vite manifest not found"

Jalankan build assets:

```bash
npm run build
```

Atau jalankan dev server:

```bash
npm run dev
```

### Error: "No application encryption key has been specified"

Generate application key:

```bash
php artisan key:generate
```

## 📝 Catatan Tambahan

- Pastikan `storage/app/public` folder ada dan memiliki permission yang tepat
- Untuk production, set `APP_DEBUG=false` di file `.env`
- Gunakan HTTPS untuk production
- Backup database secara berkala

## 🤝 Kontribusi

Jika ingin berkontribusi pada project ini, silakan buat pull request atau issue.

---

**Dibuat dengan ❤️ menggunakan Laravel Framework**