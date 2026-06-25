# Deskripsi Activity Diagram — Gallery Puan

---

## 1. Activity Diagram Register

Gambar 1 merupakan Activity Diagram Register yang menggambarkan alur aktivitas pengunjung dalam mendaftarkan akun baru pada sistem Gallery Puan. Proses dimulai ketika pengunjung mengakses halaman registrasi. Sistem kemudian menampilkan formulir pendaftaran yang berisi field nama lengkap, alamat email, nomor telepon, kata sandi, dan konfirmasi kata sandi. Pengunjung mengisi data diri pada formulir tersebut dan mengklik tombol "Daftar" untuk mengirimkan data pendaftaran.

Sistem selanjutnya memvalidasi data yang dimasukkan, meliputi pemeriksaan format email, kekuatan kata sandi, kesesuaian antara kata sandi dan konfirmasi kata sandi, serta ketersediaan alamat email untuk mencegah duplikasi akun. Apabila validasi gagal, sistem akan menampilkan pesan kesalahan dan pengunjung dapat memperbaiki data yang salah. Apabila validasi berhasil, sistem menyimpan data pengguna ke dalam basis data dengan UUID sebagai primary key, menampilkan notifikasi keberhasilan registrasi, dan secara otomatis mengirimkan email sambutan berisi kode promo ke alamat email pengguna. Pengunjung kemudian dapat login menggunakan akun yang baru dibuat.

---

## 2. Activity Diagram Login Konsumen

Gambar 2 merupakan Activity Diagram Login Konsumen yang menggambarkan alur aktivitas konsumen dalam melakukan autentikasi masuk ke dalam sistem Gallery Puan. Proses dimulai ketika konsumen yang telah memiliki akun mengakses halaman login. Sistem menampilkan formulir login yang terdiri dari field alamat email dan kata sandi.

Konsumen memasukkan kredensial akun yang dimiliki dan mengklik tombol "Login". Sistem kemudian melakukan validasi kredensial dengan mencocokkan data yang dimasukkan dengan informasi yang tersimpan di basis data. Apabila alamat email dan kata sandi yang dimasukkan sesuai, sistem akan membuat sesi autentikasi dan mengarahkan konsumen ke halaman utama website. Apabila kredensial yang dimasukkan tidak sesuai, sistem akan menolak akses dan menampilkan pesan kesalahan "Email atau kata sandi tidak sesuai" sehingga konsumen dapat mengulangi proses login.

---

## 3. Activity Diagram Pencarian Produk

Gambar 3 merupakan Activity Diagram Pencarian Produk yang menggambarkan alur aktivitas pengguna dalam mencari produk yang diinginkan pada sistem Gallery Puan. Proses dimulai ketika pengguna membuka halaman katalog produk. Sistem menampilkan daftar produk secara lengkap dengan paginasi.

Pengguna kemudian dapat mempersempit hasil pencarian dengan beberapa langkah, yaitu memasukkan kata kunci pada kolom pencarian, memilih kategori produk dari sidebar filter, menentukan rentang harga minimum dan maksimum, serta memilih opsi pengurutan seperti harga termurah, termahal, atau produk terbaru. Setiap interaksi yang dilakukan pengguna akan diproses oleh sistem secara real-time. Sistem akan menyaring, memfilter, dan mengurutkan produk berdasarkan seluruh kriteria yang telah ditentukan, kemudian menampilkan hasil pencarian yang sesuai. Fitur ini memungkinkan pengguna untuk menavigasi produk dengan efisien.

---

## 4. Activity Diagram Detail Produk

Gambar 4 merupakan Activity Diagram Detail Produk yang menggambarkan alur aktivitas pengguna ketika melihat informasi lengkap suatu produk pada sistem Gallery Puan. Proses dimulai ketika pengguna mengklik produk yang diminati dari halaman katalog atau hasil pencarian. Sistem kemudian mencari data produk berdasarkan kombinasi slug dan SKU yang terdapat pada URL sekaligus menambahkan jumlah views_count untuk mencatat popularitas produk.

Apabila produk tidak ditemukan, sistem menampilkan halaman 404. Apabila ditemukan, sistem menampilkan halaman detail produk yang lengkap meliputi galeri gambar produk dalam bentuk carousel, nama produk, SKU, harga, label diskon beserta persentasenya jika produk sedang promosi, status ketersediaan stok, dan deskripsi produk. Sistem juga menampilkan rating rata-rata beserta ulasan dari konsumen lain yang telah membeli produk tersebut. Apabila konsumen dalam keadaan login, sistem juga memeriksa status wishlist produk untuk menampilkan ikon heart yang sesuai. Pengguna dapat berinteraksi dengan menambahkan produk ke keranjang, menambahkan ke wishlist, atau menghubungi admin melalui fitur chat.

---

## 5. Activity Diagram Menambahkan Wishlist

Gambar 5 merupakan Activity Diagram Menambahkan Wishlist yang menggambarkan alur aktivitas konsumen dalam menyimpan produk favorit ke dalam daftar wishlist pada sistem Gallery Puan. Proses dimulai ketika konsumen yang telah login membuka halaman detail produk. Sistem menampilkan tombol wishlist berbentuk ikon hati yang merepresentasikan status wishlist produk tersebut.

Konsumen mengklik tombol wishlist, dan sistem akan memeriksa apakah produk sudah tercatat dalam daftar wishlist konsumen. Apabila produk belum tercatat, sistem akan menambahkan produk ke dalam daftar wishlist dan mengubah tampilan ikon menjadi terisi (solid). Apabila produk sudah tercatat dalam wishlist, sistem akan menghapus produk dari daftar wishlist dan mengembalikan tampilan ikon menjadi kosong (outline). Mekanisme toggle ini memudahkan konsumen dalam mengelola daftar produk favorit tanpa perlu membuka halaman terpisah.

---

## 6. Activity Diagram Menambahkan Produk ke Keranjang Belanja

Gambar 6 merupakan Activity Diagram Menambahkan Produk ke Keranjang Belanja yang menggambarkan alur aktivitas konsumen dalam memasukkan produk ke dalam keranjang belanja pada sistem Gallery Puan. Proses dimulai ketika konsumen yang telah login membuka halaman detail produk. Sistem menampilkan informasi produk beserta field input jumlah dan tombol "Tambah ke Keranjang".

Konsumen menentukan jumlah produk yang diinginkan pada field qty, kemudian mengklik tombol "Tambah ke Keranjang". Sistem melakukan validasi terhadap ketersediaan stok produk sesuai jumlah yang diminta. Apabila stok tidak mencukupi, sistem menampilkan notifikasi bahwa stok tidak tersedia. Apabila stok tersedia, sistem menyimpan item ke dalam tabel keranjang belanja konsumen beserta jumlah dan berat total, menampilkan notifikasi bahwa produk berhasil ditambahkan, serta memperbarui jumlah item pada ikon keranjang di navbar. Konsumen kemudian dapat melanjutkan belanja atau langsung menuju halaman keranjang untuk checkout.

---

## 7. Activity Diagram Melakukan Transaksi (Checkout)

Gambar 7 merupakan Activity Diagram Melakukan Transaksi yang menggambarkan alur aktivitas konsumen dalam menyelesaikan pembelian pada sistem Gallery Puan. Proses dimulai ketika konsumen yang telah login membuka halaman keranjang belanja dan memilih item yang akan dibeli, kemudian mengklik tombol "Checkout". Sistem mengarahkan konsumen ke halaman checkout.

Pada halaman checkout, konsumen memilih alamat pengiriman yang sudah tersimpan atau menambahkan alamat baru yang terintegrasi dengan API RajaOngkir. Selanjutnya konsumen memilih kurir pengiriman dan sistem memanggil API RajaOngkir untuk menghitung ongkos kirim serta menampilkan daftar layanan beserta biaya dan estimasi waktu. Konsumen juga dapat memilih voucher diskon yang tersedia secara opsional. Setelah seluruh pilihan ditentukan, konsumen meninjau ringkasan pesanan dan mengklik tombol "Bayar". Sistem kemudian membuat data pesanan baru, memanggil Midtrans Snap API untuk mendapatkan token pembayaran, dan mengarahkan konsumen ke halaman pembayaran Midtrans. Setelah konsumen menyelesaikan pembayaran, sistem menerima callback dari Midtrans dan memperbarui status pesanan sesuai hasil pembayaran. Jika sukses, status berubah menjadi "processing". Jika gagal atau kedaluwarsa, status berubah menjadi "cancelled". Sistem kemudian mengirimkan notifikasi kepada konsumen dan seluruh admin.

---

## 8. Activity Diagram Menggunakan Voucher

Gambar 8 merupakan Activity Diagram Menggunakan Voucher yang menggambarkan alur aktivitas konsumen dalam menggunakan voucher diskon pada saat checkout di sistem Gallery Puan. Proses dimulai ketika konsumen berada di halaman checkout dan melihat tombol "Gunakan Voucher Promo" yang ditampilkan sistem.

Konsumen mengklik tombol tersebut, dan sistem membuka modal yang berisi daftar seluruh voucher aktif. Setiap voucher ditampilkan dalam bentuk kartu yang berisi kode voucher, deskripsi, informasi minimal belanja, dan badge persyaratan khusus. Voucher yang memenuhi syarat memiliki tombol "Pakai" yang aktif, sedangkan yang tidak memenuhi syarat tampak redup beserta alasan ketidakmampuannya. Konsumen memilih voucher yang diinginkan dan mengklik tombol "Pakai". Sistem kemudian mengirim request AJAX POST ke endpoint `carts.apply_coupon` untuk memvalidasi dan menerapkan diskon, kemudian memperbarui total pembayaran secara real-time. Konsumen juga dapat membatalkan voucher dengan mengklik tombol "X", dan sistem akan menghapus diskon serta mengembalikan total ke nilai awal.

---

## 9. Activity Diagram Notifikasi

Gambar 9 merupakan Activity Diagram Notifikasi yang menggambarkan alur aktivitas konsumen dalam melihat dan mengelola pemberitahuan sistem pada Gallery Puan. Proses dimulai ketika konsumen mengklik ikon notifikasi yang terdapat pada navbar website. Sistem menampilkan daftar notifikasi berisi judul, pesan singkat, dan waktu notifikasi diterima, serta indikator jumlah notifikasi yang belum dibaca.

Konsumen dapat berinteraksi dengan notifikasi melalui dua cara. Pertama, konsumen dapat mengklik salah satu notifikasi untuk melihat detailnya, dan sistem akan menandai notifikasi tersebut sebagai sudah dibaca serta mengarahkan konsumen ke halaman relevan seperti halaman detail pesanan. Kedua, konsumen dapat mengklik tombol "Tandai Semua Dibaca" untuk menandai seluruh notifikasi sebagai sudah dibaca sekaligus, dan sistem akan memperbarui tampilan jumlah notifikasi menjadi nol. Notifikasi yang diterima meliputi pembayaran berhasil, pesanan dikirim, dan pesanan selesai.

---

## 10. Activity Diagram Melihat Status Pesanan

Gambar 10 merupakan Activity Diagram Melihat Status Pesanan yang menggambarkan alur aktivitas konsumen dalam memantau perkembangan status pesanan pada sistem Gallery Puan. Proses dimulai ketika konsumen yang telah login membuka halaman profil dan memilih menu "Pesanan Saya". Sistem menampilkan daftar pesanan konsumen dengan tab filter berdasarkan status yaitu Belum Bayar, Dikemas, Dikirim, Selesai, dan Dibatalkan.

Konsumen dapat memilih tab filter tertentu dan sistem akan menyaring pesanan sesuai status yang dipilih. Konsumen kemudian dapat mengklik salah satu pesanan untuk melihat detail lengkap yang meliputi daftar produk, jumlah, harga, status pembayaran, status pengiriman, nomor resi jika sudah dikirim, dan total pembayaran. Apabila pesanan berstatus "Dikirim" dan telah diterima, konsumen dapat mengklik tombol "Selesai" untuk mengonfirmasi penerimaan dan sistem mengubah status menjadi "completed". Apabila pesanan berstatus "Belum Bayar" dan masih dalam batas waktu 24 jam, konsumen dapat membatalkan pesanan dengan mengklik tombol "Batalkan".

---

## 11. Activity Diagram Live Chat

Gambar 11 merupakan Activity Diagram Live Chat yang menggambarkan alur aktivitas komunikasi langsung antara konsumen dan admin toko melalui fitur chat pada sistem Gallery Puan. Proses dimulai ketika konsumen yang telah login mengklik tombol chat yang tersedia di halaman produk atau navbar. Sistem membuka widget chat berbasis Livewire yang menampilkan histori percakapan apabila sebelumnya pernah melakukan chat.

Konsumen mengetik pesan pada field input chat dan mengirimkannya dengan mengklik tombol kirim atau menekan enter. Sistem menyimpan pesan konsumen ke tabel messages dan menampilkannya pada widget chat. Admin kemudian dapat melihat dan membalas pesan konsumen melalui panel admin. Setiap balasan yang dikirim admin akan disimpan oleh sistem dan ditampilkan pada widget chat konsumen secara real-time. Konsumen juga dapat mengirimkan lampiran gambar untuk memperjelas pertanyaan. Fitur ini memungkinkan konsumen mendapatkan respon cepat tanpa meninggalkan website.

---

## 12. Activity Diagram Profil

Gambar 12 merupakan Activity Diagram Profil yang menggambarkan alur aktivitas konsumen dalam mengelola data akun pada sistem Gallery Puan. Proses dimulai ketika konsumen yang telah login membuka halaman profil. Sistem menampilkan menu sidebar yang berisi Profil Saya, Alamat Saya, Ubah Kata Sandi, Wishlist, Ulasan Saya, dan Voucher Saya.

Terdapat tiga sub-alur utama dalam activity diagram ini. Pertama, sub-alur Mengedit Profil: konsumen dapat memperbarui data diri seperti nama, email, dan nomor telepon melalui formulir yang disediakan sistem, kemudian data disimpan setelah validasi. Kedua, sub-alur Mengelola Alamat: konsumen dapat menambahkan alamat pengiriman baru dengan memilih provinsi dan kota yang terintegrasi dengan RajaOngkir, mengedit alamat yang sudah ada, atau menghapus alamat yang tidak diperlukan. Ketiga, sub-alur Ubah Kata Sandi: konsumen dapat mengganti kata sandi dengan memasukkan kata sandi lama untuk verifikasi, kemudian kata sandi baru beserta konfirmasinya.

---

## 13. Activity Diagram Review Produk

Gambar 13 merupakan Activity Diagram Review Produk yang menggambarkan alur aktivitas konsumen dalam memberikan ulasan dan penilaian terhadap produk yang telah dibeli pada sistem Gallery Puan. Proses dimulai ketika konsumen yang telah login membuka halaman profil dan memilih menu "Ulasan Saya". Sistem menampilkan daftar produk yang sudah dibeli dan memenuhi syarat untuk diberikan ulasan.

Konsumen memilih produk yang akan diulas, dan sistem menampilkan formulir ulasan yang terdiri dari rating bintang dengan skala 1 hingga 5 dan field komentar teks. Konsumen memberikan rating dan menulis komentar, kemudian mengklik tombol "Kirim Ulasan". Sistem menyimpan ulasan ke tabel shop_reviews dengan status "pending" dan menampilkan notifikasi bahwa ulasan berhasil dikirim serta menunggu persetujuan admin. Setelah admin menyetujui ulasan melalui panel admin, sistem mengubah status menjadi "approved" dan ulasan ditampilkan pada halaman detail produk untuk dapat dilihat konsumen lain.

---

## 14. Activity Diagram Logout

Gambar 14 merupakan Activity Diagram Logout yang menggambarkan alur aktivitas konsumen dalam mengakhiri sesi autentikasi pada sistem Gallery Puan. Proses dimulai ketika konsumen yang telah login mengklik tombol "Logout" yang tersedia pada menu navigasi atau dropdown profil.

Sistem kemudian menghapus sesi autentikasi konsumen sehingga tidak ada akses ke fitur-fitur yang memerlukan login. Setelah itu, sistem mengarahkan konsumen kembali ke halaman utama website. Proses ini penting untuk menjaga keamanan akun, terutama ketika konsumen menggunakan perangkat bersama atau publik.

---

## 15. Activity Diagram Login Admin

Gambar 15 merupakan Activity Diagram Login Admin yang menggambarkan alur aktivitas admin dalam melakukan autentikasi untuk mengakses panel administrasi pada sistem Gallery Puan. Proses dimulai ketika admin membuka halaman login admin pada URL `/admin`. Sistem menampilkan formulir login yang meminta email dan kata sandi akun admin.

Admin memasukkan kredensial dan mengklik tombol "Login". Sistem kemudian memvalidasi kredensial dengan data yang tersimpan pada tabel admins menggunakan guard autentikasi terpisah (auth:admin). Apabila kredensial benar, sistem membuat sesi autentikasi dan mengarahkan admin ke halaman dashboard. Apabila kredensial salah, sistem menampilkan pesan kesalahan dan admin dapat mengulangi proses login.

---

## 16. Activity Diagram Admin Kelola Kategori

Gambar 16 merupakan Activity Diagram Admin Kelola Kategori yang menggambarkan alur aktivitas admin dalam mengelola data kategori produk pada sistem Gallery Puan. Proses dimulai ketika admin membuka menu "Kategori" pada panel admin. Sistem menampilkan daftar kategori dalam bentuk hierarki parent-child.

Terdapat tiga sub-alur dalam activity diagram ini. Pertama, sub-alur Tambah Kategori: admin mengklik tombol "Tambah Kategori", sistem menampilkan form input yang berisi field nama kategori, slug, dan kategori induk, kemudian admin mengisi data dan sistem menyimpan kategori baru ke database. Kedua, sub-alur Edit Kategori: admin mengklik tombol edit pada kategori yang dipilih, sistem menampilkan form dengan data yang sudah ada, admin mengubah data, dan sistem memperbarui data kategori. Ketiga, sub-alur Hapus Kategori: admin mengklik tombol hapus, dan sistem menghapus kategori beserta relasi produk-kategori yang terkait.

---

## 17. Activity Diagram Admin Kelola Produk

Gambar 17 merupakan Activity Diagram Admin Kelola Produk yang menggambarkan alur aktivitas admin dalam mengelola data produk pada sistem Gallery Puan. Proses dimulai ketika admin membuka menu "Produk" pada panel admin. Sistem menampilkan daftar produk dengan paginasi, pencarian, dan filter.

Terdapat tiga sub-alur utama. Pertama, sub-alur Tambah Produk: admin mengisi form produk lengkap meliputi nama, SKU, slug, tipe produk, harga, harga diskon, berat, stok, status, kategori, deskripsi menggunakan TinyMCE, dan upload gambar, kemudian sistem menyimpan data dan gambar melalui Spatie Media Library. Kedua, sub-alur Edit Produk: admin mengubah data produk yang sudah ada, termasuk mengubah harga diskon. Apabila harga diskon diturunkan, sistem secara otomatis mendispatch job SendWishlistPriceDropEmail untuk memberitahu konsumen yang memiliki produk tersebut di wishlist. Ketiga, sub-alur Hapus Produk: admin menghapus produk beserta gambar dan seluruh relasi terkait.

---

## 18. Activity Diagram Admin Kelola Voucher

Gambar 18 merupakan Activity Diagram Admin Kelola Voucher yang menggambarkan alur aktivitas admin dalam mengelola kupon diskon pada sistem Gallery Puan. Proses dimulai ketika admin membuka menu "Kupon" pada panel admin. Sistem menampilkan daftar kupon yang tersedia beserta informasi seperti kode, tipe diskon, nilai, dan status.

Terdapat tiga sub-alur. Pertama, sub-alur Tambah Kupon: admin mengisi form yang mencakup kode kupon unik, tipe diskon (persentase atau nominal tetap), nilai diskon, minimum total belanja, kuota pemakaian, tanggal mulai dan berakhir masa berlaku, serta syarat khusus, kemudian sistem menyimpan ke database. Kedua, sub-alur Edit Kupon: admin mengubah data kupon yang sudah ada melalui form edit dan sistem memperbarui data. Ketiga, sub-alur Hapus Kupon: admin menghapus kupon yang tidak diperlukan dan sistem menghapus data dari database.

---

## 19. Activity Diagram Admin Mengelola Pesanan

Gambar 19 merupakan Activity Diagram Admin Mengelola Pesanan yang menggambarkan alur aktivitas admin dalam memproses pesanan konsumen melalui seluruh tahapan siklus hidup pesanan pada sistem Gallery Puan. Proses dimulai ketika admin membuka menu "Pesanan" pada panel admin. Sistem menampilkan daftar pesanan dengan filter berdasarkan status.

Terdapat empat sub-alur yang merepresentasikan tahapan pemrosesan pesanan. Pertama, Konfirmasi Pesanan: admin mengklik tombol "Konfirmasi" dan sistem mengubah status menjadi "confirmed". Kedua, Proses Pengemasan: admin mengklik tombol "Kemas" dan sistem mengubah status menjadi "packaging". Ketiga, Kirim Pesanan: admin memasukkan nomor resi dan mengklik "Kirim", sistem mengubah status menjadi "delivered", mengirim notifikasi database "Pesanan Dikirim" ke konsumen, dan jika nomor resi diisi, sistem juga mengirim email ShippingTrackingMail. Keempat, Batalkan Pesanan: admin mengklik "Batalkan", sistem mengubah status menjadi "cancelled" dan mengirim notifikasi ke konsumen.

---

## 20. Activity Diagram Admin Laporan Penjualan

Gambar 20 merupakan Activity Diagram Admin Laporan Penjualan yang menggambarkan alur aktivitas admin dalam melihat laporan penjualan pada sistem Gallery Puan. Proses dimulai ketika admin membuka menu "Laporan" pada panel admin. Sistem menampilkan halaman laporan yang berisi grafik penjualan menggunakan library ApexCharts, serta ringkasan data berupa total jumlah pesanan, total pendapatan, dan daftar produk terlaris.

Admin dapat memfilter laporan berdasarkan rentang tanggal tertentu untuk melihat data penjualan pada periode yang diinginkan. Setelah admin memilih rentang tanggal, sistem akan memperbarui tampilan grafik dan data ringkasan secara dinamis sesuai periode yang dipilih. Fitur ini membantu admin dalam memantau kinerja penjualan toko dan membuat keputusan bisnis yang lebih tepat.

---

## 21. Activity Diagram Admin Kelola Konten Homepage

Gambar 21 merupakan Activity Diagram Admin Kelola Konten Homepage yang menggambarkan alur aktivitas admin dalam memperbarui konten halaman utama website Gallery Puan tanpa harus mengubah kode program. Proses dimulai ketika admin membuka menu "Pengaturan" pada panel admin. Sistem memuat data settings dari database dengan memanfaatkan cache untuk mempercepat pemuatan, kemudian menampilkan form pengaturan yang terbagi menjadi lima bagian.

Lima bagian tersebut meliputi Identitas Website (logo dan favicon), Banner Utama (judul, subjudul, gambar latar), Bagian Promo (label, judul, deskripsi, gambar), Bagian Tentang Kami (judul, subjudul, cerita, gambar), dan Galeri Estetik. Admin dapat memperbarui konten teks secara langsung pada form atau mengunggah gambar baru. Untuk gambar, admin juga dapat memilih dari riwayat unggahan sebelumnya. Setelah admin mengklik "Simpan", sistem memproses perubahan: teks disimpan via Setting::setValue() ke tabel settings, gambar disimpan ke storage dan dicatat ke tabel settings serta setting_images untuk riwayat. Sistem kemudian menghapus cache untuk key yang diubah. Setelah perubahan disimpan, pengunjung yang membuka halaman utama website akan melihat konten yang telah diperbarui secara langsung.
