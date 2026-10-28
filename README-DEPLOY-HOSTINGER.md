# SI RUMAH BANTEN — Paket Laravel Hostinger

**Status:** source code MVP siap instalasi, **belum live**. Paket ini **tidak menyertakan `vendor/`**, karena dependency Laravel perlu diinstal lewat Composer pada hosting (atau di komputer lokal PHP 8.2+ lalu diunggah). Tidak ada akses ke akun Hostinger, database, atau kredensial pengguna dalam paket ini. Sebelum produksi lakukan QA keamanan & acceptance test.

## Penempatan di Hostinger

Ekstrak ZIP sehingga struktur server menjadi:

```
/home/uXXXX/domains/.../  (atau home directory yang memuat dua folder yang disebut pengguna)
├── laravel-sirumah-polkesten/
│   ├── app/ bootstrap/ config/ database/ resources/ routes/ storage/
│   ├── composer.json
│   ├── .env
│   ├── artisan
│   └── vendor/  ← dihasilkan oleh Composer
└── public_html/
    ├── .htaccess
    ├── index.php
    └── assets/
        ├── app.css
        └── app.js
```

**Penting:** index.php di public_html menggunakan `dirname(__DIR__).'/laravel-sirumah-polkesten'`, karena dua folder harus berada pada direktori induk yang sama. Bila Hostinger memiliki struktur berbeda, perbaiki `$base` ke path absolut yang benar. Jangan taruh `.env`, `vendor`, atau `storage` di `public_html`.

## Instalasi SSH Hostinger

1. Di hPanel siapkan MySQL Database dan user berizin, pastikan domain mengarah ke folder `public_html` dan SSL aktif.
2. Upload dan ekstrak masing-masing folder sesuai tujuan.
3. Via SSH jalankan (ganti path sesuai kenyataan):

```sh
cd ~/laravel-sirumah-polkesten
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

4. Sunting `.env`: `DB_HOST=127.0.0.1`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, `APP_URL=https://sirumah.poltekkesbanten.ac.id`, `APP_DEBUG=false`. Sesuaikan host DB sesuai Hostinger. Jangan bagikan `.env` atau password melalui percakapan.
5. Jalankan:

```sh
php artisan migrate --force
php artisan db:seed --force
php artisan config:cache
php artisan view:cache
php artisan route:cache
```

6. Pastikan `storage/` dan `bootstrap/cache/` dapat ditulis user PHP; set permission minimum yang diperlukan sesuai konfigurasi Hostinger. PHP memerlukan ekstensi lazim Laravel termasuk pdo_mysql, mbstring, openssl, tokenizer, xml, fileinfo, curl. Atur `upload_max_filesize>=20M` dan `post_max_size>=105M` jika menerima 5 file × 20MB. Batasi durasi video jika perlu.
7. Buat superadmin lewat CLI **dengan password rahasia yang dimasukkan secara interaktif**:

```sh
php artisan sirumah:admin singgih.handika@poltekkesbanten.ac.id
php artisan sirumah:admin webmaster@poltekkesbanten.ac.id
php artisan sirumah:admin qowiyrofi@poltekkesbanten.ac.id
```

8. Buat verifikator (tidak menggunakan kata sandi default):

```sh
php artisan sirumah:admin munawirsajali188@gmail.com --role=verifier
php artisan sirumah:admin iwan.setiawan@poltekkesbanten.ic.id --role=verifier
```

`singgih.handika@poltekkesbanten.ac.id` sudah superadmin dan memiliki hak verifikasi. **Periksa ejaan domain `ic.id` pada akun Iwan**, karena mungkin berbeda dari domain institusi. Admin jurusan lain dibuat dari antarmuka superadmin (menu Pengaturan).

## Aturan master data

- Tangerang: Gedung A–E, masing-masing Lantai 1.
- Serang: Gedung A, Lantai 1–3.
- Rangkasbitung: Gedung A–D, masing-masing Lantai 1.
- **Nomor kamar sengaja belum diisi.** Superadmin menambahnya di Pengaturan → Tambah Master → Kamar → pilih lantai. Dropdown mahasiswa otomatis membaca kamar yang sudah diinput.
- Admin jurusan hanya membaca dan memperbarui laporan mahasiswa dari jurusannya. Verifikator dan superadmin dapat membaca seluruh laporan.

## Fungsi yang telah dikodekan

Pendaftaran mahasiswa; login/logout; dashboard mobile; laporan dengan kategori dan media foto/video (wajib, hingga 5 file @20MB); validasi relasi asrama–gedung–lantai–kamar; nomor tiket; pencarian/filter laporan; status diterima, ditangani, dijadwalkan, selesai; tanggal perbaikan; histori perubahan; halaman notifikasi di dalam aplikasi; akses file bukti yang harus login; manajemen lokasi dan akun petugas; pengaktifan/nonaktivasi akun.

## Batasan versi ini

- Notifikasi **in-app** saat mahasiswa membuka halaman Notifikasi / Tracking; **belum** ada push notification, email, WhatsApp, atau realtime websocket.
- Belum ada upload bukti *setelah* perbaikan, balasan diskusi dua arah, ekspor Excel, audit log lengkap, reset password via email, email verification, reCAPTCHA, atau pelacakan read/unread.
- Registrasi mahasiswa pada MVP ini terbuka: sebelum produksi sebaiknya tambahkan validasi email institusi/SSO dan anti-spam, kebijakan privasi dan retensi media.
- Belum dijalankan end-to-end dengan server Laravel karena Composer/network paket tidak tersedia dalam lingkungan pembuatan. Wajib lakukan pengujian di staging, termasuk autentikasi, semua role, hak akses IDOR, file 20MB, dan upload video.

## Checklist uji cepat

1. Buka `/register`, buat mahasiswa, login.
2. Buat kamar lewat superadmin; pastikan dropdown dinamis benar.
3. Buat pengaduan bergambar/video; halaman detail memperlihatkan bukti.
4. Login verifikator dan ubah status `Akan diperbaiki` dengan tanggal dan catatan.
5. Login kembali sebagai mahasiswa, periksa Tracking & Notifikasi.
6. Pastikan mahasiswa A tidak dapat membuka `/reports/{id}` dan file bukti mahasiswa B.
7. Verifikasi SSL dan tidak adanya akses publik terhadap `.env`, folder Laravel, dan storage.
