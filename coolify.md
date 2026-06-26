# Panduan Deployment Gallery Puan ke VPS menggunakan Coolify

Panduan ini berisi langkah-langkah detail untuk mendeploy aplikasi Laravel (Gallery Puan) ke VPS yang sudah terinstall [Coolify](https://coolify.io/).

## 1. Persiapan Repository
Pastikan seluruh perubahan terbaru pada project ini sudah di-commit dan di-push ke repository Git (GitHub, GitLab, atau Bitbucket). Coolify akan menarik source code secara langsung dari repository tersebut.

## 2. Menambahkan Project di Coolify
1. Login ke dashboard Coolify Anda.
2. Buka menu **Projects** dan klik **Add New Project** (atau gunakan project yang sudah ada).
3. Pilih **Environment** (contoh: `Production`).
4. Klik **Add Resource** dan pilih **Application**.
5. Pilih penyedia Git Anda (misal: **GitHub** - mendukung *Public* maupun *Private* repository).
6. Pilih repository `gallery-puan` dan branch utama (biasanya `main` atau `master`).

## 3. Konfigurasi Build (Docker Compose)
Coolify mendukung deployment menggunakan **Docker Compose** yang akan membaca file `docker-compose.yml` dan `Dockerfile` di dalam repositori ini.

1. Pada bagian **Build Pack**, ubah dari Nixpacks (jika default) menjadi **Docker Compose**.
2. Pastikan field **Docker Compose File Location** menunjuk ke `/docker-compose.yml`.
3. Coolify akan secara otomatis mem-build image menggunakan `Dockerfile` yang telah disediakan dan menjalankan container `app` serta `db` (MySQL). Proses instalasi library (`composer install`, `npm run build`) sudah ditangani di dalam Dockerfile.

## 4. Konfigurasi Environment Variables (.env)
Anda tidak perlu mengupload file `.env`. Sebagai gantinya, atur variabel di dashboard. Masuk ke tab **Environment Variables** pada aplikasi Anda di Coolify dan tambahkan variabel-variabel penting ini (ubah nilainya sesuai dengan environment VPS Anda):

```env
APP_NAME="Gallery Puan"
APP_ENV=production
APP_KEY="base64:...." # Masukkan APP_KEY dari local Anda, atau jalankan php artisan key:generate di local dan copy hasilnya
APP_DEBUG=false
APP_URL=https://gallerypuanid.my.id
ALLOWED_HOSTS=gallerypuanid.my.id

# Konfigurasi Database (Sudah terhubung otomatis via docker-compose)
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=gallery_puan
DB_USERNAME=root
DB_PASSWORD=secret

# Konfigurasi SMTP (Untuk email After-Sales, Forgot Password, dll)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=email_anda@gmail.com
MAIL_PASSWORD=app_password_gmail_anda
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=email_anda@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

# Konfigurasi API Eksternal (Midtrans & RajaOngkir)
MIDTRANS_SERVER_KEY=
MIDTRANS_CLIENT_KEY=
MIDTRANS_IS_PRODUCTION=true

RAJAONGKIR_API_KEY=

# Konfigurasi Livewire & Session
SESSION_DRIVER=database # atau file
CACHE_DRIVER=database # atau file
```

## 5. Post-Deployment (Otomatis)
Aplikasi ini sudah menggunakan `docker-entrypoint.sh` yang secara otomatis akan:
- Menunggu database MySQL siap.
- Menjalankan migrasi database (`php artisan migrate --force`).
- Menjalankan seeder (`php artisan db:seed --force`) yang berisi **data persis dengan database lokal Anda**.
- Membuat symlink storage.
- Melakukan cache config, route, dan view.

Anda tidak perlu menjalankan perintah post-deployment manual di Coolify.

## 6. Setup Domain dan SSL
1. Masuk ke tab **Settings** pada aplikasi di Coolify.
2. Di bagian **Domains**, masukkan domain Anda: `https://gallerypuanid.my.id`.
3. **Penting**: Pastikan Anda sudah mengarahkan **A Record** pada pengaturan DNS domain `gallerypuanid.my.id` ke IP VPS Coolify Anda.
4. Coolify secara otomatis akan menerbitkan dan memperbarui sertifikat SSL (HTTPS) dari Let's Encrypt.

## 7. Deploy Aplikasi
1. Jika semua pengaturan di atas sudah selesai, klik tombol **Deploy** di pojok kanan atas atau tab *Deployments*.
2. Anda bisa memantau proses instalasi *dependencies* (PHP & Node.js) melalui **Deployment Logs**.
3. Jika berhasil, aplikasi akan berstatus **Healthy** dan siap diakses melalui domain Anda!

---
**Tips Tambahan:**
- Jika menggunakan fitur *upload gambar/produk*, pastikan *storage symlink* berfungsi (secara default Nixpacks menanganinya, namun jika bermasalah Anda dapat menjalankan `php artisan storage:link` di *Execute Command*).
- Anda bisa menambahkan Database MySQL langsung melalui Coolify (Add Resource -> Database -> MySQL) lalu menghubungkannya ke aplikasi ini.
