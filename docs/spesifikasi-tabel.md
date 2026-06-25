# Spesifikasi Tabel

Spesifikasi tabel database merupakan basis data dengan serangkaian tabel yang digunakan dalam menyimpan data mencakup atribut-atribut pada tabel untuk memperoleh data yang akan digunakan pada usulan rancangan sistem E-Commerce Gallery Puan. Tabel-tabel yang tersimpan pada basis data sistem, yaitu:

## 1. Tabel User

Tabel User merupakan tabel yang digunakan untuk menyimpan data pengguna sistem (pelanggan) yang melakukan registrasi, login, dan transaksi pada aplikasi Gallery Puan. Data yang tersimpan mencakup nama, email, dan password yang digunakan untuk autentikasi pengguna dalam mengakses fitur-fitur aplikasi. Tabel User memiliki spesifikasi dan atribut sebagai berikut:

**Tabel 1** Spesifikasi Tabel User

| No | Nama Atribut | Tipe Data | Range | Default | Key |
|----|-------------|-----------|-------|---------|-----|
| 1 | id | uuid | 36 | | Primary |
| 2 | name | varchar | 255 | | |
| 3 | email | varchar | 255 | | |
| 4 | email_verified_at | timestamp | | NULL | |
| 5 | password | varchar | 255 | | |
| 6 | remember_token | varchar | 100 | NULL | |
| 7 | created_at | timestamp | | NULL | |
| 8 | updated_at | timestamp | | NULL | |

## 2. Tabel Category

Tabel Category merupakan tabel yang digunakan untuk menyimpan data kategori produk yang bersifat hierarkis sehingga memungkinkan adanya sub-kategori di dalam suatu kategori induk. Data kategori digunakan untuk mengelompokkan produk sejenis dan memudahkan pengguna dalam melakukan pencarian serta filtering produk berdasarkan kategori. Tabel Category memiliki spesifikasi dan atribut sebagai berikut:

**Tabel 2** Spesifikasi Tabel Category

| No | Nama Atribut | Tipe Data | Range | Default | Key |
|----|-------------|-----------|-------|---------|-----|
| 1 | id | uuid | 36 | | Primary |
| 2 | parent_id | uuid | 36 | NULL | Foreign |
| 3 | slug | varchar | 255 | | |
| 4 | name | varchar | 255 | | |
| 5 | created_at | timestamp | | NULL | |
| 6 | updated_at | timestamp | | NULL | |

## 3. Tabel Product

Tabel Product merupakan tabel utama yang digunakan untuk menyimpan data produk yang dijual pada aplikasi Gallery Puan. Produk memiliki dua tipe yaitu CONFIGURABLE (produk induk yang memiliki varian) dan SIMPLE (produk varian warna). Setiap produk menyimpan informasi seperti SKU, harga, status stok, dan atribut varian warna dalam format JSON. Tabel Product memiliki spesifikasi dan atribut sebagai berikut:

**Tabel 3** Spesifikasi Tabel Product

| No | Nama Atribut | Tipe Data | Range | Default | Key |
|----|-------------|-----------|-------|---------|-----|
| 1 | id | uuid | 36 | | Primary |
| 2 | user_id | uuid | 36 | | Foreign |
| 3 | parent_id | uuid | 36 | NULL | Foreign |
| 4 | sku | varchar | 255 | | |
| 5 | type | varchar | 255 | | |
| 6 | name | varchar | 255 | | |
| 7 | slug | varchar | 255 | | |
| 8 | price | decimal | 15,2 | NULL | |
| 9 | sale_price | decimal | 15,2 | NULL | |
| 10 | status | varchar | 255 | | |
| 11 | stock_status | varchar | 255 | IN_STOCK | |
| 12 | manage_stock | boolean | | false | |
| 13 | weight | integer | 11 | 0 | |
| 14 | publish_date | datetime | | NULL | |
| 15 | excerpt | text | | NULL | |
| 16 | body | text | | NULL | |
| 17 | metas | json | | NULL | |
| 18 | featured_image | varchar | 255 | NULL | |
| 19 | views_count | bigint | 20 | 0 | |
| 20 | attributes | json | | NULL | |
| 21 | deleted_at | timestamp | | NULL | |
| 22 | created_at | timestamp | | NULL | |
| 23 | updated_at | timestamp | | NULL | |

## 4. Tabel ProductInventory

Tabel ProductInventory merupakan tabel yang digunakan untuk menyimpan data stok atau inventaris dari setiap produk. Data ini mencatat jumlah stok yang tersedia dan ambang batas stok rendah (low stock threshold) yang digunakan untuk memberikan peringatan ketika stok produk menipis. Tabel ProductInventory memiliki spesifikasi dan atribut sebagai berikut:

**Tabel 4** Spesifikasi Tabel ProductInventory

| No | Nama Atribut | Tipe Data | Range | Default | Key |
|----|-------------|-----------|-------|---------|-----|
| 1 | id | uuid | 36 | | Primary |
| 2 | product_id | uuid | 36 | | Foreign |
| 3 | qty | integer | 11 | NULL | |
| 4 | low_stock_threshold | integer | 11 | NULL | |
| 5 | created_at | timestamp | | NULL | |
| 6 | updated_at | timestamp | | NULL | |

## 5. Tabel ProductImage

Tabel ProductImage merupakan tabel yang digunakan untuk menyimpan data gambar atau foto dari suatu produk. Gambar produk ditampilkan pada halaman katalog dan detail produk menggunakan Spatie Media Library untuk mengelola file gambar dan konversi ukuran. Tabel ProductImage memiliki spesifikasi dan atribut sebagai berikut:

**Tabel 5** Spesifikasi Tabel ProductImage

| No | Nama Atribut | Tipe Data | Range | Default | Key |
|----|-------------|-----------|-------|---------|-----|
| 1 | id | uuid | 36 | | Primary |
| 2 | product_id | uuid | 36 | | Foreign |
| 3 | name | varchar | 255 | NULL | |
| 4 | created_at | timestamp | | NULL | |
| 5 | updated_at | timestamp | | NULL | |

## 6. Tabel Address

Tabel Address merupakan tabel yang digunakan untuk menyimpan data alamat pengiriman yang dimiliki oleh pengguna. Setiap pengguna dapat memiliki lebih dari satu alamat untuk fleksibilitas pengiriman pesanan dan dapat menetapkan salah satu alamat sebagai alamat utama (is_primary) yang akan digunakan secara default pada saat checkout. Tabel Address memiliki spesifikasi dan atribut sebagai berikut:

**Tabel 6** Spesifikasi Tabel Address

| No | Nama Atribut | Tipe Data | Range | Default | Key |
|----|-------------|-----------|-------|---------|-----|
| 1 | id | uuid | 36 | | Primary |
| 2 | user_id | uuid | 36 | | Foreign |
| 3 | is_primary | boolean | | false | |
| 4 | label | varchar | 255 | NULL | |
| 5 | first_name | varchar | 255 | | |
| 6 | last_name | varchar | 255 | | |
| 7 | address1 | varchar | 255 | NULL | |
| 8 | address2 | varchar | 255 | NULL | |
| 9 | phone | varchar | 255 | NULL | |
| 10 | email | varchar | 255 | NULL | |
| 11 | city | varchar | 255 | NULL | |
| 12 | city_id | integer | 11 | NULL | |
| 13 | province | varchar | 255 | NULL | |
| 14 | province_id | integer | 11 | NULL | |
| 15 | postcode | integer | 11 | NULL | |
| 16 | created_at | timestamp | | NULL | |
| 17 | updated_at | timestamp | | NULL | |

## 7. Tabel Cart

Tabel Cart merupakan tabel yang digunakan untuk menyimpan data keranjang belanja pengguna sebelum melakukan checkout. Keranjang menyimpan informasi total harga, diskon, pajak, berat total, dan kode voucher yang diterapkan. Setiap pengguna hanya memiliki satu keranjang aktif dalam satu waktu. Tabel Cart memiliki spesifikasi dan atribut sebagai berikut:

**Tabel 7** Spesifikasi Tabel Cart

| No | Nama Atribut | Tipe Data | Range | Default | Key |
|----|-------------|-----------|-------|---------|-----|
| 1 | id | uuid | 36 | | Primary |
| 2 | user_id | uuid | 36 | NULL | Foreign |
| 3 | expired_at | datetime | | | |
| 4 | base_total_price | decimal | 16,2 | 0 | |
| 5 | total_weight | integer | 11 | 0 | |
| 6 | tax_amount | decimal | 16,2 | 0 | |
| 7 | tax_percent | decimal | 16,2 | 0 | |
| 8 | discount_amount | decimal | 16,2 | 0 | |
| 9 | discount_percent | decimal | 16,2 | 0 | |
| 10 | grand_total | decimal | 16,2 | 0 | |
| 11 | voucher_code | varchar | 255 | NULL | |
| 12 | deleted_at | timestamp | | NULL | |
| 13 | created_at | timestamp | | NULL | |
| 14 | updated_at | timestamp | | NULL | |

## 8. Tabel CartItem

Tabel CartItem merupakan tabel yang digunakan untuk menyimpan data item atau produk yang terdapat di dalam keranjang belanja pengguna. Setiap item mencatat produk yang dipilih, kuantitas, dan atribut varian warna (dalam format JSON) yang dipilih oleh pengguna pada saat menambahkan produk ke keranjang. Tabel CartItem memiliki spesifikasi dan atribut sebagai berikut:

**Tabel 8** Spesifikasi Tabel CartItem

| No | Nama Atribut | Tipe Data | Range | Default | Key |
|----|-------------|-----------|-------|---------|-----|
| 1 | id | uuid | 36 | | Primary |
| 2 | cart_id | uuid | 36 | | Foreign |
| 3 | product_id | uuid | 36 | | Foreign |
| 4 | qty | integer | 11 | | |
| 5 | attributes | json | | NULL | |
| 6 | created_at | timestamp | | NULL | |
| 7 | updated_at | timestamp | | NULL | |

## 9. Tabel Order

Tabel Order merupakan tabel utama yang digunakan untuk menyimpan data pesanan yang dibuat oleh pengguna setelah menyelesaikan proses checkout. Pesanan menyimpan informasi lengkap seperti kode unik pesanan, status pesanan, status pembayaran, data kurir pengiriman, rincian harga, kode voucher yang digunakan, dan data alamat pengiriman customer. Tabel Order memiliki spesifikasi dan atribut sebagai berikut:

**Tabel 9** Spesifikasi Tabel Order

| No | Nama Atribut | Tipe Data | Range | Default | Key |
|----|-------------|-----------|-------|---------|-----|
| 1 | id | uuid | 36 | | Primary |
| 2 | user_id | uuid | 36 | | Foreign |
| 3 | code | varchar | 255 | | |
| 4 | status | varchar | 255 | | |
| 5 | payment_status | varchar | 255 | NULL | |
| 6 | shipping_courier | varchar | 255 | NULL | |
| 7 | shipping_service_name | varchar | 100 | NULL | |
| 8 | shipping_number | varchar | 255 | NULL | |
| 9 | approved_by | uuid | 36 | NULL | Foreign |
| 10 | approved_at | datetime | | NULL | |
| 11 | cancelled_by | uuid | 36 | NULL | Foreign |
| 12 | cancelled_at | datetime | | NULL | |
| 13 | cancellation_note | text | | NULL | |
| 14 | order_date | datetime | | | |
| 15 | payment_due | datetime | | | |
| 16 | base_total_price | decimal | 16,2 | 0 | |
| 17 | tax_amount | decimal | 16,2 | 0 | |
| 18 | tax_percent | decimal | 16,2 | 0 | |
| 19 | discount_amount | decimal | 16,2 | 0 | |
| 20 | discount_percent | decimal | 16,2 | 0 | |
| 21 | shipping_cost | decimal | 16,2 | 0 | |
| 22 | grand_total | decimal | 16,2 | 0 | |
| 23 | voucher_code | varchar | 255 | NULL | |
| 24 | customer_note | text | | NULL | |
| 25 | customer_first_name | varchar | 255 | | |
| 26 | customer_last_name | varchar | 255 | | |
| 27 | customer_address1 | varchar | 255 | NULL | |
| 28 | customer_address2 | varchar | 255 | NULL | |
| 29 | customer_phone | varchar | 255 | NULL | |
| 30 | customer_email | varchar | 255 | NULL | |
| 31 | customer_city | varchar | 255 | NULL | |
| 32 | customer_province | varchar | 255 | NULL | |
| 33 | customer_postcode | integer | 11 | NULL | |
| 34 | deleted_at | timestamp | | NULL | |
| 35 | created_at | timestamp | | NULL | |
| 36 | updated_at | timestamp | | NULL | |

## 10. Tabel OrderItem

Tabel OrderItem merupakan tabel yang digunakan untuk menyimpan data item atau produk yang terdapat di dalam suatu pesanan sebagai snapshot transaksi. Data yang tersimpan merupakan rekaman tetap (permanent record) dari harga satuan, diskon, pajak, subtotal, SKU, tipe, nama produk, dan atribut varian warna pada saat transaksi dilakukan sehingga data tetap akurat meskipun harga produk berubah di kemudian hari. Tabel OrderItem memiliki spesifikasi dan atribut sebagai berikut:

**Tabel 10** Spesifikasi Tabel OrderItem

| No | Nama Atribut | Tipe Data | Range | Default | Key |
|----|-------------|-----------|-------|---------|-----|
| 1 | id | uuid | 36 | | Primary |
| 2 | order_id | uuid | 36 | | Foreign |
| 3 | product_id | uuid | 36 | | Foreign |
| 4 | qty | integer | 11 | | |
| 5 | base_price | decimal | 16,2 | 0 | |
| 6 | base_total | decimal | 16,2 | 0 | |
| 7 | tax_amount | decimal | 16,2 | 0 | |
| 8 | tax_percent | decimal | 16,2 | 0 | |
| 9 | discount_amount | decimal | 16,2 | 0 | |
| 10 | discount_percent | decimal | 16,2 | 0 | |
| 11 | sub_total | decimal | 16,2 | 0 | |
| 12 | sku | varchar | 255 | | |
| 13 | type | varchar | 255 | | |
| 14 | name | varchar | 255 | | |
| 15 | attributes | json | | | |
| 16 | created_at | timestamp | | NULL | |
| 17 | updated_at | timestamp | | NULL | |

## 11. Tabel Payment

Tabel Payment merupakan tabel yang digunakan untuk menyimpan data pembayaran pesanan yang terintegrasi dengan payment gateway Midtrans. Setiap pembayaran mencatat metode pembayaran, status, jumlah nominal, serta informasi persetujuan atau penolakan pembayaran oleh admin. Data payload dari Midtrans disimpan dalam format JSON untuk keperluan rekonsiliasi. Tabel Payment memiliki spesifikasi dan atribut sebagai berikut:

**Tabel 11** Spesifikasi Tabel Payment

| No | Nama Atribut | Tipe Data | Range | Default | Key |
|----|-------------|-----------|-------|---------|-----|
| 1 | id | uuid | 36 | | Primary |
| 2 | user_id | uuid | 36 | | Foreign |
| 3 | order_id | uuid | 36 | | Foreign |
| 4 | payment_type | varchar | 255 | | |
| 5 | status | varchar | 255 | | |
| 6 | approved_by | uuid | 36 | NULL | |
| 7 | approved_at | datetime | | NULL | |
| 8 | note | text | | NULL | |
| 9 | rejected_by | uuid | 36 | NULL | |
| 10 | rejected_at | datetime | | NULL | |
| 11 | rejection_note | text | | NULL | |
| 12 | amount | decimal | 16,2 | 0 | |
| 13 | payloads | json | | NULL | |
| 14 | deleted_at | timestamp | | NULL | |
| 15 | created_at | timestamp | | NULL | |
| 16 | updated_at | timestamp | | NULL | |

## 12. Tabel Voucher

Tabel Voucher merupakan tabel yang digunakan untuk menyimpan data kode promo atau diskon yang dapat digunakan pengguna untuk mendapatkan potongan harga pada saat berbelanja. Voucher memiliki dua tipe diskon yaitu fixed (nominal tetap) dan percent (persentase), serta dilengkapi dengan syarat penggunaan seperti minimal total belanja, khusus pelanggan baru, atau berdasarkan jumlah pesanan yang telah dilakukan. Tabel Voucher memiliki spesifikasi dan atribut sebagai berikut:

**Tabel 12** Spesifikasi Tabel Voucher

| No | Nama Atribut | Tipe Data | Range | Default | Key |
|----|-------------|-----------|-------|---------|-----|
| 1 | id | uuid | 36 | | Primary |
| 2 | code | varchar | 255 | | |
| 3 | description | varchar | 255 | NULL | |
| 4 | type | enum | fixed,percent | fixed | |
| 5 | value | decimal | 15,2 | | |
| 6 | min_total | decimal | 15,2 | 0 | |
| 7 | is_first_order_only | boolean | | false | |
| 8 | min_order_count | integer | 11 | 0 | |
| 9 | is_active | boolean | | true | |
| 10 | expired_at | date | | NULL | |
| 11 | created_at | timestamp | | NULL | |
| 12 | updated_at | timestamp | | NULL | |

## 13. Tabel Wishlist

Tabel Wishlist merupakan tabel yang digunakan untuk menyimpan data daftar favorit atau wishlist pengguna terhadap produk yang diminati. Pengguna dapat menambahkan produk ke dalam wishlist untuk dibeli di lain waktu tanpa harus langsung memasukkan ke keranjang belanja. Tabel Wishlist memiliki spesifikasi dan atribut sebagai berikut:

**Tabel 13** Spesifikasi Tabel Wishlist

| No | Nama Atribut | Tipe Data | Range | Default | Key |
|----|-------------|-----------|-------|---------|-----|
| 1 | id | bigint | 20 | | Primary |
| 2 | user_id | char | 36 | | Foreign |
| 3 | product_id | char | 36 | | Foreign |
| 4 | created_at | timestamp | | NULL | |
| 5 | updated_at | timestamp | | NULL | |

## 14. Tabel Review

Tabel Review merupakan tabel yang digunakan untuk menyimpan data ulasan atau penilaian yang diberikan pengguna terhadap produk yang telah dibeli. Setiap ulasan terkait dengan satu pesanan tertentu untuk memvalidasi bahwa pengguna benar-benar telah membeli produk tersebut, sehingga menjaga kredibilitas ulasan yang ditampilkan. Tabel Review memiliki spesifikasi dan atribut sebagai berikut:

**Tabel 14** Spesifikasi Tabel Review

| No | Nama Atribut | Tipe Data | Range | Default | Key |
|----|-------------|-----------|-------|---------|-----|
| 1 | id | bigint | 20 | | Primary |
| 2 | user_id | char | 36 | | Foreign |
| 3 | product_id | char | 36 | | Foreign |
| 4 | order_id | char | 36 | | Foreign |
| 5 | rating | tinyint | 4 | 5 | |
| 6 | comment | text | | NULL | |
| 7 | status | varchar | 255 | approved | |
| 8 | created_at | timestamp | | NULL | |
| 9 | updated_at | timestamp | | NULL | |

## 15. Tabel CategoryProduct

Tabel CategoryProduct merupakan tabel pivot yang digunakan untuk menyimpan relasi banyak ke banyak (many-to-many) antara kategori dan produk. Satu kategori dapat menaungi banyak produk, dan satu produk dapat masuk ke dalam banyak kategori sekaligus. Tabel CategoryProduct memiliki spesifikasi dan atribut sebagai berikut:

**Tabel 15** Spesifikasi Tabel CategoryProduct

| No | Nama Atribut | Tipe Data | Range | Default | Key |
|----|-------------|-----------|-------|---------|-----|
| 1 | product_id | uuid | 36 | | Foreign |
| 2 | category_id | uuid | 36 | | Foreign |

Berdasarkan spesifikasi tabel di atas, sistem E-Commerce Gallery Puan memiliki **lima belas tabel** yang saling berelasi dan mencakup seluruh kebutuhan data untuk proses bisnis e-commerce mulai dari manajemen pengguna, produk, keranjang belanja, pesanan, pembayaran, voucher diskon, wishlist, hingga ulasan produk.
