# Deskripsi Use Case Diagram — Gallery Puan

---

## A. Aktivitas Pengunjung & Konsumen (Pelanggan)

---

### Use Case 1: Pencarian Produk

| **Nama Use Case** | Pencarian Produk |
|---|---|
| **Actor** | Pengunjung / Konsumen |
| **Tujuan** | Use case ini bertujuan untuk memungkinkan pengguna menemukan produk yang diinginkan melalui mekanisme pencarian berdasarkan kata kunci, filter kategori, rentang harga, serta pengurutan hasil. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | 1. Pengguna membuka halaman katalog produk. | 1. Sistem menampilkan daftar produk dengan paginasi. |
| | 2. Pengguna memasukkan kata kunci pada kolom pencarian. | 2. Sistem memfilter produk berdasarkan kata kunci. |
| | 3. Pengguna memilih kategori dari sidebar filter. | 3. Sistem menyaring produk sesuai kategori yang dipilih. |
| | 4. Pengguna mengatur rentang harga minimum dan maksimum. | 4. Sistem memfilter produk berdasarkan rentang harga. |
| | 5. Pengguna memilih opsi pengurutan (termurah, termahal, terbaru). | 5. Sistem mengurutkan hasil sesuai opsi pengurutan. |
| | | 6. Sistem menampilkan hasil pencarian yang sesuai dengan seluruh kriteria yang ditentukan. |

Tabel 1 menjelaskan deskripsi Use Case Diagram Pencarian Produk, yang menggambarkan proses pengguna dalam mencari dan menemukan produk yang diinginkan pada sistem Gallery Puan. Proses diawali ketika pengguna membuka halaman katalog produk dan sistem menampilkan daftar produk secara lengkap dengan paginasi. Pengguna kemudian dapat mempersempit hasil pencarian dengan memasukkan kata kunci pada kolom pencarian, memilih kategori produk dari sidebar filter, menentukan rentang harga minimum dan maksimum, serta memilih opsi pengurutan seperti harga termurah, termahal, atau produk terbaru.

Setiap interaksi yang dilakukan pengguna akan diproses oleh sistem secara real-time. Sistem akan menyaring, memfilter, dan mengurutkan produk berdasarkan seluruh kriteria yang telah ditentukan pengguna hingga akhirnya menampilkan hasil pencarian yang sesuai. Fitur ini memungkinkan pengguna untuk menavigasi ribuan produk dengan efisien dan menemukan produk yang sesuai dengan kebutuhan mereka tanpa harus menelusuri satu per satu.

---

### Use Case 2: Detail Produk

| **Nama Use Case** | Detail Produk |
|---|---|
| **Actor** | Pengunjung / Konsumen |
| **Tujuan** | Use case ini bertujuan untuk menampilkan informasi lengkap suatu produk, meliputi gambar, harga, stok, deskripsi, serta ulasan dari konsumen lain guna membantu pengambilan keputusan pembelian. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | 1. Pengguna mengklik salah satu produk pada halaman katalog. | 1. Sistem mencari data produk berdasarkan kombinasi slug dan SKU pada URL. |
| | | 2. Sistem menambahkan jumlah views_count produk. |
| | | 3. Sistem menampilkan halaman detail produk berisi galeri gambar, nama, SKU, harga, diskon (jika ada), status stok, dan deskripsi. |
| | | 4. Sistem menampilkan rating rata-rata dan daftar ulasan dari konsumen lain. |
| | | 5. Jika pengguna dalam keadaan login, sistem mengecek status wishlist produk tersebut. |

Tabel 2 menjelaskan deskripsi Use Case Diagram Detail Produk, yang menggambarkan proses pengguna melihat informasi lengkap suatu produk sebelum memutuskan untuk membeli. Proses dimulai ketika pengguna mengklik produk yang diminati dari halaman katalog atau hasil pencarian. Sistem kemudian akan mencari data produk yang sesuai berdasarkan kombinasi slug dan SKU yang terdapat pada URL, sekaligus menambahkan jumlah views_count untuk mencatat popularitas produk.

Setelah data produk ditemukan, sistem akan menampilkan halaman detail produk yang lengkap. Halaman ini mencakup galeri gambar produk dalam bentuk carousel, nama produk, SKU, harga, label diskon beserta persentasenya jika produk sedang dalam masa promosi, status ketersediaan stok, dan deskripsi produk. Sistem juga menampilkan rating rata-rata beserta ulasan-ulasan dari konsumen lain yang telah membeli produk tersebut. Apabila pengguna telah login, sistem akan memeriksa status wishlist untuk menampilkan ikon wishlist yang sesuai.

---

### Use Case 3: Registrasi Konsumen

| **Nama Use Case** | Registrasi Konsumen |
|---|---|
| **Actor** | Pengunjung |
| **Tujuan** | Use case ini bertujuan untuk memungkinkan pengunjung membuat akun sebagai konsumen terdaftar agar dapat mengakses fitur-fitur yang memerlukan autentikasi seperti transaksi, wishlist, dan review produk. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | 1. Pengunjung mengakses halaman registrasi. | 1. Sistem menampilkan formulir pendaftaran akun baru. |
| | 2. Pengunjung mengisi data diri meliputi nama lengkap, alamat email, nomor telepon, kata sandi, dan konfirmasi kata sandi. | 2. Sistem memvalidasi data yang diisi, meliputi format email, kekuatan kata sandi, dan kesesuaian konfirmasi kata sandi. |
| | | 3. Sistem memeriksa ketersediaan alamat email untuk mencegah duplikasi akun. |
| | 3. Pengunjung mengklik tombol "Daftar". | 4. Sistem menyimpan data pengguna ke dalam basis data dan membuat akun baru dengan UUID sebagai primary key. |
| | | 5. Sistem menampilkan notifikasi bahwa registrasi berhasil dilakukan. |
| | | 6. Sistem mengirimkan email sambutan (WelcomeCustomerMail) secara otomatis ke alamat email pengguna yang berisi kode promo untuk pembelian pertama. |
| | 4. Pengunjung dapat login menggunakan akun yang baru dibuat. | |

Tabel 3 menjelaskan deskripsi Use Case Diagram Registrasi Konsumen, yang menggambarkan proses pendaftaran akun baru pada sistem Gallery Puan. Proses diawali ketika pengunjung yang belum memiliki akun mengakses halaman registrasi. Sistem akan menampilkan formulir pendaftaran yang berisi field-field yang wajib diisi, seperti nama lengkap, alamat email, nomor telepon, kata sandi, dan konfirmasi kata sandi. Pengunjung kemudian mengisi seluruh data yang diminta dan menekan tombol "Daftar" untuk mengirimkan data pendaftaran.

Setelah tombol "Daftar" diklik, sistem akan melakukan serangkaian validasi terhadap data yang dimasukkan. Validasi mencakup pemeriksaan format email, kekuatan kata sandi, kesesuaian antara kata sandi dan konfirmasi kata sandi, serta ketersediaan alamat email untuk mencegah duplikasi akun. Apabila seluruh validasi berhasil dilalui, sistem akan menyimpan data pengguna ke dalam basis data dengan UUID sebagai primary key dan menampilkan notifikasi keberhasilan registrasi. Sebagai langkah lanjutan, sistem secara otomatis mengirimkan email sambutan (WelcomeCustomerMail) ke alamat email pengguna yang berisi kode promo khusus untuk pembelian pertama, sehingga pengguna baru dapat langsung merasakan manfaat menjadi anggota terdaftar.

---

### Use Case 4: Login

| **Nama Use Case** | Login |
|---|---|
| **Actor** | Konsumen |
| **Tujuan** | Use case ini bertujuan untuk memverifikasi identitas konsumen yang telah terdaftar agar dapat mengakses fitur-fitur yang memerlukan autentikasi dalam sistem. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | 1. Konsumen mengakses halaman login. | 1. Sistem menampilkan formulir login yang terdiri dari field email dan kata sandi. |
| | 2. Konsumen memasukkan alamat email dan kata sandi yang telah terdaftar. | |
| | 3. Konsumen mengklik tombol "Login". | 2. Sistem memvalidasi kredensial yang dimasukkan dengan data yang tersimpan di basis data. |
| | | 3. Jika kredensial benar dan valid, sistem membuat sesi autentikasi dan mengarahkan konsumen ke halaman utama. |
| | | 4. Jika kredensial salah, sistem menampilkan pesan kesalahan "Email atau kata sandi tidak sesuai". |

Tabel 4 menjelaskan deskripsi Use Case Diagram Login, yang menggambarkan proses autentikasi konsumen yang telah memiliki akun pada sistem Gallery Puan. Proses dimulai ketika konsumen yang sudah terdaftar mengakses halaman login. Sistem akan menampilkan formulir login yang terdiri dari dua field utama, yaitu alamat email dan kata sandi. Konsumen kemudian memasukkan kredensial akun yang dimiliki dan menekan tombol "Login" untuk memulai proses verifikasi.

Sistem akan melakukan validasi terhadap kredensial yang dimasukkan dengan mencocokkan data tersebut dengan informasi yang tersimpan di basis data. Apabila alamat email dan kata sandi yang dimasukkan sesuai dengan data yang tersimpan, sistem akan membuat sesi autentikasi dan mengarahkan konsumen ke halaman utama website. Namun, apabila kredensial yang dimasukkan tidak sesuai, sistem akan menolak akses dan menampilkan pesan kesalahan "Email atau kata sandi tidak sesuai" sehingga konsumen dapat mengulangi proses login.

---

### Use Case 5: Menambahkan Wishlist

| **Nama Use Case** | Menambahkan Wishlist |
|---|---|
| **Actor** | Konsumen (sudah login) |
| **Tujuan** | Use case ini bertujuan untuk memungkinkan konsumen menyimpan produk-produk favorit ke dalam daftar wishlist agar dapat dengan mudah diakses kembali di kemudian hari. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | 1. Konsumen membuka halaman detail produk yang diinginkan. | 1. Sistem menampilkan tombol wishlist berbentuk ikon hati pada halaman detail produk. |
| | 2. Konsumen mengklik tombol wishlist (ikon hati). | 2. Sistem memeriksa apakah produk sudah tercatat dalam daftar wishlist konsumen. |
| | | 3. Jika produk belum ada, sistem menambahkan produk ke daftar wishlist. Jika sudah ada, sistem menghapus produk dari wishlist. |
| | | 4. Sistem memperbarui tampilan ikon wishlist sesuai status terbaru (solid jika ada, outline jika tidak). |

Tabel 5 menjelaskan deskripsi Use Case Diagram Menambahkan Wishlist, yang menggambarkan proses konsumen dalam menyimpan produk favorit ke dalam daftar wishlist pada sistem Gallery Puan. Proses diawali ketika konsumen yang telah login membuka halaman detail suatu produk. Sistem akan menampilkan tombol wishlist yang berbentuk ikon hati sebagai representasi status wishlist produk tersebut.

Ketika konsumen mengklik tombol wishlist, sistem akan memeriksa apakah produk tersebut sudah tercatat dalam daftar wishlist konsumen. Apabila produk belum tercatat, sistem akan menambahkan produk ke dalam daftar wishlist dan mengubah tampilan ikon menjadi terisi (solid) sebagai indikator bahwa produk telah disimpan. Sebaliknya, apabila produk sudah tercatat dalam wishlist, sistem akan menghapus produk tersebut dari daftar wishlist dan mengembalikan tampilan ikon menjadi kosong (outline). Mekanisme toggle ini memudahkan konsumen dalam mengelola daftar produk favorit mereka tanpa perlu membuka halaman terpisah.

---

### Use Case 6: Menambahkan Produk ke Keranjang Belanja

| **Nama Use Case** | Menambahkan Produk ke Keranjang Belanja |
|---|---|
| **Actor** | Konsumen (sudah login) |
| **Tujuan** | Use case ini bertujuan untuk memungkinkan konsumen menambahkan produk yang ingin dibeli beserta jumlahnya ke dalam keranjang belanja sebagai langkah awal sebelum melakukan checkout. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | 1. Konsumen membuka halaman detail produk. | 1. Sistem menampilkan informasi produk beserta field input jumlah (qty) dan tombol "Tambah ke Keranjang". |
| | 2. Konsumen menentukan jumlah produk pada field qty. | |
| | 3. Konsumen mengklik tombol "Tambah ke Keranjang". | 2. Sistem memvalidasi ketersediaan stok produk sesuai jumlah yang diminta. |
| | | 3. Jika stok tersedia, sistem menyimpan item ke dalam tabel keranjang belanja konsumen beserta jumlah dan berat total. |
| | | 4. Sistem menampilkan notifikasi bahwa produk berhasil ditambahkan ke keranjang. |
| | | 5. Sistem memperbarui jumlah item yang tertera pada ikon keranjang di navbar. |
| | 4. Konsumen dapat melanjutkan belanja atau langsung menuju halaman keranjang. | |

Tabel 6 menjelaskan deskripsi Use Case Diagram Menambahkan Produk ke Keranjang Belanja, yang menggambarkan proses konsumen dalam memasukkan produk ke dalam keranjang belanja pada sistem Gallery Puan. Proses diawali ketika konsumen yang telah login membuka halaman detail produk. Sistem menampilkan informasi lengkap produk beserta field input jumlah (qty) dan tombol "Tambah ke Keranjang". Konsumen kemudian menentukan jumlah produk yang ingin dibeli dan menekan tombol "Tambah ke Keranjang" untuk memproses permintaan.

Setelah tombol diklik, sistem akan melakukan validasi terhadap ketersediaan stok produk sesuai dengan jumlah yang diminta oleh konsumen. Apabila stok tersedia dan mencukupi, sistem akan menyimpan item tersebut ke dalam tabel keranjang belanja konsumen beserta informasi jumlah dan berat total produk. Sistem kemudian menampilkan notifikasi bahwa produk berhasil ditambahkan ke keranjang dan memperbarui jumlah item yang tertera pada ikon keranjang di navbar website. Konsumen kemudian dapat melanjutkan belanja atau langsung menuju ke halaman keranjang untuk melanjutkan ke proses checkout.

---

### Use Case 7: Melakukan Transaksi (Checkout)

| **Nama Use Case** | Melakukan Transaksi |
|---|---|
| **Actor** | Konsumen (sudah login) |
| **Tujuan** | Use case ini bertujuan untuk memungkinkan konsumen menyelesaikan pembelian dengan memilih alamat pengiriman, jasa kurir, menerapkan voucher diskon, dan melakukan pembayaran melalui gateway Midtrans. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | 1. Konsumen membuka halaman keranjang belanja. | 1. Sistem menampilkan daftar produk yang ada di keranjang beserta jumlah, berat, dan subtotal. |
| | 2. Konsumen memilih item yang akan dibeli dan mengklik tombol "Checkout". | 2. Sistem mengarahkan konsumen ke halaman checkout. |
| | 3. Konsumen memilih alamat pengiriman yang sudah tersimpan atau menambah alamat baru. | 3. Sistem menampilkan daftar alamat konsumen dengan opsi provinsi dan kota yang terintegrasi dengan API RajaOngkir. |
| | 4. Konsumen memilih kurir pengiriman (JNE, TIKI, Pos Indonesia). | 4. Sistem memanggil API RajaOngkir untuk menghitung ongkos kirim berdasarkan berat total produk dan alamat tujuan. |
| | | 5. Sistem menampilkan daftar layanan pengiriman beserta biaya dan estimasi waktu. |
| | 5. Konsumen memilih layanan pengiriman yang diinginkan. | 6. Sistem menyimpan pilihan layanan pengiriman. |
| | 6. Konsumen memasukkan kode voucher diskon (opsional). | 7. Sistem memvalidasi kode voucher (masa berlaku, minimum belanja, kuota pemakaian). |
| | | 8. Jika valid, sistem menghitung diskon dan memperbarui total pembayaran. Jika tidak valid, sistem menampilkan pesan kesalahan. |
| | 7. Konsumen meninjau ringkasan pesanan (produk, alamat, ongkos kirim, total). | |
| | 8. Konsumen mengklik tombol "Bayar". | 9. Sistem membuat data pesanan baru dengan kode unik dan status "created". |
| | | 10. Sistem membuat data pembayaran dan memanggil Midtrans Snap API untuk mendapatkan token pembayaran. |
| | | 11. Sistem mengarahkan konsumen ke halaman pembayaran Midtrans (Snap). |
| | 9. Konsumen menyelesaikan pembayaran melalui antarmuka Midtrans. | |
| | | 12. Sistem menerima callback dari Midtrans mengenai status pembayaran. |
| | | 13. Jika pembayaran sukses (capture/settlement), sistem memperbarui status pesanan menjadi "processing" dan payment_status menjadi "paid". |
| | | 14. Jika pembayaran gagal atau kedaluwarsa, sistem memperbarui status pesanan menjadi "cancelled". |
| | | 15. Sistem mengirimkan notifikasi database kepada konsumen dan seluruh admin. |

Tabel 7 menjelaskan deskripsi Use Case Diagram Melakukan Transaksi, yang menggambarkan proses checkout dan pembayaran pada sistem Gallery Puan. Proses diawali ketika konsumen yang telah login membuka halaman keranjang belanja. Sistem menampilkan daftar produk yang ada di keranjang beserta jumlah, berat, dan subtotal masing-masing item. Konsumen memilih item yang akan dibeli dan mengklik tombol "Checkout" untuk melanjutkan ke halaman checkout. Pada halaman checkout, konsumen memilih alamat pengiriman yang sudah tersimpan atau menambahkan alamat baru yang terintegrasi dengan data provinsi dan kota dari API RajaOngkir.

Selanjutnya, konsumen memilih kurir pengiriman seperti JNE, TIKI, atau Pos Indonesia. Sistem akan memanggil API RajaOngkir untuk menghitung ongkos kirim berdasarkan berat total produk dan alamat tujuan, kemudian menampilkan daftar layanan pengiriman beserta biaya dan estimasi waktu. Konsumen juga dapat memasukkan kode voucher diskon secara opsional untuk mendapatkan potongan harga. Setelah seluruh pilihan ditentukan, konsumen meninjau ringkasan pesanan dan mengklik tombol "Bayar". Sistem kemudian membuat data pesanan baru, memanggil Midtrans Snap API untuk mendapatkan token pembayaran, dan mengarahkan konsumen ke halaman pembayaran Midtrans. Setelah konsumen menyelesaikan pembayaran, sistem akan menerima callback dari Midtrans dan memperbarui status pesanan sesuai dengan hasil pembayaran, serta mengirimkan notifikasi kepada konsumen dan admin.

---

### Use Case 8: Klaim Voucher

| **Nama Use Case** | Klaim Voucher |
|---|---|
| **Actor** | Konsumen (sudah login) |
| **Tujuan** | Use case ini bertujuan untuk memungkinkan konsumen menggunakan kode voucher diskon yang dimiliki untuk mendapatkan potongan harga pada saat bertransaksi. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | 1. Konsumen membuka halaman keranjang atau halaman checkout. | 1. Sistem menampilkan kolom input kode voucher dan tombol "Terapkan". |
| | 2. Konsumen memasukkan kode voucher pada kolom yang tersedia. | |
| | 3. Konsumen mengklik tombol "Terapkan". | 2. Sistem memvalidasi kode voucher dengan memeriksa masa berlaku, minimum belanja, dan syarat khusus. |
| | | 3. Jika validasi berhasil, sistem menghitung diskon dan memperbarui total pembayaran. |
| | | 4. Jika validasi gagal, sistem menampilkan pesan kesalahan sesuai penyebab (voucher tidak aktif, masa berlaku habis, minimum belanja tidak terpenuhi). |

Tabel 8 menjelaskan deskripsi Use Case Diagram Klaim Voucher, yang menggambarkan proses penerapan kode voucher diskon pada transaksi di sistem Gallery Puan. Proses dimulai ketika konsumen yang telah login berada di halaman keranjang atau halaman checkout. Sistem akan menampilkan kolom input kode voucher beserta tombol "Terapkan" yang memungkinkan konsumen memasukkan kode promo yang dimiliki.

Setelah konsumen memasukkan kode voucher dan mengklik tombol "Terapkan", sistem akan melakukan serangkaian validasi terhadap kode tersebut. Validasi meliputi pemeriksaan masa berlaku voucher, apakah total belanja memenuhi syarat minimum belanja yang ditentukan, serta apakah voucher memiliki persyaratan khusus seperti hanya berlaku untuk pembelian pertama. Apabila seluruh validasi berhasil dilalui, sistem akan menghitung besaran diskon sesuai jenis voucher (persentase atau nominal tetap) dan memperbarui total pembayaran secara real-time. Namun, apabila validasi gagal, sistem akan menampilkan pesan kesalahan yang spesifik sesuai dengan penyebab kegagalan, seperti voucher sudah tidak aktif, masa berlaku telah habis, atau total belanja belum mencapai minimum yang ditentukan.

---

### Use Case 9: Notifikasi

| **Nama Use Case** | Notifikasi |
|---|---|
| **Actor** | Konsumen (sudah login) |
| **Tujuan** | Use case ini bertujuan untuk menampilkan pemberitahuan-pemberitahuan penting kepada konsumen terkait perkembangan status pesanan dan aktivitas akun. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | 1. Konsumen mengklik ikon notifikasi pada navbar website. | 1. Sistem menampilkan daftar notifikasi berisi judul, pesan, dan waktu. |
| | | 2. Sistem menampilkan jumlah notifikasi yang belum dibaca. |
| | 2. Konsumen mengklik salah satu notifikasi. | 3. Sistem menandai notifikasi sebagai sudah dibaca (mengisi field read_at). |
| | | 4. Sistem mengarahkan konsumen ke halaman terkait (misalnya halaman detail pesanan). |
| | 3. Konsumen mengklik tombol "Tandai Semua Dibaca". | 5. Sistem menandai seluruh notifikasi konsumen sebagai sudah dibaca dan memperbarui tampilan jumlah notifikasi menjadi nol. |

Tabel 9 menjelaskan deskripsi Use Case Diagram Notifikasi, yang menggambarkan proses konsumen dalam melihat dan mengelola pemberitahuan sistem pada Gallery Puan. Proses diawali ketika konsumen mengklik ikon notifikasi yang terdapat pada navbar website. Sistem akan menampilkan daftar notifikasi yang berisi informasi seperti judul notifikasi, pesan singkat, dan waktu notifikasi diterima. Sistem juga menampilkan indikator jumlah notifikasi yang belum dibaca oleh konsumen.

Konsumen dapat berinteraksi dengan notifikasi dengan dua cara. Pertama, konsumen dapat mengklik salah satu notifikasi untuk melihat detailnya. Sistem kemudian akan menandai notifikasi tersebut sebagai sudah dibaca dengan mengisi field read_at dan mengarahkan konsumen ke halaman yang relevan, seperti halaman detail pesanan. Kedua, konsumen dapat mengklik tombol "Tandai Semua Dibaca" untuk menandai seluruh notifikasi sebagai sudah dibaca sekaligus, yang akan memperbarui tampilan jumlah notifikasi menjadi nol. Notifikasi yang diterima konsumen meliputi pemberitahuan pembayaran berhasil, pesanan telah dikirim, dan pesanan telah selesai.

---

### Use Case 10: Melihat Status Pesanan

| **Nama Use Case** | Melihat Status Pesanan |
|---|---|
| **Actor** | Konsumen (sudah login) |
| **Tujuan** | Use case ini bertujuan untuk memungkinkan konsumen memantau perkembangan status pesanan yang telah dilakukan, mulai dari proses pembayaran hingga pesanan diterima. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | 1. Konsumen membuka halaman profil dan memilih menu "Pesanan Saya". | 1. Sistem menampilkan daftar pesanan konsumen dengan tab filter status: Belum Bayar, Dikemas, Dikirim, Selesai, Dibatalkan. |
| | 2. Konsumen memilih tab filter status yang diinginkan. | 2. Sistem menyaring dan menampilkan pesanan sesuai status yang dipilih. |
| | 3. Konsumen mengklik salah satu pesanan. | 3. Sistem menampilkan halaman detail pesanan berisi daftar produk, jumlah, harga, status pembayaran, status pengiriman, nomor resi (jika sudah dikirim), dan total pembayaran. |
| | 4. Jika pesanan berstatus "Dikirim" dan telah diterima, konsumen mengklik tombol "Selesai". | 4. Sistem mengubah status pesanan menjadi "completed" dan mengirim notifikasi "Pesanan Selesai" kepada konsumen. |
| | 5. Jika pesanan berstatus "Belum Bayar" dan masih dalam 24 jam, konsumen mengklik tombol "Batalkan". | 5. Sistem mengubah status pesanan menjadi "cancelled" dan mengirim notifikasi kepada seluruh admin. |

Tabel 10 menjelaskan deskripsi Use Case Diagram Melihat Status Pesanan, yang menggambarkan proses konsumen dalam memantau perkembangan status pesanan yang telah dilakukan pada sistem Gallery Puan. Proses dimulai ketika konsumen yang telah login membuka halaman profil dan memilih menu "Pesanan Saya". Sistem akan menampilkan daftar pesanan konsumen yang dilengkapi dengan tab filter berdasarkan status, yaitu Belum Bayar, Dikemas, Dikirim, Selesai, dan Dibatalkan. Konsumen dapat memilih tab filter tertentu untuk melihat pesanan dengan status yang diinginkan.

Apabila konsumen mengklik salah satu pesanan, sistem akan menampilkan halaman detail pesanan yang berisi informasi lengkap, termasuk daftar produk yang dibeli, jumlah, harga satuan, status pembayaran, status pengiriman, nomor resi pengiriman jika pesanan telah dikirim, serta total pembayaran. Konsumen juga dapat melakukan tindakan lanjutan pada halaman ini. Jika pesanan berstatus "Dikirim" dan telah diterima, konsumen dapat mengklik tombol "Selesai" untuk mengonfirmasi penerimaan, yang akan mengubah status pesanan menjadi "completed". Sebaliknya, jika pesanan berstatus "Belum Bayar" dan masih dalam batas waktu 24 jam, konsumen dapat membatalkan pesanan dengan mengklik tombol "Batalkan".

---

### Use Case 11: Live Chat

| **Nama Use Case** | Live Chat |
|---|---|
| **Actor** | Konsumen (sudah login) |
| **Tujuan** | Use case ini bertujuan untuk memungkinkan konsumen berkomunikasi secara langsung dengan admin toko melalui fitur chat untuk menanyakan informasi produk atau kendala transaksi. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | 1. Konsumen mengklik tombol chat yang tersedia di halaman produk atau navbar. | 1. Sistem membuka widget chat berbasis Livewire yang menampilkan histori percakapan (jika ada). |
| | 2. Konsumen mengetik pesan pada field input chat. | |
| | 3. Konsumen mengklik tombol kirim atau menekan enter. | 2. Sistem menyimpan pesan konsumen ke tabel messages dan menampilkannya pada widget chat. |
| | 4. Admin membalas pesan konsumen melalui panel admin. | 3. Sistem menyimpan balasan admin ke tabel messages dan menampilkannya pada widget chat konsumen secara real-time. |
| | 5. Konsumen dapat mengirimkan gambar pada chat (opsional). | 4. Sistem menyimpan file gambar dan menampilkannya di widget chat. |

Tabel 11 menjelaskan deskripsi Use Case Diagram Live Chat, yang menggambarkan proses komunikasi langsung antara konsumen dan admin toko melalui fitur chat pada sistem Gallery Puan. Proses diawali ketika konsumen yang telah login membuka widget chat dengan mengklik tombol chat yang tersedia di halaman produk atau navbar website. Sistem akan membuka widget chat berbasis Livewire yang menampilkan histori percakapan sebelumnya jika pernah melakukan chat sebelumnya.

Konsumen kemudian mengetik pesan pada field input chat dan mengirimkannya dengan mengklik tombol kirim atau menekan enter. Sistem akan menyimpan pesan konsumen ke dalam tabel messages dan menampilkannya pada widget chat. Di sisi lain, admin dapat melihat dan membalas pesan konsumen melalui panel admin. Setiap balasan yang dikirim admin akan disimpan oleh sistem dan ditampilkan pada widget chat konsumen secara real-time. Konsumen juga dapat mengirimkan lampiran gambar pada chat untuk memperjelas pertanyaan atau kendala yang dialami. Fitur ini memungkinkan konsumen mendapatkan respon cepat tanpa harus meninggalkan website.

---

### Use Case 12: Profil

| **Nama Use Case** | Profil |
|---|---|
| **Actor** | Konsumen (sudah login) |
| **Tujuan** | Use case ini bertujuan untuk memungkinkan konsumen melihat dan memperbarui data diri, mengelola alamat pengiriman, serta mengubah kata sandi akun. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | 1. Konsumen membuka halaman profil. | 1. Sistem menampilkan menu sidebar profil: Profil Saya, Alamat Saya, Ubah Kata Sandi, Wishlist, Ulasan Saya, Voucher Saya. |
| | **Sub-alur: Mengedit Profil** | |
| | 2a. Konsumen memilih menu "Profil Saya". | 2a. Sistem menampilkan form data diri (nama, email, nomor telepon). |
| | 3a. Konsumen mengubah data dan mengklik "Simpan". | 3a. Sistem memvalidasi dan menyimpan perubahan data profil. |
| | **Sub-alur: Mengelola Alamat** | |
| | 2b. Konsumen memilih menu "Alamat Saya". | 2b. Sistem menampilkan daftar alamat pengiriman yang tersimpan. |
| | 3b. Konsumen mengklik "Tambah Alamat". | 3b. Sistem menampilkan form alamat (provinsi, kota, kecamatan, alamat, kode pos, label). |
| | 4b. Konsumen mengisi data alamat dan mengklik "Simpan". | 4b. Sistem menyimpan alamat baru ke database. |
| | 5b. Konsumen mengklik edit atau hapus pada alamat. | 5b. Sistem memproses perubahan atau penghapusan alamat. |
| | **Sub-alur: Ubah Kata Sandi** | |
| | 2c. Konsumen memilih menu "Ubah Kata Sandi". | 2c. Sistem menampilkan form kata sandi lama, baru, dan konfirmasi. |
| | 3c. Konsumen memasukkan data dan mengklik "Simpan". | 3c. Sistem memvalidasi kata sandi lama. Jika valid, sistem memperbarui kata sandi. |

Tabel 12 menjelaskan deskripsi Use Case Diagram Profil, yang menggambarkan proses konsumen dalam mengelola data akun pada sistem Gallery Puan. Proses diawali ketika konsumen yang telah login membuka halaman profil. Sistem akan menampilkan menu sidebar yang berisi berbagai opsi pengelolaan akun, yaitu Profil Saya, Alamat Saya, Ubah Kata Sandi, Wishlist, Ulasan Saya, dan Voucher Saya.

Terdapat tiga sub-alur utama dalam use case ini. Pertama, pada sub-alur Mengedit Profil, konsumen dapat memperbarui data diri seperti nama, email, dan nomor telepon melalui formulir yang disediakan sistem. Kedua, pada sub-alur Mengelola Alamat, konsumen dapat menambahkan alamat pengiriman baru, mengedit alamat yang sudah ada, atau menghapus alamat yang tidak diperlukan. Form alamat terintegrasi dengan data provinsi dan kota dari RajaOngkir untuk memastikan akurasi data pengiriman. Ketiga, pada sub-alur Ubah Kata Sandi, konsumen dapat mengganti kata sandi akun dengan memasukkan kata sandi lama untuk verifikasi, kemudian memasukkan kata sandi baru beserta konfirmasinya.

---

### Use Case 13: Review Produk

| **Nama Use Case** | Review Produk |
|---|---|
| **Actor** | Konsumen (sudah login dan sudah membeli produk) |
| **Tujuan** | Use case ini bertujuan untuk memungkinkan konsumen memberikan ulasan dan penilaian terhadap produk yang telah dibeli, sehingga dapat membantu konsumen lain dalam pengambilan keputusan. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | 1. Konsumen membuka halaman profil dan memilih menu "Ulasan Saya". | 1. Sistem menampilkan daftar produk yang sudah dibeli dan dapat diulas. |
| | 2. Konsumen memilih produk yang akan diulas. | 2. Sistem menampilkan form ulasan: rating bintang (1-5) dan field komentar teks. |
| | 3. Konsumen memberikan rating dan menulis komentar. | |
| | 4. Konsumen mengklik tombol "Kirim Ulasan". | 3. Sistem menyimpan ulasan ke tabel shop_reviews dengan status "pending". |
| | | 4. Sistem menampilkan notifikasi bahwa ulasan berhasil dikirim dan menunggu persetujuan admin. |
| | 5. Admin menyetujui ulasan melalui panel admin. | 5. Sistem mengubah status ulasan menjadi "approved" dan menampilkannya pada halaman detail produk. |

Tabel 13 menjelaskan deskripsi Use Case Diagram Review Produk, yang menggambarkan proses konsumen dalam memberikan ulasan dan penilaian terhadap produk yang telah dibeli pada sistem Gallery Puan. Proses dimulai ketika konsumen yang telah login membuka halaman profil dan memilih menu "Ulasan Saya". Sistem akan menampilkan daftar produk yang telah dibeli oleh konsumen dan memenuhi syarat untuk diberikan ulasan.

Konsumen kemudian memilih produk yang ingin diulas, dan sistem akan menampilkan formulir ulasan yang terdiri dari dua komponen, yaitu rating bintang dengan skala 1 hingga 5 dan field komentar teks. Konsumen memberikan rating dengan mengklik bintang sesuai dengan tingkat kepuasan, kemudian menulis komentar ulasan. Setelah selesai, konsumen mengklik tombol "Kirim Ulasan". Sistem akan menyimpan ulasan ke dalam tabel shop_reviews dengan status awal "pending" dan menampilkan notifikasi bahwa ulasan berhasil dikirim serta menunggu persetujuan admin. Setelah admin menyetujui ulasan melalui panel admin, sistem akan mengubah status ulasan menjadi "approved" dan ulasan akan ditampilkan pada halaman detail produk untuk dapat dilihat oleh konsumen lain.

---

### Use Case 14: Logout

| **Nama Use Case** | Logout |
|---|---|
| **Actor** | Konsumen (sudah login) |
| **Tujuan** | Use case ini bertujuan untuk mengakhiri sesi autentikasi konsumen secara aman agar akun tidak dapat diakses oleh pihak lain pada perangkat yang sama. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | 1. Konsumen mengklik tombol "Logout" pada menu navigasi atau dropdown profil. | 1. Sistem menghapus sesi autentikasi konsumen dan mengarahkan ke halaman utama website. |

Tabel 14 menjelaskan deskripsi Use Case Diagram Logout, yang menggambarkan proses konsumen dalam mengakhiri sesi autentikasi pada sistem Gallery Puan. Proses ini sangat sederhana dan hanya melibatkan satu langkah dari aktor. Konsumen yang telah login dapat mengakhiri sesi dengan mengklik tombol "Logout" yang tersedia pada menu navigasi atau dropdown profil.

Setelah konsumen mengklik tombol "Logout", sistem akan menghapus sesi autentikasi konsumen sehingga tidak ada akses ke fitur-fitur yang memerlukan login. Sistem kemudian akan mengarahkan konsumen kembali ke halaman utama website. Proses logout penting untuk menjaga keamanan akun, terutama ketika konsumen menggunakan perangkat bersama atau publik.

---

## B. Aktivitas Admin

---

### Use Case 15: Login Admin

| **Nama Use Case** | Login Admin |
|---|---|
| **Actor** | Admin |
| **Tujuan** | Use case ini bertujuan untuk memverifikasi identitas admin agar dapat mengakses panel administrasi toko dan mengelola seluruh data pada sistem. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | 1. Admin membuka halaman login admin pada URL `/admin`. | 1. Sistem menampilkan formulir login admin. |
| | 2. Admin memasukkan email dan kata sandi akun admin. | |
| | 3. Admin mengklik tombol "Login". | 2. Sistem memvalidasi kredensial admin dengan data pada tabel admins menggunakan guard auth:admin. |
| | | 3. Jika kredensial benar, sistem membuat sesi autentikasi admin dan mengarahkan ke halaman dashboard. |
| | | 4. Jika kredensial salah, sistem menampilkan pesan kesalahan. |

Tabel 15 menjelaskan deskripsi Use Case Diagram Login Admin, yang menggambarkan proses autentikasi admin pada sistem Gallery Puan. Proses dimulai ketika admin membuka halaman login admin pada URL `/admin`. Sistem akan menampilkan formulir login yang meminta email dan kata sandi akun admin.

Admin memasukkan kredensial yang dimiliki dan mengklik tombol "Login". Sistem kemudian akan memvalidasi kredensial tersebut dengan data yang tersimpan pada tabel admins. Sistem menggunakan guard autentikasi terpisah (auth:admin) yang berbeda dengan guard konsumen (web) untuk memisahkan akses panel administrasi dari halaman publik. Apabila kredensial yang dimasukkan benar, sistem akan membuat sesi autentikasi admin dan mengarahkan admin ke halaman dashboard. Apabila kredensial salah, sistem akan menampilkan pesan kesalahan dan admin dapat mengulangi proses login.

---

### Use Case 16: Kelola Kategori Produk

| **Nama Use Case** | Kelola Kategori Produk |
|---|---|
| **Actor** | Admin |
| **Tujuan** | Use case ini bertujuan untuk memungkinkan admin mengelola data kategori produk yang digunakan untuk mengelompokkan produk, meliputi operasi tambah, lihat, ubah, dan hapus kategori. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | 1. Admin membuka menu "Kategori" pada panel admin. | 1. Sistem menampilkan daftar kategori produk dalam bentuk hierarki (parent-child). |
| | **Sub-alur: Tambah Kategori** | |
| | 2a. Admin mengklik tombol "Tambah Kategori". | 2a. Sistem menampilkan form input kategori (nama, slug, kategori induk/parent). |
| | 3a. Admin mengisi data kategori dan mengklik "Simpan". | 3a. Sistem memvalidasi dan menyimpan kategori baru ke database. |
| | **Sub-alur: Edit Kategori** | |
| | 2b. Admin mengklik tombol edit pada kategori yang dipilih. | 2b. Sistem menampilkan form dengan data kategori yang ada. |
| | 3b. Admin mengubah data dan mengklik "Simpan". | 3b. Sistem memperbarui data kategori. |
| | **Sub-alur: Hapus Kategori** | |
| | 2c. Admin mengklik tombol hapus pada kategori. | 2c. Sistem menghapus kategori beserta relasi product-category yang terkait. |

Tabel 16 menjelaskan deskripsi Use Case Diagram Kelola Kategori Produk, yang menggambarkan proses admin dalam mengelola kategori produk pada sistem Gallery Puan. Proses diawali ketika admin membuka menu "Kategori" pada panel admin. Sistem akan menampilkan daftar kategori produk dalam bentuk hierarki, di mana kategori dapat memiliki kategori induk (parent) sehingga membentuk struktur bertingkat.

Terdapat tiga sub-alur dalam use case ini. Pada sub-alur Tambah Kategori, admin mengklik tombol "Tambah Kategori" dan sistem menampilkan form yang berisi field nama kategori, slug (untuk URL), dan kategori induk jika kategori merupakan sub-kategori. Pada sub-alur Edit Kategori, admin dapat mengubah data kategori yang sudah ada melalui form edit. Pada sub-alur Hapus Kategori, admin dapat menghapus kategori yang tidak diperlukan, dan sistem akan menghapus kategori beserta relasi produk-kategori yang terkait. Seluruh operasi CRUD ini memungkinkan admin untuk mengatur struktur kategori produk secara fleksibel.

---

### Use Case 17: Kelola Produk

| **Nama Use Case** | Kelola Produk |
|---|---|
| **Actor** | Admin |
| **Tujuan** | Use case ini bertujuan untuk memungkinkan admin mengelola data produk secara lengkap, meliputi penambahan produk baru, pengeditan data produk, pengaturan stok dan harga, serta penghapusan produk. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | 1. Admin membuka menu "Produk" pada panel admin. | 1. Sistem menampilkan daftar produk dengan paginasi, pencarian, dan filter. |
| | **Sub-alur: Tambah Produk** | |
| | 2a. Admin mengklik tombol "Tambah Produk". | 2a. Sistem menampilkan form produk: nama, SKU, slug, tipe, harga, harga diskon, berat, stok, status, kategori, deskripsi (TinyMCE), dan upload gambar. |
| | 3a. Admin mengisi data produk, mengunggah gambar, dan mengklik "Simpan". | 3a. Sistem memvalidasi dan menyimpan data produk ke database serta gambar melalui Spatie Media Library. |
| | **Sub-alur: Edit Produk** | |
| | 2b. Admin mengklik tombol edit pada produk. | 2b. Sistem menampilkan form dengan data produk yang ada. |
| | 3b. Admin mengubah data (termasuk harga diskon) dan mengklik "Simpan". | 3b. Sistem memperbarui data produk. Jika sale_price diturunkan, sistem mendispatch job SendWishlistPriceDropEmail. |
| | **Sub-alur: Hapus Produk** | |
| | 2c. Admin mengklik tombol hapus pada produk. | 2c. Sistem menghapus produk beserta gambar dan relasi terkait. |

Tabel 17 menjelaskan deskripsi Use Case Diagram Kelola Produk, yang menggambarkan proses admin dalam mengelola data produk pada sistem Gallery Puan. Proses diawali ketika admin membuka menu "Produk" pada panel admin. Sistem akan menampilkan daftar produk yang dilengkapi dengan fitur paginasi, pencarian, dan filter untuk memudahkan admin menemukan produk tertentu.

Terdapat tiga sub-alur utama dalam use case ini. Pada sub-alur Tambah Produk, admin mengisi form produk yang lengkap meliputi nama produk, SKU, slug, tipe produk (simple/configurable), harga, harga diskon, berat, jumlah stok, status, pemilihan kategori, deskripsi menggunakan editor TinyMCE, dan unggahan gambar produk. Sistem kemudian menyimpan data produk ke database dan gambar produk melalui Spatie Media Library. Pada sub-alur Edit Produk, admin dapat mengubah data produk yang sudah ada, termasuk mengubah harga diskon. Apabila harga diskon diturunkan, sistem akan secara otomatis mendispatch job SendWishlistPriceDropEmail untuk memberitahu konsumen yang memasukkan produk tersebut ke wishlist. Pada sub-alur Hapus Produk, admin dapat menghapus produk beserta seluruh data terkait.

---

### Use Case 18: Kelola Voucher Belanja

| **Nama Use Case** | Kelola Voucher Belanja |
|---|---|
| **Actor** | Admin |
| **Tujuan** | Use case ini bertujuan untuk memungkinkan admin mengelola kupon diskon atau voucher belanja yang dapat digunakan oleh konsumen saat bertransaksi. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | 1. Admin membuka menu "Kupon" pada panel admin. | 1. Sistem menampilkan daftar kupon yang tersedia. |
| | **Sub-alur: Tambah Kupon** | |
| | 2a. Admin mengklik tombol "Tambah Kupon". | 2a. Sistem menampilkan form kupon (kode, tipe diskon, nilai, min belanja, kuota, masa berlaku, syarat khusus). |
| | 3a. Admin mengisi data kupon dan mengklik "Simpan". | 3a. Sistem menyimpan data kupon ke database. |
| | **Sub-alur: Edit Kupon** | |
| | 2b. Admin mengklik tombol edit pada kupon. | 2b. Sistem menampilkan form edit kupon. |
| | 3b. Admin mengubah data dan mengklik "Simpan". | 3b. Sistem memperbarui data kupon. |
| | **Sub-alur: Hapus Kupon** | |
| | 2c. Admin mengklik tombol hapus pada kupon. | 2c. Sistem menghapus data kupon. |

Tabel 18 menjelaskan deskripsi Use Case Diagram Kelola Voucher Belanja, yang menggambarkan proses admin dalam mengelola kupon diskon pada sistem Gallery Puan. Proses diawali ketika admin membuka menu "Kupon" pada panel admin. Sistem akan menampilkan daftar kupon yang tersedia beserta informasi seperti kode, tipe diskon, nilai, dan status aktif atau tidak aktif.

Terdapat tiga sub-alur dalam use case ini. Pada sub-alur Tambah Kupon, admin mengisi form yang mencakup kode kupon unik, tipe diskon (persentase atau nominal tetap), nilai diskon, minimum total belanja, kuota pemakaian, tanggal mulai dan berakhir masa berlaku, serta syarat khusus seperti hanya untuk pembelian pertama atau minimum jumlah pesanan sebelumnya. Pada sub-alur Edit Kupon, admin dapat mengubah data kupon yang sudah ada. Pada sub-alur Hapus Kupon, admin dapat menghapus kupon yang tidak diperlukan. Pengelolaan kupon ini memungkinkan admin untuk menjalankan strategi promosi dan diskon secara terstruktur.

---

### Use Case 19: Kelola Pesanan

| **Nama Use Case** | Kelola Pesanan |
|---|---|
| **Actor** | Admin |
| **Tujuan** | Use case ini bertujuan untuk memungkinkan admin memproses pesanan konsumen melalui seluruh tahapan siklus hidup pesanan, mulai dari konfirmasi, pengemasan, pengiriman, hingga pembatalan. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | 1. Admin membuka menu "Pesanan" pada panel admin. | 1. Sistem menampilkan daftar pesanan dengan filter status (semua, pending, confirmed, packaging, delivered, cancelled). |
| | 2. Admin memilih filter status dan mengklik salah satu pesanan. | 2. Sistem menampilkan detail pesanan: daftar produk, alamat pengiriman, status pembayaran, riwayat status. |
| | **Sub-alur: Konfirmasi Pesanan** | |
| | 3a. Admin mengklik tombol "Konfirmasi". | 3a. Sistem mengubah status pesanan menjadi "confirmed". |
| | **Sub-alur: Proses Pengemasan** | |
| | 3b. Admin mengklik tombol "Kemas". | 3b. Sistem mengubah status pesanan menjadi "packaging". |
| | **Sub-alur: Kirim Pesanan** | |
| | 3c. Admin mengklik tombol "Kirim" dan memasukkan nomor resi. | 3c. Sistem mengubah status pesanan menjadi "delivered". |
| | | 3d. Sistem mengirim notifikasi database "Pesanan Dikirim" ke konsumen. |
| | | 3e. Jika nomor resi diisi, sistem mengirim email ShippingTrackingMail ke konsumen. |
| | **Sub-alur: Batalkan Pesanan** | |
| | 3d. Admin mengklik tombol "Batalkan". | 3f. Sistem mengubah status pesanan menjadi "cancelled" dan mengirim notifikasi database "Pesanan Dibatalkan" ke konsumen. |

Tabel 19 menjelaskan deskripsi Use Case Diagram Kelola Pesanan, yang menggambarkan proses admin dalam memproses dan mengelola pesanan konsumen pada sistem Gallery Puan. Proses diawali ketika admin membuka menu "Pesanan" pada panel admin. Sistem akan menampilkan daftar seluruh pesanan yang dilengkapi dengan filter berdasarkan status, seperti semua pesanan, pending, confirmed, packaging, delivered, dan cancelled.

Terdapat empat sub-alur dalam use case ini yang merepresentasikan tahapan siklus hidup pesanan. Pertama, sub-alur Konfirmasi Pesanan, di mana admin mengonfirmasi pesanan yang sudah dibayar dan status berubah menjadi "confirmed". Kedua, sub-alur Proses Pengemasan, di mana admin memulai proses pengemasan dan status berubah menjadi "packaging". Ketiga, sub-alur Kirim Pesanan, di mana admin memasukkan nomor resi pengiriman dan status berubah menjadi "delivered", dilanjutkan dengan pengiriman notifikasi database dan email tracking kepada konsumen. Keempat, sub-alur Batalkan Pesanan, di mana admin dapat membatalkan pesanan dengan mengubah status menjadi "cancelled" dan mengirim notifikasi kepada konsumen.

---

### Use Case 20: Melihat Data Konsumen

| **Nama Use Case** | Melihat Data Konsumen |
|---|---|
| **Actor** | Admin |
| **Tujuan** | Use case ini bertujuan untuk memungkinkan admin melihat data dan informasi konsumen yang terdaftar, termasuk profil dan riwayat transaksi. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | 1. Admin membuka menu "Konsumen" pada panel admin. | 1. Sistem menampilkan daftar konsumen terdaftar dalam tabel (nama, email, nomor telepon, tanggal daftar). |
| | 2. Admin mencari konsumen berdasarkan nama atau email. | 2. Sistem memfilter daftar konsumen sesuai kata kunci pencarian. |
| | 3. Admin mengklik salah satu konsumen. | 3. Sistem menampilkan halaman detail konsumen berisi profil lengkap, daftar alamat, dan riwayat pesanan. |

Tabel 20 menjelaskan deskripsi Use Case Diagram Melihat Data Konsumen, yang menggambarkan proses admin dalam melihat informasi konsumen pada sistem Gallery Puan. Proses dimulai ketika admin membuka menu "Konsumen" pada panel admin. Sistem akan menampilkan daftar seluruh konsumen yang terdaftar dalam bentuk tabel yang berisi informasi seperti nama, alamat email, nomor telepon, dan tanggal pendaftaran.

Admin dapat mencari konsumen tertentu dengan memasukkan kata kunci nama atau email pada kolom pencarian, dan sistem akan memfilter daftar konsumen sesuai kata kunci tersebut. Apabila admin mengklik salah satu konsumen, sistem akan menampilkan halaman detail konsumen yang berisi informasi profil lengkap, daftar alamat pengiriman yang tersimpan, serta riwayat seluruh pesanan yang pernah dilakukan oleh konsumen tersebut. Informasi ini berguna bagi admin untuk memberikan pelayanan yang lebih personal atau menyelesaikan kendala yang dialami konsumen.

---

### Use Case 21: Laporan Penjualan

| **Nama Use Case** | Laporan Penjualan |
|---|---|
| **Actor** | Admin |
| **Tujuan** | Use case ini bertujuan untuk menyajikan data dan grafik penjualan kepada admin sebagai bahan evaluasi dan pengambilan keputusan bisnis. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | 1. Admin membuka menu "Laporan" pada panel admin. | 1. Sistem menampilkan halaman laporan berisi grafik penjualan (ApexCharts), ringkasan total pesanan, total pendapatan, dan produk terlaris. |
| | 2. Admin memilih rentang tanggal untuk memfilter laporan. | 2. Sistem memperbarui tampilan grafik dan data ringkasan sesuai rentang tanggal yang dipilih. |

Tabel 21 menjelaskan deskripsi Use Case Diagram Laporan Penjualan, yang menggambarkan proses admin dalam melihat laporan penjualan pada sistem Gallery Puan. Proses dimulai ketika admin membuka menu "Laporan" pada panel admin. Sistem akan menampilkan halaman laporan yang berisi grafik penjualan yang dirender menggunakan library ApexCharts, serta ringkasan data berupa total jumlah pesanan, total pendapatan, dan daftar produk terlaris.

Admin dapat memfilter laporan berdasarkan rentang tanggal tertentu untuk melihat data penjualan pada periode yang diinginkan. Setelah admin memilih rentang tanggal, sistem akan memperbarui tampilan grafik dan data ringkasan secara dinamis sesuai periode yang dipilih. Fitur laporan ini membantu admin dalam memantau kinerja penjualan toko, mengidentifikasi tren, dan membuat keputusan bisnis yang lebih tepat.

---

### Use Case 22: Kelola Konten Homepage

| **Nama Use Case** | Kelola Konten Homepage |
|---|---|
| **Actor** | Admin |
| **Tujuan** | Use case ini bertujuan untuk memungkinkan admin memperbarui konten halaman utama website secara mandiri tanpa harus mengubah kode program, meliputi identitas website, banner hero, bagian promo, bagian tentang kami, dan galeri estetik. |
| **Alur Peristiwa** | **Aktor** | **Sistem** |
| | 1. Admin membuka menu "Pengaturan" pada panel admin. | 1. Sistem memuat data settings dari database (menggunakan cache jika tersedia). |
| | | 2. Sistem menampilkan form pengaturan 5 bagian: Identitas Website, Banner Utama, Bagian Promo, Bagian Tentang Kami, Galeri Estetik. |
| | **Sub-alur: Update Identitas Website** | |
| | 2a. Admin mengunggah logo dan/atau favicon baru. | 2a. Sistem menyimpan file ke storage dan memperbarui nilai setting. |
| | **Sub-alur: Update Banner Hero** | |
| | 2b. Admin mengubah judul hero, subjudul, dan/atau gambar latar. | 2b. Sistem menyimpan perubahan dan menghapus cache. |
| | **Sub-alur: Update Bagian Promo** | |
| | 2c. Admin mengubah label promo, judul, deskripsi, dan/atau gambar promo. | 2c. Sistem menyimpan perubahan dan menghapus cache. |
| | **Sub-alur: Update Bagian Tentang Kami** | |
| | 2d. Admin mengubah judul hero, subjudul, judul cerita, deskripsi, dan/atau gambar cerita. | 2d. Sistem menyimpan perubahan dan menghapus cache. |
| | **Sub-alur: Kelola Galeri** | |
| | 2e. Admin mengunggah gambar baru ke galeri atau menghapus gambar galeri. | 2e. Sistem menyimpan/menghapus gambar galeri. |
| | 3. Admin mengklik tombol "Simpan" pada masing-masing bagian. | 3. Sistem memproses: teks disimpan via Setting::setValue(), gambar disimpan ke storage dan dicatat ke tabel settings serta setting_images (riwayat). |
| | | 4. Sistem menghapus cache untuk key yang diubah dan menampilkan pesan sukses. |

Tabel 22 menjelaskan deskripsi Use Case Diagram Kelola Konten Homepage, yang menggambarkan proses admin dalam memperbarui konten halaman utama website Gallery Puan. Proses dimulai ketika admin membuka menu "Pengaturan" pada panel admin. Sistem akan memuat data settings dari database dengan memanfaatkan cache untuk mempercepat pemuatan, kemudian menampilkan form pengaturan yang terbagi menjadi lima bagian utama, yaitu Identitas Website (logo dan favicon), Banner Utama (judul, subjudul, gambar latar), Bagian Promo (label, judul, deskripsi, gambar), Bagian Tentang Kami (judul, subjudul, cerita, gambar), dan Galeri Estetik.

Admin dapat memperbarui konten pada masing-masing bagian secara terpisah. Untuk field teks, admin cukup mengubah isian pada form. Untuk field gambar, admin dapat mengunggah file gambar baru dari komputer atau memilih gambar dari riwayat unggahan sebelumnya. Setelah admin mengklik tombol "Simpan", sistem akan memproses perubahan sesuai tipe field. Field teks disimpan ke dalam tabel settings melalui metode Setting::setValue(), sedangkan field gambar disimpan ke direktori storage dan dicatat ke dalam tabel settings serta setting_images untuk keperluan riwayat. Sistem kemudian menghapus cache untuk key yang diubah agar pembaruan dapat langsung terlihat. Setelah admin menyimpan perubahan, pengunjung yang membuka halaman utama website akan melihat konten yang telah diperbarui tanpa perlu melakukan deploy ulang aplikasi.
