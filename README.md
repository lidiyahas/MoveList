# Movelist - Movie Watchlist Website

## Deskripsi Singkat

Movelist adalah aplikasi web berbasis PHP dan MongoDB yang memungkinkan pengguna untuk mencari film, menyimpan daftar film yang ingin ditonton (watchlist), menambahkan catatan pribadi pada setiap film, serta menonton trailer film langsung dari YouTube.

Data film diperoleh melalui OMDb API, sedangkan autentikasi pengguna mendukung login dan registrasi menggunakan akun lokal maupun Google OAuth.

---

## Fitur

- Login dan Register pengguna
- Login menggunakan Google OAuth
- Pencarian film menggunakan OMDb API
- Menambahkan film ke watchlist
- Mengedit catatan pada film
- Menghapus film dari watchlist
- Menampilkan detail film (poster, tahun rilis, aktor, sinopsis)
- Menampilkan trailer film dari YouTube
- Halaman profil pengguna
- Penyimpanan data menggunakan MongoDB Atlas

---

## Teknologi yang Digunakan

### Frontend
- HTML
- CSS/TailwindCSS
- JavaScript

### Backend
- PHP 

### Database
- MongoDB Atlas

### API dan Authentication
- OMDb API
- YouTube Data API 
- Google OAuth 

### Library PHP
- mongodb/mongodb
- google/apiclient

---

## Struktur Folder

```text
watchlist/
│
├── api/
│   └── omdb.php
│
├── auth/
│   ├── login.php
│   ├── register.php
│   ├── google_login.php
│   └── logout.php
│
├── config/
│   ├── db.php
│   └── google.php
│
├── watchlist/
│   ├── index.php
│   ├── add.php
│   ├── edit.php
│   ├── delete.php
│   └── profile.php
│
├── vendor/
├── composer.json
└── README.md
```

---

## Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/lidiyahas/MoveList.git
```

Atau download project dan letakkan pada:

```text
xampp/htdocs/watchlist
```

### 2. Install Dependency

```bash
composer install
```

atau

```bash
composer require mongodb/mongodb
composer require google/apiclient
```

### 3. Aktifkan Extension MongoDB

Buka file `php.ini` lalu tambahkan:

```ini
extension=mongodb
```

Restart Apache setelah melakukan perubahan.

### 4. Konfigurasi MongoDB Atlas

Edit file:

```text
config/db.php
```

Masukkan connection string MongoDB Atlas:

```php
$client = new MongoDB\Client(
    "mongodb+srv://username:password@cluster.mongodb.net/"
);
```

### 5. Konfigurasi OMDb API

Daftar dan dapatkan API key dari OMDb.

Edit file:

```text
api/omdb.php
```

Masukkan API key:

```php
$apiKey = "YOUR_OMDB_API_KEY";
```

### 6. Konfigurasi YouTube API

Aktifkan YouTube Data API v3 melalui Google Cloud Console.

Masukkan API key ke file:

```text
api/omdb.php
```

```php
$youtubeApiKey = "YOUR_YOUTUBE_API_KEY";
```

### 7. Konfigurasi Google OAuth

Tambahkan redirect URI:

```text
http://localhost/watchlist/auth/google_login.php
```

Edit file:

```text
config/google.php
```

Masukkan:

```php
$client->setClientId("CLIENT_ID");
$client->setClientSecret("CLIENT_SECRET");
```

---

## Menjalankan Aplikasi

### 1. Jalankan Apache

Melalui XAMPP Control Panel.

### 2. Buka Browser

```text
http://localhost/watchlist
```

### 3. Login

Pengguna dapat login menggunakan akun lokal maupun Google.

### 4. Gunakan Aplikasi

- Cari film
- Tambahkan film ke watchlist
- Tambahkan catatan pribadi
- Tonton trailer film
- Kelola daftar film yang ingin ditonton

---

## Pengembang

Final Project Mata Kuliah Basis Data Non Relasional.
