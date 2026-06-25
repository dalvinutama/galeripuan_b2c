# Pengujian Black Box - Equivalence Partitioning (EP)

## 5.3.1 Metode Equivalence Partitioning

*Equivalence Partitioning* (EP) atau partisi ekuivalen merupakan metode pengujian *black-box* yang membagi data *input* menjadi beberapa kelompok (partisi) yang dianggap memberikan perilaku yang sama terhadap sistem. Setiap partisi mewakili sekumpulan data yang secara logis akan diproses dengan cara yang identik oleh sistem, sehingga cukup dilakukan satu kali pengujian untuk setiap partisi guna memvalidasi seluruh kelompok data tersebut. Partisi dibagi menjadi dua kategori utama, yaitu *Valid* (data yang memenuhi aturan sistem) dan *Invalid* (data yang melanggar aturan sistem). Pengujian ini diterapkan pada seluruh fitur utama *platform* B2C Gallery Puan.id, baik dari sisi pelanggan (*consumer interface*) maupun administrator (*admin interface*).

---

## A. Consumer Interface

### 5.3.1.1 Pengujian Registrasi Pelanggan

Pengujian ini dilakukan untuk memastikan bahwa pelanggan baru dapat mendaftarkan akun ke dalam sistem, serta menguji respons sistem terhadap *input* yang tidak sesuai aturan.

| No | Skenario Uji | Kelas Data (EP) | Input | Output yang Diharapkan | Keterangan |
|----|-------------|-----------------|-------|----------------------|------------|
| 1 | Registrasi dengan data lengkap dan valid | Valid | Nama: "Ayu Putri"<br>Email: "ayu@gmail.com"<br>Password: "password123"<br>Konfirmasi: "password123" | Pelanggan berhasil mendaftar dan diarahkan ke halaman *home*. | Sesuai |
| 2 | Registrasi dengan nama tidak diisi | Invalid | Nama: (dikosongkan)<br>Email: "ayu@gmail.com"<br>Password: "password123"<br>Konfirmasi: "password123" | Sistem menolak dan menampilkan pesan validasi *"The name field is required."* | Sesuai |
| 3 | Registrasi dengan format email salah | Invalid | Nama: "Ayu Putri"<br>Email: "ayu" (tanpa @)<br>Password: "password123"<br>Konfirmasi: "password123" | Sistem menolak dan menampilkan pesan validasi *"The email must be a valid email address."* | Sesuai |
| 4 | Registrasi dengan email yang sudah terdaftar | Invalid | Nama: "Ayu Putri"<br>Email: "vinnss3108@gmail.com" (sudah ada)<br>Password: "password123"<br>Konfirmasi: "password123" | Sistem menolak dan menampilkan pesan validasi *"The email has already been taken."* | Sesuai |
| 5 | Registrasi dengan password kurang dari 8 karakter | Invalid | Nama: "Ayu Putri"<br>Email: "ayu@gmail.com"<br>Password: "pass12"<br>Konfirmasi: "pass12" | Sistem menolak dan menampilkan pesan validasi *"The password must be at least 8 characters."* | Sesuai |
| 6 | Registrasi dengan konfirmasi password tidak cocok | Invalid | Nama: "Ayu Putri"<br>Email: "ayu@gmail.com"<br>Password: "password123"<br>Konfirmasi: "password456" | Sistem menolak dan menampilkan pesan validasi *"The password confirmation does not match."* | Sesuai |

### 5.3.1.2 Pengujian *Login* Pelanggan

Pengujian ini dilakukan untuk memastikan bahwa pelanggan dapat masuk ke dalam sistem menggunakan akun yang telah didaftarkan, serta menguji respons sistem terhadap *input* yang tidak sesuai aturan.

| No | Skenario Uji | Kelas Data (EP) | Input | Output yang Diharapkan | Keterangan |
|----|-------------|-----------------|-------|----------------------|------------|
| 1 | *Login* dengan data yang benar | Valid | Email: "vinnss3108@gmail.com"<br>Password: "password" | Pelanggan berhasil masuk dan diarahkan ke halaman *home*. | Sesuai |
| 2 | *Login* dengan *password* yang salah | Invalid | Email: "vinnss3108@gmail.com"<br>Password: "salah123" | Sistem menolak akses dan menampilkan pesan *"These credentials do not match our records."* | Sesuai |
| 3 | *Login* dengan format *email* yang salah | Invalid | Email: "vinnss3108" (tanpa @)<br>Password: "password" | Sistem menolak dan menampilkan validasi *"The email must be a valid email address."* | Sesuai |
| 4 | *Login* dengan membiarkan form kosong | Invalid | Email: (dikosongkan)<br>Password: (dikosongkan) | Sistem menahan tombol masuk dan memunculkan validasi *"Harap isi bidang ini."* | Sesuai |

### 5.3.1.3 Pengujian Pencarian Produk

Pengujian ini dilakukan untuk memastikan bahwa pelanggan dapat mencari produk berdasarkan kata kunci, serta menguji respons sistem terhadap *input* yang tidak sesuai.

| No | Skenario Uji | Kelas Data (EP) | Input | Output yang Diharapkan | Keterangan |
|----|-------------|-----------------|-------|----------------------|------------|
| 1 | Mencari produk dengan kata kunci yang tersedia | Valid | Kata kunci: "Bella" | Sistem menampilkan produk yang mengandung kata "Bella" pada halaman hasil pencarian. | Sesuai |
| 2 | Mencari produk dengan kata kunci yang tidak tersedia | Invalid | Kata kunci: "sepatu" (produk tidak ada) | Sistem menampilkan halaman hasil pencarian kosong dengan pesan produk tidak ditemukan. | Sesuai |
| 3 | Mencari produk dengan *input* kosong | Invalid | Kata kunci: (dikosongkan) | Sistem menampilkan seluruh produk tanpa filter pencarian. | Sesuai |

### 5.3.1.4 Pengujian Detail Produk dan Pemilihan Varian Warna

Pengujian ini dilakukan untuk memastikan bahwa pelanggan dapat melihat detail produk dan memilih varian warna yang tersedia.

| No | Skenario Uji | Kelas Data (EP) | Input | Output yang Diharapkan | Keterangan |
|----|-------------|-----------------|-------|----------------------|------------|
| 1 | Membuka halaman detail produk dengan varian | Valid | Klik produk "CIput Arab Tali Belakang" | Sistem menampilkan detail produk beserta pilihan varian warna (Beige, Taupe, Abu-abu, dll). | Sesuai |
| 2 | Memilih varian warna yang tersedia | Valid | Klik warna "Beige" | Sistem menampilkan harga dan stok sesuai varian "Beige" yang dipilih. | Sesuai |

### 5.3.1.5 Pengujian Tambah ke Keranjang

Pengujian ini dilakukan untuk memastikan bahwa pelanggan dapat menambahkan produk ke keranjang belanja, serta menguji respons sistem terhadap kondisi yang tidak sesuai.

| No | Skenario Uji | Kelas Data (EP) | Input | Output yang Diharapkan | Keterangan |
|----|-------------|-----------------|-------|----------------------|------------|
| 1 | Menambahkan produk sederhana ke keranjang | Valid | Klik "Tambah" pada produk "Bella Sequare - Merah" (qty=1) | Sistem berhasil menambahkan produk ke keranjang dan menampilkan pesan *"Berhasil menambahkan item ke keranjang"*. | Sesuai |
| 2 | Menambahkan produk varian tanpa memilih warna | Invalid | Klik "Tambah" pada produk "CIput Arab" tanpa memilih varian | Sistem menolak dan menampilkan pesan *"Silakan pilih varian/warna terlebih dahulu"*. | Sesuai |
| 3 | Menambahkan produk dengan jumlah melebihi stok | Invalid | *Input* qty: 999 (melebihi stok) | Sistem menolak dan menampilkan pesan *"Stok produk tidak mencukupi"*. | Sesuai |
| 4 | Menambahkan produk yang sudah ada di keranjang | Valid | Klik "Tambah" pada produk yang sama (qty=1) | Sistem menambahkan jumlah produk yang sudah ada di keranjang. | Sesuai |

### 5.3.1.6 Pengujian Penerapan Kode Voucher

Pengujian ini dilakukan untuk memastikan bahwa sistem dapat menerapkan kode voucher dengan benar berdasarkan aturan bisnis yang telah ditentukan.

| No | Skenario Uji | Kelas Data (EP) | Input | Output yang Diharapkan | Keterangan |
|----|-------------|-----------------|-------|----------------------|------------|
| 1 | Menerapkan voucher dengan kode yang valid dan memenuhi syarat | Valid | Kode voucher: "PUAN10" (min_total terpenuhi, belum expired) | Sistem berhasil menerapkan diskon dan menampilkan pesan *"Voucher berhasil digunakan!"*. | Sesuai |
| 2 | Menerapkan voucher dengan kode yang tidak terdaftar | Invalid | Kode voucher: "SALAH123" | Sistem menolak dan menampilkan pesan *"Kode voucher tidak ditemukan atau sudah tidak aktif."* | Sesuai |
| 3 | Menerapkan voucher yang sudah kedaluwarsa | Invalid | Kode voucher: "EXPIRED1" (sudah melewati expired_at) | Sistem menolak dan menampilkan pesan *"Kode voucher ini sudah kedaluwarsa."* | Sesuai |
| 4 | Menerapkan voucher dengan total belanja kurang dari minimum | Invalid | Kode voucher: "PUAN50" (min_total Rp100.000, total belanja Rp70.000) | Sistem menolak dan menampilkan pesan *"Minimal belanja untuk voucher ini adalah Rp100.000."* | Sesuai |
| 5 | Menerapkan voucher khusus pelanggan baru oleh pelanggan lama | Invalid | Kode voucher: "NEWUSER" | Sistem menolak dan menampilkan pesan *"Maaf, Voucher ini khusus untuk pelanggan baru."* | Sesuai |
| 6 | Menerapkan voucher khusus pesanan ke-3 oleh pesanan ke-2 | Invalid | Kode voucher: "ORDER3" (min_order_count=3, ini pesanan ke-2) | Sistem menolak dan menampilkan pesan *"Voucher ini khusus untuk pesanan ke-3 kamu."* | Sesuai |
| 7 | Membatalkan penggunaan voucher | Valid | Klik tombol "Hapus Voucher" | Sistem menghapus voucher dan menampilkan pesan *"Voucher berhasil dibatalkan!"*. | Sesuai |

### 5.3.1.7 Pengujian *Checkout*

Pengujian ini dilakukan untuk memastikan bahwa pelanggan dapat menyelesaikan transaksi melalui halaman *checkout*.

| No | Skenario Uji | Kelas Data (EP) | Input | Output yang Diharapkan | Keterangan |
|----|-------------|-----------------|-------|----------------------|------------|
| 1 | *Checkout* dengan alamat dan kurir lengkap | Valid | Alamat terisi, pilih kurir "JNE", pilih paket "REG" | Sistem menampilkan ongkos kirim dan total pembayaran yang benar. | Sesuai |
| 2 | Menambahkan alamat baru saat *checkout* | Valid | Isi: nama "Ayu", provinsi, kota, alamat, kode pos | Sistem berhasil menyimpan alamat dengan pesan *"Alamat berhasil ditambahkan!"*. | Sesuai |
| 3 | Menambahkan alamat tanpa mengisi field wajib | Invalid | Field "first_name" dikosongkan | Sistem menolak dan menampilkan validasi *"The first name field is required."* | Sesuai |
| 4 | Menghapus alamat yang sudah tersimpan | Valid | Klik "Hapus" pada alamat | Sistem berhasil menghapus alamat dengan pesan *"Alamat berhasil dihapus."* | Sesuai |

### 5.3.1.8 Pengujian Pembayaran *Midtrans Snap*

Pengujian ini dilakukan untuk memastikan bahwa pelanggan dapat melakukan pembayaran melalui *Midtrans Snap* dan sistem memperbarui status pesanan sesuai hasil pembayaran.

| No | Skenario Uji | Kelas Data (EP) | Input | Output yang Diharapkan | Keterangan |
|----|-------------|-----------------|-------|----------------------|------------|
| 1 | Pembayaran berhasil dikonfirmasi | Valid | Pelanggan memilih metode pembayaran dan menyelesaikan pembayaran | Sistem menampilkan status *"Pembayaran Lunas"* dan pesanan berubah status menjadi *"Diproses"*. | Sesuai |
| 2 | Pembayaran gagal atau ditolak | Invalid | Pelanggan membatalkan pembayaran di halaman *Midtrans* | Sistem menampilkan status *"Pembayaran Gagal"* dan pesanan tetap pada status awal. | Sesuai |

### 5.3.1.9 Pengujian Pembatalan Pesanan

Pengujian ini dilakukan untuk memastikan bahwa pelanggan dapat membatalkan pesanan dalam batas waktu yang ditentukan.

| No | Skenario Uji | Kelas Data (EP) | Input | Output yang Diharapkan | Keterangan |
|----|-------------|-----------------|-------|----------------------|------------|
| 1 | Membatalkan pesanan dalam batas waktu 24 jam dan status belum dibayar | Valid | Klik tombol "Batalkan Pesanan" pada pesanan dengan status "Belum Dibayar" dan usia < 24 jam | Sistem berhasil membatalkan pesanan dan menampilkan pesan *"Pesanan berhasil dibatalkan."* | Sesuai |
| 2 | Membatalkan pesanan yang sudah dibayar | Invalid | Klik tombol "Batalkan Pesanan" pada pesanan dengan status sudah dibayar | Sistem menolak dan menampilkan pesan *"Maaf, pesanan yang sudah dibayar atau kedaluwarsa tidak dapat dibatalkan."* | Sesuai |

### 5.3.1.10 Pengujian Konfirmasi Pesanan Selesai

Pengujian ini dilakukan untuk memastikan bahwa pelanggan dapat mengonfirmasi pesanan yang telah diterima.

| No | Skenario Uji | Kelas Data (EP) | Input | Output yang Diharapkan | Keterangan |
|----|-------------|-----------------|-------|----------------------|------------|
| 1 | Mengonfirmasi pesanan yang sudah diterima | Valid | Klik tombol "Pesanan Diterima" pada pesanan dengan status "Sedang Dikirim" | Sistem mengubah status menjadi "Selesai" dan menampilkan pesan *"Terima kasih! Pesanan telah dikonfirmasi selesai."* | Sesuai |
| 2 | Mengonfirmasi pesanan yang belum dikirim | Invalid | Klik tombol "Pesanan Diterima" pada pesanan dengan status "Dikemas" | Sistem menolak dan menampilkan pesan *"Pesanan tidak valid untuk diselesaikan."* | Sesuai |

### 5.3.1.11 Pengujian *Wishlist*

Pengujian ini dilakukan untuk memastikan bahwa pelanggan dapat menambahkan dan menghapus produk dari daftar keinginan.

| No | Skenario Uji | Kelas Data (EP) | Input | Output yang Diharapkan | Keterangan |
|----|-------------|-----------------|-------|----------------------|------------|
| 1 | Menambahkan produk ke *wishlist* | Valid | Klik ikon hati pada produk "Bella Sequare" | Sistem menambahkan produk ke daftar keinginan dan ikon berubah menjadi terisi. | Sesuai |
| 2 | Menambahkan produk yang sudah ada di *wishlist* | Invalid | Klik ikon hati pada produk yang sama | Sistem menghapus produk dari daftar keinginan (*toggle*). | Sesuai |

### 5.3.1.12 Pengujian Ulasan Produk

Pengujian ini dilakukan untuk memastikan bahwa pelanggan dapat memberikan ulasan dan rating terhadap produk yang telah dibeli.

| No | Skenario Uji | Kelas Data (EP) | Input | Output yang Diharapkan | Keterangan |
|----|-------------|-----------------|-------|----------------------|------------|
| 1 | Memberikan ulasan dengan rating valid | Valid | Rating: 5<br>Komentar: "Produk bagus!" | Sistem berhasil menyimpan ulasan dan menampilkan pesan *"Terima kasih! Ulasan Anda berhasil dikirim."* | Sesuai |
| 2 | Memberikan ulasan dengan rating di bawah 1 | Invalid | Rating: 0 | Sistem menolak dan menampilkan validasi *"The rating must be at least 1."* | Sesuai |
| 3 | Memberikan ulasan dengan rating di atas 5 | Invalid | Rating: 6 | Sistem menolak dan menampilkan validasi *"The rating must not be greater than 5."* | Sesuai |

### 5.3.1.13 Pengujian Ubah *Password* Pelanggan

Pengujian ini dilakukan untuk memastikan bahwa pelanggan dapat mengubah kata sandi akunnya.

| No | Skenario Uji | Kelas Data (EP) | Input | Output yang Diharapkan | Keterangan |
|----|-------------|-----------------|-------|----------------------|------------|
| 1 | Mengubah *password* dengan data benar | Valid | Current Password: "password"<br>Password Baru: "passwordbaru123"<br>Konfirmasi: "passwordbaru123" | Sistem berhasil mengubah *password* dan menampilkan pesan *"Password Anda berhasil diubah!"* | Sesuai |
| 2 | Mengubah *password* dengan *current password* salah | Invalid | Current Password: "salah123"<br>Password Baru: "passwordbaru123"<br>Konfirmasi: "passwordbaru123" | Sistem menolak dan menampilkan pesan *"Password saat ini tidak sesuai."* | Sesuai |
| 3 | Mengubah *password* dengan *password* baru kurang dari 8 karakter | Invalid | Current Password: "password"<br>Password Baru: "pass12"<br>Konfirmasi: "pass12" | Sistem menolak dan menampilkan validasi *"The password must be at least 8 characters."* | Sesuai |
| 4 | Mengubah *password* dengan konfirmasi tidak cocok | Invalid | Current Password: "password"<br>Password Baru: "passwordbaru123"<br>Konfirmasi: "passwordlain456" | Sistem menolak dan menampilkan validasi *"The password confirmation does not match."* | Sesuai |

### 5.3.1.14 Pengujian *Chat Widget*

Pengujian ini dilakukan untuk memastikan bahwa pelanggan dapat mengirim pesan *chat* kepada admin melalui *widget chat*.

| No | Skenario Uji | Kelas Data (EP) | Input | Output yang Diharapkan | Keterangan |
|----|-------------|-----------------|-------|----------------------|------------|
| 1 | Mengirim pesan teks *chat* | Valid | Mengetik "Halo admin, saya mau tanya produk" | Pesan berhasil terkirim dan muncul di jendela *chat*. | Sesuai |
| 2 | Mengirim pesan kosong | Invalid | Tidak mengetik apapun, klik tombol kirim | Sistem tidak mengirimkan pesan kosong (tombol kirim tidak aktif). | Sesuai |

---

## B. Admin Interface

### 5.3.1.15 Pengujian *Login* Admin

Pengujian ini dilakukan untuk memastikan bahwa administrator dapat masuk ke sistem menggunakan akun yang telah didaftarkan pada tabel `admins`.

| No | Skenario Uji | Kelas Data (EP) | Input | Output yang Diharapkan | Keterangan |
|----|-------------|-----------------|-------|----------------------|------------|
| 1 | *Login* admin dengan data yang benar | Valid | Email: "admin@gallerypuan.id"<br>Password: "password" | Admin berhasil masuk dan diarahkan ke halaman *Dashboard*. | Sesuai |
| 2 | *Login* admin dengan *password* salah | Invalid | Email: "admin@gallerypuan.id"<br>Password: "salah123" | Sistem menolak akses dan menampilkan pesan *"Email atau Password salah!"* | Sesuai |
| 3 | *Login* admin dengan *email* tidak terdaftar | Invalid | Email: "tidakada@gmail.com"<br>Password: "password" | Sistem menolak akses dan menampilkan pesan *"Email atau Password salah!"* | Sesuai |

### 5.3.1.16 Pengujian Kelola Produk (Tambah)

Pengujian ini dilakukan untuk memastikan bahwa administrator dapat menambahkan produk baru ke dalam sistem.

| No | Skenario Uji | Kelas Data (EP) | Input | Output yang Diharapkan | Keterangan |
|----|-------------|-----------------|-------|----------------------|------------|
| 1 | Menambahkan produk dengan data lengkap dan valid | Valid | SKU: "HIJAB-006"<br>Nama: "Square Motif Baru"<br>Tipe: "SIMPLE" | Sistem berhasil membuat produk dan mengarahkan ke halaman edit produk. | Sesuai |
| 2 | Menambahkan produk dengan SKU yang sudah ada | Invalid | SKU: "HIJAB-001" (sudah digunakan) | Sistem menolak dan menampilkan validasi *"The sku has already been taken."* | Sesuai |
| 3 | Menambahkan produk dengan nama kosong | Invalid | Nama: (dikosongkan) | Sistem menolak dan menampilkan validasi *"The name field is required."* | Sesuai |
| 4 | Menambahkan produk tanpa memilih tipe | Invalid | Tipe: (tidak dipilih) | Sistem menolak dan menampilkan validasi *"The type field is required."* | Sesuai |

### 5.3.1.17 Pengujian Kelola Produk (Update Harga)

Pengujian ini dilakukan untuk memastikan bahwa administrator dapat memperbarui harga produk dengan benar.

| No | Skenario Uji | Kelas Data (EP) | Input | Output yang Diharapkan | Keterangan |
|----|-------------|-----------------|-------|----------------------|------------|
| 1 | Mengubah harga dengan nilai positif | Valid | Harga: 75000 | Sistem berhasil menyimpan harga baru dan menampilkan pesan *"Product updated!"* | Sesuai |
| 2 | Mengubah harga dengan nilai 0 | Invalid | Harga: 0 | Sistem menolak dan menampilkan validasi (harga tidak boleh 0). | Sesuai |
| 3 | Mengubah harga dengan nilai negatif | Invalid | Harga: -5000 | Sistem menolak dan menampilkan validasi. | Sesuai |

### 5.3.1.18 Pengujian Kelola Varian Warna

Pengujian ini dilakukan untuk memastikan bahwa administrator dapat menambahkan varian warna pada produk bertipe *CONFIGURABLE*.

| No | Skenario Uji | Kelas Data (EP) | Input | Output yang Diharapkan | Keterangan |
|----|-------------|-----------------|-------|----------------------|------------|
| 1 | Menambahkan varian warna baru dengan data lengkap | Valid | Warna: "Navy"<br>SKU: "HIJAB-006-001"<br>Harga: 75000<br>Stok: 10 | Sistem berhasil menambahkan varian baru ke dalam tabel varian. | Sesuai |
| 2 | Menambahkan varian tanpa mengisi warna | Invalid | Warna: (dikosongkan) | Sistem menolak dan menampilkan validasi *"The variants.0.color field is required."* | Sesuai |

### 5.3.1.19 Pengujian Kelola Kategori (Tambah)

Pengujian ini dilakukan untuk memastikan bahwa administrator dapat menambahkan kategori produk baru.

| No | Skenario Uji | Kelas Data (EP) | Input | Output yang Diharapkan | Keterangan |
|----|-------------|-----------------|-------|----------------------|------------|
| 1 | Menambahkan kategori dengan nama yang belum ada | Valid | Nama: "Hijab Pesta" | Sistem berhasil menyimpan kategori dan menampilkan pesan *"Category created!"* | Sesuai |
| 2 | Menambahkan kategori dengan nama yang sudah ada | Invalid | Nama: "Hijab Pesta" (sudah ada) | Sistem menolak dan menampilkan validasi *"The name has already been taken."* | Sesuai |
| 3 | Menambahkan kategori dengan nama kosong | Invalid | Nama: (dikosongkan) | Sistem menolak dan menampilkan validasi *"The name field is required."* | Sesuai |

### 5.3.1.20 Pengujian Kelola Orderan (Update Status)

Pengujian ini dilakukan untuk memastikan bahwa administrator dapat memperbarui status pesanan sesuai alur yang telah ditentukan.

| No | Skenario Uji | Kelas Data (EP) | Input | Output yang Diharapkan | Keterangan |
|----|-------------|-----------------|-------|----------------------|------------|
| 1 | Mengonfirmasi pesanan baru (PENDING → CONFIRMED) | Valid | Klik "Konfirmasi" pada pesanan dengan status PENDING | Sistem mengubah status menjadi CONFIRMED. | Sesuai |
| 2 | Mengubah status pesanan ke pengemasan (CONFIRMED → PACKAGING) | Valid | Klik "Pengemasan" pada pesanan dengan status CONFIRMED | Sistem mengubah status menjadi PACKAGING. | Sesuai |
| 3 | Mengubah status pesanan ke pengiriman (PACKAGING → DELIVERED) | Valid | Klik "Pengiriman" pada pesanan dengan status PACKAGING | Sistem mengubah status menjadi DELIVERED. | Sesuai |
| 4 | Mengupdate status pesanan yang sudah selesai (RECEIVED) | Invalid | Klik tombol aksi pada pesanan dengan status RECEIVED | Sistem tidak menampilkan tombol aksi karena status sudah final. | Sesuai |
| 5 | Membatalkan pesanan (PENDING → CANCELLED) | Valid | Klik "Pembatalan" pada pesanan dengan status PENDING | Sistem mengubah status menjadi CANCELLED. | Sesuai |

### 5.3.1.21 Pengujian Kelola Voucher (Tambah)

Pengujian ini dilakukan untuk memastikan bahwa administrator dapat menambahkan voucher promo baru.

| No | Skenario Uji | Kelas Data (EP) | Input | Output yang Diharapkan | Keterangan |
|----|-------------|-----------------|-------|----------------------|------------|
| 1 | Menambahkan voucher dengan data lengkap dan valid | Valid | Kode: "BARU10"<br>Tipe: "percent"<br>Nilai: 10<br>Min Total: 50000<br>Expired: 2026-12-31 | Sistem berhasil menyimpan voucher dan menampilkan pesan *"Voucher berhasil ditambahkan!"* | Sesuai |
| 2 | Menambahkan voucher dengan kode yang sudah ada | Invalid | Kode: "BARU10" (sudah digunakan) | Sistem menolak dan menampilkan pesan *"Kode voucher ini sudah digunakan!"* | Sesuai |
| 3 | Menambahkan voucher dengan kode kurang dari 3 karakter | Invalid | Kode: "AB" | Sistem menolak dan menampilkan validasi *"The code must be at least 3 characters."* | Sesuai |
| 4 | Menambahkan voucher dengan nilai diskon 0 | Invalid | Nilai: 0 | Sistem menolak dan menampilkan validasi *"The value must be at least 1."* | Sesuai |

### 5.3.1.22 Pengujian Laporan Penjualan

Pengujian ini dilakukan untuk memastikan bahwa administrator dapat melihat dan mengekspor laporan penjualan.

| No | Skenario Uji | Kelas Data (EP) | Input | Output yang Diharapkan | Keterangan |
|----|-------------|-----------------|-------|----------------------|------------|
| 1 | Menampilkan laporan dengan rentang tanggal valid | Valid | Tanggal: 01-06-2026 s/d 03-06-2026 | Sistem menampilkan data pesanan, total pendapatan, dan metrik dalam rentang tersebut. | Sesuai |
| 2 | Mengekspor laporan ke PDF | Valid | Klik "Export PDF" | Sistem mengunduh file PDF berjudul "Laporan_Penjualan_2026-06-01_sampai_2026-06-03.pdf". | Sesuai |

### 5.3.1.23 Pengujian Promo Blast Email

Pengujian ini dilakukan untuk memastikan bahwa administrator dapat mengirimkan promosi melalui *email* kepada pelanggan.

| No | Skenario Uji | Kelas Data (EP) | Input | Output yang Diharapkan | Keterangan |
|----|-------------|-----------------|-------|----------------------|------------|
| 1 | Mengirim promo dengan subjek dan pesan terisi | Valid | Subjek: "Diskon Spesial Akhir Tahun!"<br>Pesan: "Dapatkan diskon 10%" | Sistem mengirimkan *email* ke pelanggan dan menampilkan pesan sukses. | Sesuai |
| 2 | Mengirim promo dengan subjek kosong | Invalid | Subjek: (dikosongkan) | Sistem menolak dan menampilkan validasi *"The subject field is required."* | Sesuai |
| 3 | Mengirim promo dengan subjek melebihi 255 karakter | Invalid | Subjek: (255+ karakter) | Sistem menolak dan menampilkan validasi *"The subject must not be greater than 255 characters."* | Sesuai |

### 5.3.1.24 Pengujian Unggah Gambar Produk

Pengujian ini dilakukan untuk memastikan bahwa administrator dapat mengunggah gambar produk dengan format dan ukuran yang sesuai.

| No | Skenario Uji | Kelas Data (EP) | Input | Output yang Diharapkan | Keterangan |
|----|-------------|-----------------|-------|----------------------|------------|
| 1 | Mengunggah gambar dengan format .jpg ukuran sesuai | Valid | File: "produk.jpg" (ukuran < 4MB) | Sistem berhasil mengunggah gambar dan menampilkan pesan *"YEAY! Foto berhasil diunggah secara otomatis!"* | Sesuai |
| 2 | Mengunggah gambar dengan format tidak didukung | Invalid | File: "produk.gif" | Sistem menolak dan menampilkan validasi *"The image must be a file of type: jpeg, png, jpg."* | Sesuai |
| 3 | Mengunggah gambar melebihi ukuran maksimal | Invalid | File: "produk.jpg" (ukuran > 4MB) | Sistem menolak dan menampilkan validasi *"The image must not be greater than 4096 kilobytes."* | Sesuai |

### 5.3.1.25 Pengujian *Chat* Admin

Pengujian ini dilakukan untuk memastikan bahwa administrator dapat membalas pesan *chat* dari pelanggan.

| No | Skenario Uji | Kelas Data (EP) | Input | Output yang Diharapkan | Keterangan |
|----|-------------|-----------------|-------|----------------------|------------|
| 1 | Membalas pesan *chat* dengan teks | Valid | Isi pesan: "Baik, akan kami proses" | Sistem berhasil mengirim balasan dan muncul di jendela *chat*. | Sesuai |
| 2 | Membalas pesan tanpa mengisi teks dan tanpa gambar | Invalid | Pesan: (dikosongkan)<br>Gambar: tidak dipilih | Sistem menahan tombol kirim karena *replyBody* wajib diisi jika tanpa gambar. | Sesuai |
| 3 | Mengunggah gambar *chat* melebihi 5MB | Invalid | File: "foto.jpg" (ukuran > 5MB) | Sistem menolak dan menampilkan validasi *"The image must not be greater than 5120 kilobytes."* | Sesuai |

### 5.3.1.26 Pengujian Profil Admin (Ubah *Password*)

Pengujian ini dilakukan untuk memastikan bahwa administrator dapat mengubah kata sandi akunnya melalui halaman profil.

| No | Skenario Uji | Kelas Data (EP) | Input | Output yang Diharapkan | Keterangan |
|----|-------------|-----------------|-------|----------------------|------------|
| 1 | Mengubah *password* admin dengan data benar | Valid | Current Password: "password"<br>New Password: "adminbaru123"<br>Konfirmasi: "adminbaru123" | Sistem berhasil mengubah *password* dan menampilkan pesan *"Profil berhasil diperbarui!"* | Sesuai |
| 2 | Mengubah *password* admin dengan *current password* salah | Invalid | Current Password: "salah123"<br>New Password: "adminbaru123"<br>Konfirmasi: "adminbaru123" | Sistem menolak dan menampilkan pesan *"Kata sandi saat ini tidak cocok."* | Sesuai |
| 3 | Mengubah *password* admin dengan *password* baru kurang dari 8 karakter | Invalid | Current Password: "password"<br>New Password: "adm12"<br>Konfirmasi: "adm12" | Sistem menolak dan menampilkan validasi *"The new password must be at least 8 characters."* | Sesuai |
