# Tabel Deskripsi Use Case — Gallery Puan

---

## A. Aktivitas Pengunjung & Consumer (Pelanggan)

---

### 1. Pencarian Produk

| **Nama Use Case** | Pencarian Produk |
|---|---|
| **Actor** | Pengunjung / Konsumen |
| **Tujuan** | Untuk memungkinkan pengguna mencari produk yang diinginkan berdasarkan kata kunci, kategori, atau rentang harga. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | Pengguna membuka halaman katalog produk. | Sistem menampilkan daftar produk dengan paginasi. |
| | Pengguna memasukkan kata kunci pada kolom pencarian. | Sistem memfilter produk berdasarkan kata kunci yang dimasukkan. |
| | Pengguna memilih filter kategori dari sidebar. | Sistem menampilkan produk yang termasuk dalam kategori yang dipilih. |
| | Pengguna mengatur rentang harga minimum dan maksimum. | Sistem menyaring produk berdasarkan rentang harga yang ditentukan. |
| | Pengguna memilih opsi pengurutan (termurah, termahal, terbaru). | Sistem mengurutkan daftar produk sesuai pilihan. |
| | | Sistem menampilkan hasil pencarian yang sesuai dengan seluruh kriteria. |

---

### 2. Detail Produk

| **Nama Use Case** | Detail Produk |
|---|---|
| **Actor** | Pengunjung / Konsumen |
| **Tujuan** | Untuk memungkinkan pengguna melihat informasi lengkap suatu produk sebelum memutuskan membeli. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | Pengguna mengklik salah satu produk pada halaman katalog. | Sistem mencari data produk berdasarkan kombinasi slug dan SKU. |
| | | Sistem menambah jumlah views_count produk. |
| | | Sistem menampilkan halaman detail produk yang berisi: galeri gambar, nama produk, harga, diskon (jika ada), status stok, SKU, dan deskripsi. |
| | | Sistem menampilkan rating dan ulasan dari konsumen lain. |
| | | Sistem mengecek status wishlist pengguna (jika sudah login). |

---

### 3. Register (Registrasi Konsumen)

| **Nama Use Case** | Registrasi Konsumen |
|---|---|
| **Actor** | Pengunjung |
| **Tujuan** | Untuk memungkinkan pengunjung membuat akun sebagai konsumen agar dapat mengakses fitur-fitur transaksi dalam sistem. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | Pengunjung mengakses halaman registrasi. | Sistem menampilkan formulir pendaftaran akun baru. |
| | Pengunjung mengisi data seperti nama, email, password, dan informasi lain yang dibutuhkan. | |
| | Pengunjung mengklik tombol "Daftar". | Sistem memvalidasi data yang diisi. |
| | | Jika valid, sistem menyimpan data pengguna ke dalam basis data dan membuat akun baru. |
| | | Sistem menampilkan notifikasi bahwa registrasi berhasil. |
| | | Sistem mengirim email sambutan (WelcomeEmail) ke alamat email pengguna. |
| | Pengunjung dapat login menggunakan akun yang baru dibuat. | |

---

### 4. Login

| **Nama Use Case** | Login |
|---|---|
| **Actor** | Konsumen |
| **Tujuan** | Untuk memungkinkan konsumen mengakses akun mereka dan menggunakan fitur-fitur yang memerlukan autentikasi. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | Konsumen mengakses halaman login. | Sistem menampilkan formulir login. |
| | Konsumen memasukkan email dan password. | |
| | Konsumen mengklik tombol "Login". | Sistem memvalidasi kredensial yang dimasukkan. |
| | | Jika kredensial benar, sistem mengarahkan konsumen ke halaman utama. |
| | | Jika kredensial salah, sistem menampilkan pesan error. |

---

### 5. Menambahkan Wishlist

| **Nama Use Case** | Menambahkan Wishlist |
|---|---|
| **Actor** | Konsumen (sudah login) |
| **Tujuan** | Untuk memungkinkan konsumen menyimpan produk favorit ke dalam daftar wishlist agar mudah diakses kembali. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | Konsumen membuka halaman detail produk. | Sistem menampilkan tombol wishlist (ikon hati). |
| | Konsumen mengklik tombol wishlist. | Sistem mengecek apakah produk sudah ada di wishlist konsumen. |
| | | Jika belum ada, sistem menyimpan produk ke daftar wishlist konsumen. |
| | | Jika sudah ada, sistem menghapus produk dari wishlist (toggle). |
| | | Sistem memperbarui tampilan ikon wishlist. |

---

### 6. Menambahkan Produk ke Keranjang Belanja

| **Nama Use Case** | Menambahkan Produk ke Keranjang Belanja |
|---|---|
| **Actor** | Konsumen (sudah login) |
| **Tujuan** | Untuk memungkinkan konsumen menambahkan produk yang ingin dibeli ke dalam keranjang belanja. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | Konsumen membuka halaman detail produk. | Sistem menampilkan informasi produk dan form jumlah (qty). |
| | Konsumen mengisi jumlah produk yang diinginkan. | |
| | Konsumen mengklik tombol "Tambah ke Keranjang". | Sistem memvalidasi ketersediaan stok. |
| | | Sistem menyimpan item ke dalam keranjang belanja konsumen. |
| | | Sistem menampilkan notifikasi bahwa produk berhasil ditambahkan. |
| | | Sistem memperbarui jumlah item di ikon keranjang. |

---

### 7. Melakukan Transaksi (Checkout)

| **Nama Use Case** | Melakukan Transaksi |
|---|---|
| **Actor** | Konsumen (sudah login) |
| **Tujuan** | Untuk memungkinkan konsumen menyelesaikan pembelian dengan memilih alamat pengiriman, jasa kirim, dan melakukan pembayaran. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | Konsumen membuka halaman keranjang. | Sistem menampilkan daftar produk di keranjang. |
| | Konsumen memilih item yang akan dibeli dan mengklik "Checkout". | Sistem mengarahkan ke halaman checkout. |
| | Konsumen memilih alamat pengiriman yang sudah tersimpan atau menambah alamat baru. | Sistem menampilkan daftar alamat konsumen dan form provinsi/kota dari RajaOngkir. |
| | Konsumen memilih kurir pengiriman (JNE, TIKI, Pos). | Sistem memanggil API RajaOngkir untuk menghitung ongkos kirim. |
| | Konsumen memasukkan kode voucher (opsional). | Sistem menampilkan pilihan layanan dan biaya pengiriman. |
| | | Sistem menerapkan diskon voucher jika valid. |
| | Konsumen memilih metode pembayaran. | Sistem menampilkan ringkasan pesanan dan total pembayaran. |
| | Konsumen mengklik tombol "Bayar". | Sistem membuat data pesanan dan memanggil Midtrans Snap API. |
| | | Sistem mengarahkan konsumen ke halaman pembayaran Midtrans. |
| | Konsumen menyelesaikan pembayaran melalui Midtrans. | Sistem menerima callback dari Midtrans. |
| | | Sistem memperbarui status pesanan menjadi "processing" jika sukses. |
| | | Sistem mengirim notifikasi ke konsumen dan admin. |

---

### 8. Klaim Voucher

| **Nama Use Case** | Klaim Voucher |
|---|---|
| **Actor** | Konsumen (sudah login) |
| **Tujuan** | Untuk memungkinkan konsumen menggunakan kode voucher diskon saat bertransaksi. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | Konsumen membuka halaman keranjang atau checkout. | Sistem menampilkan kolom input kode voucher. |
| | Konsumen memasukkan kode voucher. | |
| | Konsumen mengklik tombol "Terapkan". | Sistem memvalidasi kode voucher (masa berlaku, minimum belanja, jumlah pemakaian). |
| | | Jika valid, sistem menghitung diskon dan memperbarui total pembayaran. |
| | | Jika tidak valid, sistem menampilkan pesan kesalahan. |

---

### 9. Notifikasi

| **Nama Use Case** | Notifikasi |
|---|---|
| **Actor** | Konsumen (sudah login) |
| **Tujuan** | Untuk memungkinkan konsumen melihat pemberitahuan terkait status pesanan dan aktivitas akun. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | Konsumen mengklik ikon notifikasi di navbar. | Sistem menampilkan daftar notifikasi yang belum dibaca. |
| | | Sistem menampilkan notifikasi seperti: pembayaran berhasil, pesanan dikirim, pesanan selesai. |
| | Konsumen mengklik salah satu notifikasi. | Sistem menandai notifikasi sebagai sudah dibaca. |
| | | Sistem mengarahkan konsumen ke halaman terkait (misal: detail pesanan). |
| | Konsumen dapat menandai semua notifikasi sebagai sudah dibaca. | Sistem memperbarui status seluruh notifikasi menjadi read. |

---

### 10. Melihat Status Pesanan

| **Nama Use Case** | Melihat Status Pesanan |
|---|---|
| **Actor** | Konsumen (sudah login) |
| **Tujuan** | Untuk memungkinkan konsumen memantau perkembangan status pesanan yang telah dilakukan. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | Konsumen membuka halaman profil, lalu memilih menu "Pesanan Saya". | Sistem menampilkan daftar pesanan konsumen dengan filter tab (belum bayar, dikemas, dikirim, selesai, dibatalkan). |
| | Konsumen memilih tab status yang diinginkan. | Sistem menyaring dan menampilkan pesanan sesuai status yang dipilih. |
| | Konsumen mengklik salah satu pesanan. | Sistem menampilkan detail pesanan: daftar produk, total harga, status pembayaran, status pengiriman, dan nomor resi (jika sudah dikirim). |
| | Jika pesanan sudah diterima, konsumen dapat mengklik "Selesai". | Sistem memperbarui status pesanan menjadi "completed". |
| | | Sistem mengirim notifikasi "Pesanan Selesai" ke konsumen. |

---

### 11. Live Chat

| **Nama Use Case** | Live Chat |
|---|---|
| **Actor** | Konsumen (sudah login) |
| **Tujuan** | Untuk memungkinkan konsumen berkomunikasi langsung dengan admin toko melalui fitur chat. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | Konsumen mengklik tombol chat pada halaman produk atau navbar. | Sistem membuka widget chat (Livewire). |
| | Konsumen mengetik pesan dan mengklik kirim. | Sistem menyimpan pesan ke database. |
| | | Sistem menampilkan pesan konsumen di widget chat. |
| | | Admin menerima notifikasi chat baru. |
| | Admin membalas pesan konsumen. | Sistem menyimpan balasan admin dan menampilkannya di widget chat konsumen. |

---

### 12. Profil

| **Nama Use Case** | Profil |
|---|---|
| **Actor** | Konsumen (sudah login) |
| **Tujuan** | Untuk memungkinkan konsumen melihat dan memperbarui data profil serta mengelola alamat pengiriman. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | Konsumen membuka halaman profil. | Sistem menampilkan menu profil, alamat, kata sandi, wishlist, ulasan, dan voucher. |
| | Konsumen memilih menu "Profil Saya". | Sistem menampilkan form data diri (nama, email, no telepon). |
| | Konsumen memperbarui data dan mengklik "Simpan". | Sistem menyimpan perubahan data profil. |
| | Konsumen memilih menu "Alamat Saya". | Sistem menampilkan daftar alamat pengiriman. |
| | Konsumen menambah, mengedit, atau menghapus alamat. | Sistem memproses perubahan alamat (CRUD). |
| | Konsumen memilih menu "Ubah Kata Sandi". | Sistem menampilkan form ubah password. |
| | Konsumen memasukkan password lama dan baru, lalu mengklik "Simpan". | Sistem memvalidasi dan memperbarui password. |

---

### 13. Review Produk

| **Nama Use Case** | Review Produk |
|---|---|
| **Actor** | Konsumen (sudah login dan sudah membeli produk) |
| **Tujuan** | Untuk memungkinkan konsumen memberikan ulasan dan penilaian terhadap produk yang telah dibeli. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | Konsumen membuka halaman profil, lalu memilih menu "Ulasan Saya". | Sistem menampilkan daftar produk yang sudah dibeli dan dapat diulas. |
| | Konsumen memilih produk yang akan diulas. | Sistem menampilkan form ulasan (rating bintang 1-5 dan komentar). |
| | Konsumen memberikan rating dan menulis komentar. | |
| | Konsumen mengklik tombol "Kirim Ulasan". | Sistem menyimpan ulasan dengan status menunggu persetujuan (pending). |
| | | Setelah disetujui admin, ulasan ditampilkan di halaman detail produk. |

---

### 14. Logout

| **Nama Use Case** | Logout |
|---|---|
| **Actor** | Konsumen (sudah login) |
| **Tujuan** | Untuk mengakhiri sesi akun konsumen agar akun tetap aman. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | Konsumen mengklik tombol "Logout" pada menu navigasi. | Sistem menghapus sesi autentikasi pengguna. |
| | | Sistem mengarahkan konsumen ke halaman utama. |

---

## B. Aktivitas Admin

---

### 15. Login Admin

| **Nama Use Case** | Login Admin |
|---|---|
| **Actor** | Admin |
| **Tujuan** | Untuk memungkinkan admin mengakses panel administrasi toko. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | Admin membuka halaman `/admin`. | Sistem menampilkan formulir login admin. |
| | Admin memasukkan email dan password. | |
| | Admin mengklik tombol "Login". | Sistem memvalidasi kredensial admin. |
| | | Jika kredensial benar, sistem mengarahkan admin ke halaman dashboard. |
| | | Jika kredensial salah, sistem menampilkan pesan error. |

---

### 16. Kelola Kategori Produk

| **Nama Use Case** | Kelola Kategori Produk |
|---|---|
| **Actor** | Admin |
| **Tujuan** | Untuk memungkinkan admin mengelola data kategori produk (tambah, edit, hapus). |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | Admin membuka menu "Kategori" pada panel admin. | Sistem menampilkan daftar kategori produk (hierarki parent-child). |
| | Admin mengklik tombol "Tambah Kategori". | Sistem menampilkan form input kategori (nama, slug, parent kategori). |
| | Admin mengisi data kategori dan mengklik "Simpan". | Sistem menyimpan kategori baru ke database. |
| | Admin mengklik tombol edit pada kategori yang dipilih. | Sistem menampilkan form dengan data kategori yang sudah ada. |
| | Admin mengubah data dan mengklik "Simpan". | Sistem memperbarui data kategori. |
| | Admin mengklik tombol hapus pada kategori. | Sistem menghapus kategori beserta relasinya. |

---

### 17. Kelola Produk

| **Nama Use Case** | Kelola Produk |
|---|---|
| **Actor** | Admin |
| **Tujuan** | Untuk memungkinkan admin mengelola data produk (tambah, edit, hapus, atur stok dan harga). |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | Admin membuka menu "Produk" pada panel admin. | Sistem menampilkan daftar produk dengan paginasi dan pencarian. |
| | Admin mengklik tombol "Tambah Produk". | Sistem menampilkan form produk (nama, SKU, slug, harga, harga diskon, berat, stok, kategori, deskripsi, dan upload gambar). |
| | Admin mengisi data produk, mengunggah gambar, dan mengklik "Simpan". | Sistem menyimpan data produk dan gambar ke database (via Spatie Media Library). |
| | Admin mengklik tombol edit pada produk. | Sistem menampilkan form dengan data produk yang sudah ada. |
| | Admin memperbarui data (termasuk mengubah sale_price). | Sistem menyimpan perubahan. |
| | | Jika sale_price diturunkan, sistem menjalankan job notifikasi wishlist price drop. |
| | Admin mengklik tombol hapus produk. | Sistem menghapus produk beserta gambar dan relasinya. |

---

### 18. Kelola Voucher Belanja

| **Nama Use Case** | Kelola Voucher Belanja |
|---|---|
| **Actor** | Admin |
| **Tujuan** | Untuk memungkinkan admin mengelola kupon/voucher diskon (tambah, edit, hapus). |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | Admin membuka menu "Kupon" pada panel admin. | Sistem menampilkan daftar kupon yang tersedia. |
| | Admin mengklik tombol "Tambah Kupon". | Sistem menampilkan form kupon (kode, tipe diskon, nilai diskon, minimum belanja, masa berlaku, batas pemakaian). |
| | Admin mengisi data kupon dan mengklik "Simpan". | Sistem menyimpan data kupon ke database. |
| | Admin mengklik tombol edit pada kupon. | Sistem menampilkan form edit kupon. |
| | Admin mengubah data dan mengklik "Simpan". | Sistem memperbarui data kupon. |
| | Admin mengklik tombol hapus kupon. | Sistem menghapus data kupon. |

---

### 19. Kelola Pesanan

| **Nama Use Case** | Kelola Pesanan |
|---|---|
| **Actor** | Admin |
| **Tujuan** | Untuk memungkinkan admin memproses pesanan mulai dari konfirmasi, pengemasan, pengiriman, hingga pembatalan. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | Admin membuka menu "Pesanan" pada panel admin. | Sistem menampilkan daftar pesanan dengan filter status. |
| | Admin memilih salah satu pesanan. | Sistem menampilkan detail pesanan (produk, alamat, pembayaran). |
| | Admin mengklik "Konfirmasi" untuk mengonfirmasi pesanan. | Sistem memperbarui status pesanan menjadi "confirmed". |
| | Admin mengklik "Kemas" untuk memulai pengemasan. | Sistem memperbarui status menjadi "packaging". |
| | Admin mengklik "Kirim", lalu memasukkan nomor resi. | Sistem memperbarui status menjadi "delivered". |
| | | Sistem mengirim notifikasi database dan email tracking ke konsumen. |
| | Admin mengklik "Batalkan" jika pesanan dibatalkan. | Sistem memperbarui status menjadi "cancelled". |
| | | Sistem mengirim notifikasi database ke konsumen. |

---

### 20. Melihat Data Konsumen

| **Nama Use Case** | Melihat Data Konsumen |
|---|---|
| **Actor** | Admin |
| **Tujuan** | Untuk memungkinkan admin melihat data dan riwayat transaksi konsumen. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | Admin membuka menu "Konsumen" pada panel admin. | Sistem menampilkan daftar konsumen terdaftar. |
| | Admin mencari konsumen berdasarkan nama atau email. | Sistem memfilter hasil pencarian. |
| | Admin mengklik salah satu konsumen. | Sistem menampilkan detail konsumen: profil, daftar alamat, dan riwayat pesanan. |

---

### 21. Laporan Penjualan

| **Nama Use Case** | Laporan Penjualan |
|---|---|
| **Actor** | Admin |
| **Tujuan** | Untuk memungkinkan admin melihat laporan dan grafik penjualan toko. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | Admin membuka menu "Laporan" pada panel admin. | Sistem menampilkan grafik dan ringkasan penjualan (total pesanan, pendapatan, produk terlaris). |
| | Admin dapat memfilter berdasarkan rentang tanggal. | Sistem memperbarui tampilan laporan sesuai filter. |

---

### 22. Kelola Konten Homepage

| **Nama Use Case** | Kelola Konten Homepage |
|---|---|
| **Actor** | Admin |
| **Tujuan** | Untuk memungkinkan admin memperbarui konten halaman utama website (hero banner, promo, tentang kami, logo) tanpa mengubah kode. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | Admin membuka menu "Pengaturan" pada panel admin. | Sistem menampilkan form pengaturan yang dibagi menjadi 5 bagian: Identitas Website, Banner Utama, Bagian Promo, Bagian Tentang Kami, Galeri Estetik. |
| | Admin memilih bagian yang akan diedit. | Sistem menampilkan field teks atau upload gambar sesuai bagian. |
| | Admin mengisi/mengubah teks (judul, subjudul, deskripsi). | |
| | Admin mengunggah gambar baru ATAU memilih dari riwayat gambar sebelumnya. | |
| | Admin mengklik tombol "Simpan". | Untuk teks: sistem menyimpan nilai ke tabel settings dan menghapus cache. |
| | | Untuk gambar: sistem menyimpan file ke storage, mencatat path ke tabel settings dan riwayat ke setting_images, lalu menghapus cache. |
| | | Sistem menampilkan pesan sukses. |
| | Pengunjung membuka homepage. | Sistem membaca nilai settings (dari cache atau database) dan merender konten terbaru. |
