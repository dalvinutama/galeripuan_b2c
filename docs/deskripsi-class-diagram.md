# Deskripsi Class Diagram Sistem E-Commerce Gallery Puan

## A. Kelas Inti (Core System)

### 1. User
Kelas *User* merepresentasikan entitas pengguna yang berinteraksi dengan sistem e-commerce Gallery Puan, khususnya pelanggan yang melakukan transaksi belanja. Setiap *User* memiliki atribut berupa *id* (UUID sebagai *primary key*), *name* (nama lengkap pengguna), dan *email* (alamat email yang digunakan sebagai identitas *login*). Kelas ini dilengkapi dengan metode *login()* yang berfungsi memvalidasi kredensial pengguna dan memulai sesi, *register()* untuk mendaftarkan akun baru ke dalam sistem, *perbaruiProfil()* yang memungkinkan pengguna memperbarui data profilnya, serta *logout()* untuk mengakhiri sesi. Dalam arsitektur sistem, *User* bertindak sebagai entitas sentral yang memiliki relasi satu ke banyak dengan *Address* (satu pengguna dapat memiliki banyak alamat pengiriman), *Cart* (satu pengguna memiliki satu keranjang aktif dalam satu waktu), *Order* (satu pengguna dapat melakukan banyak pesanan), *Review* (satu pengguna dapat memberikan banyak ulasan terhadap produk), *Wishlist* (satu pengguna dapat menyimpan banyak produk ke dalam daftar favorit), dan *Product* (satu pengguna sebagai penjual/ admin dapat mengelola banyak produk). Relasi-relasi ini menunjukkan bahwa *User* merupakan entitas utama yang menggerakkan seluruh aktivitas dalam sistem e-commerce.

### 2. Address
Kelas *Address* merepresentasikan alamat pengiriman yang dimiliki oleh pengguna untuk keperluan pengiriman pesanan. Setiap alamat memiliki atribut *id* (UUID/*primary key*), *user_id* (*foreign key* yang menghubungkan ke *User*), *label* (penanda seperti Rumah atau Kantor), *first_name* dan *last_name* (nama penerima paket), *phone* (nomor telepon penerima), *email* (alamat email penerima), *address1* dan *address2* (detail alamat), *city* (kota tujuan), *province* (provinsi), *postcode* (kode pos), serta *is_primary* (penanda apakah alamat tersebut merupakan alamat utama pengguna). Metode *jadikanUtama()* memungkinkan pengguna menetapkan salah satu alamatnya sebagai alamat utama yang akan digunakan secara *default* pada saat *checkout*. Relasi kelas *Address* terhadap *User* bersifat satu ke banyak, yang berarti satu pengguna dapat memiliki lebih dari satu alamat pengiriman untuk fleksibilitas pengiriman pesanan.

---

## B. Kelas Katalog Produk (Product Catalog)

### 3. Category
Kelas *Category* merepresentasikan kategori atau pengelompokan produk dalam sistem. Setiap kategori memiliki atribut *id* (UUID/*primary key*), *parent_id* (*foreign key* *self-referencing* yang menghubungkan suatu kategori dengan kategori induknya), *name* (nama kategori), dan *slug* (representasi URL yang *friendly* untuk SEO). Struktur hierarkis melalui *parent_id* memungkinkan terbentuknya sub-kategori, misalnya kategori "Batik" sebagai induk dari sub-kategori "Batik Tulis" dan "Batik Cap". Metode *ambilProduk()* berfungsi untuk mengambil seluruh produk yang termasuk dalam suatu kategori. Relasi antara *Category* dan *Product* bersifat banyak ke banyak (*many-to-many*), yang diimplementasikan melalui tabel pivot *shop_categories_products*, sehingga satu kategori dapat menaungi banyak produk dan satu produk dapat masuk ke dalam banyak kategori sekaligus.

### 4. Product
Kelas *Product* merupakan kelas utama yang merepresentasikan produk yang dijual dalam sistem e-commerce Gallery Puan. Produk memiliki dua tipe yang dibedakan melalui atribut *type*, yaitu CONFIGURABLE (produk induk yang memiliki varian) dan SIMPLE (produk tunggal atau varian anak). Atribut *parent_id* berfungsi sebagai *foreign key* *self-referencing* yang menghubungkan produk varian (SIMPLE) dengan produk induknya (CONFIGURABLE), sehingga memungkinkan implementasi fitur varian warna tanpa memerlukan tabel terpisah. Atribut *attributes* bertipe JSON menyimpan data varian seperti kode warna, nama warna, dan kode hex warna. Setiap produk memiliki atribut *sku* (identifikasi stok), *name* (nama produk), *price* (harga normal), *sale_price* (harga diskon), *status* (status publikasi: DRAFT, ACTIVE, INACTIVE), dan *stock_status* (status ketersediaan stok: IN_STOCK, OUT_OF_STOCK). Metode *cekKetersediaanStok()* memvalidasi apakah jumlah stok mencukupi untuk kuantitas tertentu, sedangkan *ambilVarian()* mengembalikan daftar varian warna yang dimiliki produk CONFIGURABLE. Relasi *Product* terhadap *Category* bersifat banyak ke banyak, terhadap *ProductInventory* satu ke satu, terhadap *ProductImage* satu ke banyak, terhadap sesama *Product* (varian) satu ke banyak, serta terhadap *CartItem*, *OrderItem*, *Review*, dan *Wishlist* masing-masing satu ke banyak.

### 5. ProductInventory
Kelas *ProductInventory* merepresentasikan data stok atau inventaris dari suatu produk. Setiap produk memiliki satu data inventaris yang mencatat atribut *id* (UUID/*primary key*), *product_id* (*foreign key* ke *Product*), dan *qty* (jumlah stok yang tersedia). Kelas ini dilengkapi dengan metode *kurangiStok()* yang mengurangi jumlah stok ketika terjadi pembelian dan *tambahStok()* untuk menambahkan stok ketika ada pengisian ulang. Relasi antara *ProductInventory* dan *Product* bersifat satu ke satu, yang berarti setiap produk hanya memiliki satu data inventaris, dan satu data inventaris hanya dimiliki oleh satu produk. Pemisahan data stok ke dalam kelas tersendiri memungkinkan pengelolaan inventaris yang lebih terstruktur dan terpisah dari data utama produk.

### 6. ProductImage
Kelas *ProductImage* merepresentasikan gambar atau foto dari suatu produk yang ditampilkan di halaman katalog dan detail produk. Setiap gambar memiliki atribut *id* (UUID/*primary key*), *product_id* (*foreign key* ke *Product*), dan *name* (nama file gambar). Implementasi kelas ini menggunakan Spatie Media Library untuk mengelola file gambar, yang mencakup konversi otomatis ke berbagai ukuran seperti *thumbnail*, *medium*, dan *large* untuk optimalisasi tampilan di berbagai perangkat. Metode *dapatkanUrlGambar()* berfungsi untuk menghasilkan URL gambar yang siap ditampilkan di *frontend*. Relasi *ProductImage* terhadap *Product* bersifat satu ke banyak, sehingga satu produk dapat memiliki lebih dari satu gambar dari berbagai sudut atau varian.

---

## C. Kelas Keranjang dan Wishlist (Shopping Cart & Wishlist)

### 7. Cart
Kelas *Cart* merepresentasikan keranjang belanja yang digunakan pengguna untuk mengumpulkan produk sebelum melakukan *checkout*. Setiap keranjang memiliki atribut *id* (UUID/*primary key*), *user_id* (*foreign key* ke *User*), *grand_total* (total pembayaran setelah memperhitungkan diskon produk dan voucher), serta *voucher_code* (kode voucher yang sedang diterapkan pada keranjang). Kelas ini memiliki metode *tambahItem()* untuk menambahkan produk beserta varian warna yang dipilih ke dalam keranjang, *hapusItem()* untuk menghapus item dari keranjang, *perbaruiKuantitas()* untuk mengubah jumlah item, *hitungTotalKeranjang()* untuk menghitung ulang total belanja dengan mempertimbangkan *sale_price* produk dan diskon voucher, *terapkanVoucher()* untuk memvalidasi dan menerapkan kode voucher, *hapusVoucher()* untuk membatalkan penerapan voucher, serta *clearCart()* untuk mengosongkan seluruh isi keranjang. Proses perhitungan total keranjang dilakukan secara terintegrasi antara diskon produk (melalui *sale_price*) dan diskon voucher, sehingga tidak saling menimpa. Relasi *Cart* terhadap *User* bersifat satu ke banyak, terhadap *CartItem* satu ke banyak, dan terhadap *Voucher* melalui *voucher_code* bersifat banyak ke satu.

### 8. CartItem
Kelas *CartItem* merepresentasikan setiap item atau baris produk yang terdapat dalam keranjang belanja. Setiap item memiliki atribut *id* (UUID/*primary key*), *cart_id* (*foreign key* ke *Cart*), *product_id* (*foreign key* ke *Product*), *qty* (kuantitas produk yang dipesan), dan *attributes* (data JSON yang menyimpan informasi varian yang dipilih, seperti warna produk). Metode *perbaruiKuantitas()* memungkinkan perubahan jumlah item secara langsung. Atribut *attributes* dalam format JSON menjadi kunci utama dalam implementasi fitur varian warna, karena menyimpan data seperti kode warna dan nama warna yang dipilih pengguna tanpa memerlukan tabel relasi terpisah. Relasi *CartItem* terhadap *Cart* bersifat banyak ke satu, yang berarti setiap item pasti berada dalam satu keranjang tertentu, dan terhadap *Product* bersifat banyak ke satu, yang berarti satu produk dapat muncul di berbagai keranjang pengguna yang berbeda.

### 9. Wishlist
Kelas *Wishlist* merepresentasikan daftar favorit atau *wishlist* pengguna, tempat pengguna dapat menyimpan produk yang diminati untuk dibeli di lain waktu. Setiap *entry wishlist* memiliki atribut *id* (*bigint* sebagai *primary key*), *user_id* (*foreign key* ke *User*), dan *product_id* (*foreign key* ke *Product*). Metode *ubahStatusWishlist()* berfungsi untuk menambahkan atau menghapus produk dari *wishlist* (bersifat *toggle*). Relasi *Wishlist* terhadap *User* bersifat satu ke banyak, yang berarti satu pengguna dapat memiliki banyak produk dalam *wishlist*-nya, dan terhadap *Product* juga satu ke banyak, yang berarti satu produk dapat dimasukkan ke dalam *wishlist* oleh banyak pengguna. Kelas ini menggunakan *bigint* sebagai tipe data *primary key* karena sifatnya sebagai tabel *auxiliary* yang tidak memerlukan UUID.

### 10. Review
Kelas *Review* merepresentasikan ulasan atau penilaian yang diberikan pengguna terhadap produk yang telah dibeli. Setiap ulasan memiliki atribut *id* (*bigint* sebagai *primary key*), *user_id* (*foreign key* ke *User*), *product_id* (*foreign key* ke *Product*), *order_id* (*foreign key* ke *Order*), *rating* (nilai penilaian dalam skala 1 hingga 5), *comment* (teks ulasan), dan *status* (status ulasan, misalnya DISETUJUI atau MENUNGGU). Metode *simpanUlasan()* berfungsi untuk menyimpan ulasan baru ke dalam sistem. Relasi *Review* terhadap *User*, *Product*, dan *Order* masing-masing bersifat satu ke banyak. Penggunaan *order_id* memastikan bahwa hanya pengguna yang benar-benar telah membeli produk yang dapat memberikan ulasan, sehingga menjaga kredibilitas dan keaslian ulasan yang ditampilkan di halaman produk.

---

## D. Kelas Sistem Pesanan (Ordering System)

### 11. Order
Kelas *Order* merepresentasikan pesanan yang dibuat oleh pengguna setelah menyelesaikan proses *checkout*. Setiap pesanan memiliki atribut *id* (UUID/*primary key*), *user_id* (*foreign key* ke *User*), *code* (kode unik pesanan dengan format ORDER/YYYY/MM/DD/XXXXX yang dihasilkan secara otomatis), *status* (status pesanan: PENDING, CONFIRMED, PACKAGING, DELIVERED, RECEIVED, CANCELLED, atau RETURNED), *payment_status* (status pembayaran), *shipping_courier* (nama kurir pengiriman), *shipping_number* (nomor resi pengiriman), *grand_total* (total pembayaran), dan *voucher_code* (kode voucher yang digunakan pada saat transaksi). Kelas ini memiliki metode *checkout()* yang mengonversi item keranjang menjadi pesanan baru, *prosesPembayaran()* yang menangani integrasi dengan *payment gateway* Midtrans, *perbaruiStatus()* untuk memperbarui status pesanan, *batalkanPesanan()* untuk membatalkan pesanan, dan *selesaikanPesanan()* untuk menandai pesanan sebagai selesai diterima. Relasi *Order* terhadap *User* bersifat satu ke banyak, terhadap *OrderItem* satu ke banyak, terhadap *Payment* satu ke satu, dan terhadap *Voucher* melalui *voucher_code* bersifat banyak ke satu.

### 12. OrderItem
Kelas *OrderItem* merepresentasikan setiap item atau baris produk yang terdapat dalam suatu pesanan. Struktur kelas ini mirip dengan *CartItem*, namun berfungsi sebagai *snapshot* atau rekaman tetap (*permanent record*) dari transaksi yang telah terjadi. Setiap item pesanan memiliki atribut *id* (UUID/*primary key*), *order_id* (*foreign key* ke *Order*), *product_id* (*foreign key* ke *Product*), *qty* (kuantitas produk yang dibeli), *base_price* (harga satuan produk pada saat transaksi, bukan harga terkini), *sub_total* (total harga untuk item tersebut), dan *attributes* (data JSON yang menyimpan informasi varian yang dipilih saat transaksi, seperti warna). Metode *hitungSubtotal()* berfungsi untuk menghitung nilai *sub_total* berdasarkan *base_price* dan *qty*. Atribut *base_price* dan *attributes* bersifat *immutable* setelah pesanan dibuat, sehingga data transaksi tetap akurat meskipun harga atau stok produk berubah di kemudian hari. Relasi *OrderItem* terhadap *Order* bersifat banyak ke satu dan terhadap *Product* bersifat banyak ke satu.

### 13. Payment
Kelas *Payment* merepresentasikan data pembayaran yang dilakukan pengguna untuk menyelesaikan suatu pesanan. Setiap pembayaran memiliki atribut *id* (UUID/*primary key*), *order_id* (*foreign key* ke *Order*), *user_id* (*foreign key* ke *User*), *payment_type* (metode pembayaran yang digunakan, seperti *bank transfer*, *credit card*, atau *e-wallet*), *status* (status pembayaran), dan *amount* (jumlah nominal yang dibayarkan). Sistem terintegrasi dengan Midtrans sebagai *payment gateway* untuk memproses transaksi pembayaran secara *real-time*. Relasi *Payment* terhadap *Order* bersifat satu ke satu, yang berarti setiap pesanan hanya memiliki satu pembayaran yang valid. Pemilihan relasi satu ke satu didasarkan pada alur *checkout* di mana pengguna diarahkan untuk melakukan pembayaran tunggal setelah pesanan berhasil dibuat, dan jika pembayaran gagal maka pengguna akan membuat pesanan baru, bukan melakukan pembayaran ulang pada pesanan yang sama.

---

## E. Kelas Voucher

### 14. Voucher
Kelas *Voucher* merepresentasikan kode promo atau diskon yang dapat digunakan pengguna untuk mendapatkan potongan harga pada saat berbelanja. Setiap voucher memiliki atribut *id* (UUID/*primary key*), *code* (kode unik voucher yang dimasukkan pengguna pada halaman *checkout*), *type* (tipe diskon: *fixed* untuk diskon nominal tetap atau *percent* untuk diskon persentase), *value* (nilai diskon), *min_total* (minimal total belanja agar voucher dapat digunakan), *is_active* (status aktif atau tidaknya voucher), *is_first_order_only* (penanda apakah voucher hanya berlaku untuk pesanan pertama pengguna), *min_order_count* (batas minimal jumlah pesanan yang telah dilakukan pengguna agar voucher berlaku), dan *expired_at* (tanggal kedaluwarsa voucher). Metode *cekValiditas()* berfungsi memvalidasi apakah voucher memenuhi seluruh syarat penggunaan berdasarkan kondisi keranjang dan riwayat pesanan pengguna. Metode *hitungDiskon()* menghitung besaran diskon yang diperoleh berdasarkan tipe voucher dan total belanja. Relasi *Voucher* terhadap *Cart* melalui *voucher_code* bersifat satu ke banyak (satu voucher dapat diterapkan di banyak keranjang), dan terhadap *Order* juga satu ke banyak (satu voucher dapat digunakan di banyak pesanan). Relasi ini bersifat *loose* karena *voucher_code* disimpan sebagai string biasa (*plain VARCHAR*) tanpa *foreign key* di tingkat basis data, dan validasi dilakukan sepenuhnya di tingkat aplikasi.

---

## F. Relasi Antar Kelas

Berikut adalah daftar lengkap relasi antar kelas dalam sistem yang merepresentasikan hubungan struktural antar entitas:

| No | Relasi | Tipe | Deskripsi |
|----|--------|------|-----------|
| 1 | User → Address | 1 to Many | Satu pengguna dapat memiliki banyak alamat pengiriman |
| 2 | User → Cart | 1 to Many | Satu pengguna dapat memiliki satu keranjang aktif |
| 3 | User → Order | 1 to Many | Satu pengguna dapat melakukan banyak pesanan |
| 4 | User → Review | 1 to Many | Satu pengguna dapat memberikan banyak ulasan |
| 5 | User → Wishlist | 1 to Many | Satu pengguna dapat memiliki banyak *wishlist* |
| 6 | User → Product | 1 to Many | Satu pengguna (sebagai admin/penjual) dapat mengelola banyak produk |
| 7 | Category → Category | 1 to Many | *Self-referencing* untuk mendukung sub-kategori |
| 8 | Category → Product | Many to Many | Satu kategori menaungi banyak produk, satu produk masuk banyak kategori |
| 9 | Product → ProductInventory | 1 to 1 | Satu produk memiliki satu data stok |
| 10 | Product → ProductImage | 1 to Many | Satu produk memiliki banyak gambar |
| 11 | Product → Product (parent_id) | 1 to Many | *Self-referencing* untuk varian warna |
| 12 | Product → CartItem | 1 to Many | Satu produk dapat muncul di banyak keranjang |
| 13 | Product → OrderItem | 1 to Many | Satu produk dapat muncul di banyak pesanan |
| 14 | Product → Review | 1 to Many | Satu produk dapat memiliki banyak ulasan |
| 15 | Product → Wishlist | 1 to Many | Satu produk dapat dimasukkan ke banyak *wishlist* |
| 16 | Cart → CartItem | 1 to Many | Satu keranjang memiliki banyak item |
| 17 | Order → OrderItem | 1 to Many | Satu pesanan memiliki banyak item |
| 18 | Order → Payment | 1 to 1 | Satu pesanan memiliki satu pembayaran |
| 19 | Voucher → Cart | 1 to Many | Satu voucher dapat diterapkan di banyak keranjang |
| 20 | Voucher → Order | 1 to Many | Satu voucher dapat digunakan di banyak pesanan |

--- 

*Dokumen ini disusun berdasarkan class diagram sistem E-Commerce Gallery Puan yang terdiri dari 14 kelas dan 20 relasi, mencakup modul inti sistem, katalog produk, keranjang belanja, wishlist, ulasan, sistem pesanan, dan voucher diskon.*
