# Aplikasi Portal Berita Laravel
Aplikasi Portal Berita Merupakah aplikasi yang dibuat untuk memenuhi project Magang, Pada project ini saya menggunakan Service Layer Design Sebagai Arsitektur Foldernya yaitu memisahkan logika bisnis di controller ke tiap class masing-masing Service.


## 📑 Daftar Isi

- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi](#instalasi)
- [Konfigurasi](#konfigurasi)
- [Struktur Database](#struktur-database)
- [Seeder](#seeder)
- [Fitur Utama](#fitur-utama)
- [Peran Pengguna](#peran-pengguna)
- [Rute Utama](#rute-utama)

---
## ✅ Persyaratan Sistem

- PHP >= 8.2
- Composer
- SQLite atau database lain yang didukung Laravel
---

## ⚙️ Instalasi

1. **Clone repositori ini:**

```bash
git clone https://github.com/username/portal-berita-winnicode.git
cd portal-berita-winnicode
```
2. **Install Dependensi PHP:**
```bash
composer install
```

3.  **Salin file environment:**
```  
cp .env.example .env
```

4. **Generate application key:**
```
php artisan key:generate
```

5. **Jalankan Migrasi dan Seeder :**
```
php artisan migrate --seed
```
---
## ⚙️ Konfigurasi
Ubah file .env sesuai kebutuhan:
```
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

# Konfigurasi Untuk Mailtrap
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=isi dengan username mailtrap
MAIL_PASSWORD=isi dengan password mailtrap
MAIL_ENCRYPTION=tls
MAIL_FROM_NAME="${APP_NAME}"
```
---
## 🗃️ Struktur Database
- users — Data pengguna
- roles — Peran pengguna (Admin, Author, Reviewer)
- categories — Kategori artikel
- articles — Artikel berita dengan slug & view count
- article_review — Ulasan artikel oleh reviewer
- comments — Komentar artikel
- user_article_views — Pelacakan tampilan artikel
 ---
## 🌱 Seeder
Seeder akan otomatis dijalankan saat ```php artisan migrate --seed```
Seeder yang tersedia:
RolesSeeder: Admin, Author, Reviewer
CategorySeeder: Kategori berita dasar (Technology, Sports, Politics, dst)
UserSeeder: Pengguna default:
    - Admin: admin@example.com (password: password)
    - Editor: editor@example.com (password: password)
    - User: user1@example.com sampai user5@example.com (password: password)
ArticleSeeder: 50 artikel contoh
UserArticleViewSeeder: Data tampilan artikel
ArticleReviewSeeder: Data ulasan artikel

## 🧩 Fitur Utama
### Manajemen Artikel
- CRUD artikel
- Slug artikel
- Kategori artikel
- Hitung tampilan artikel

### Sistem Review
- Reviewer bisa meninjau artikel
- Status review: pending, approved, rejected
- Komentar dari reviewer ke author

### Komentar
- Komentar publik oleh pengguna
- Edit dan hapus komentar

### Manajemen Pengguna
- Registrasi & login
- Reset password

### Role & permission: Admin, Author, Reviewer

### Pencarian & Filtering
- Pencarian artikel berdasarkan keyword
- Filter berdasarkan kategori
