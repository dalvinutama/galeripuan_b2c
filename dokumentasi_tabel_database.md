# Dokumentasi Tabel Database — Gallery Puan

**Database:** `gallery-puandb`  
**Total tabel:** 27  
**Engine:** InnoDB  
**Charset:** utf8mb4 (utf8mb4_unicode_ci)

---

## A. Tabel Aplikasi Inti (12 tabel)

---

### 1. `users`

Data pelanggan (front-end).

| Kolom | Tipe | Length | Null | Default | Key | Keterangan |
|-------|------|--------|------|---------|-----|-----------|
| id | char | 36 | NO | — | PRI | UUID (UUID4 via UuidTrait) |
| name | varchar | 100 | NO | — | | Nama pelanggan |
| email | varchar | 100 | NO | — | UNI | Email login |
| email_verified_at | timestamp | — | YES | NULL | | Waktu verifikasi email |
| password | varchar | 100 | NO | — | | Password bcrypt |
| remember_token | varchar | 100 | YES | NULL | | Token "remember me" |
| created_at | timestamp | — | YES | NULL | | Waktu dibuat |
| updated_at | timestamp | — | YES | NULL | | Waktu diubah |

---

### 2. `admins`

Data administrator (panel admin).

| Kolom | Tipe | Length | Null | Default | Key | Keterangan |
|-------|------|--------|------|---------|-----|-----------|
| id | bigint unsigned | 20 | NO | — | PRI | Auto increment |
| name | varchar | 100 | NO | — | | Nama admin |
| email | varchar | 100 | NO | — | UNI | Email login |
| password | varchar | 100 | NO | — | | Password bcrypt |
| is_owner | tinyint | 1 | NO | 0 | | Flag super-admin (1=owner) |
| created_at | timestamp | — | YES | NULL | | Waktu dibuat |
| updated_at | timestamp | — | YES | NULL | | Waktu diubah |
| last_activity | timestamp | — | YES | NULL | | Waktu aktivitas terakhir (fitur chat) |

---

### 3. `conversations`

Data percakapan chat antar pelanggan dan admin.

| Kolom | Tipe | Length | Null | Default | Key | Keterangan |
|-------|------|--------|------|---------|-----|-----------|
| id | bigint unsigned | 20 | NO | — | PRI | Auto increment |
| uuid | varchar | 36 | NO | — | UNI | UUID unik per percakapan |
| user_id | varchar | 36 | YES | NULL | MUL | Foreign key ke `users.id` (nullable untuk guest) |
| created_at | timestamp | — | YES | NULL | | Waktu dibuat |
| updated_at | timestamp | — | YES | NULL | | Waktu diubah |

---

### 4. `messages`

Data pesan dalam percakapan chat.

| Kolom | Tipe | Length | Null | Default | Key | Keterangan |
|-------|------|--------|------|---------|-----|-----------|
| id | bigint unsigned | 20 | NO | — | PRI | Auto increment |
| conversation_id | bigint unsigned | 20 | NO | — | MUL | Foreign key ke `conversations.id` |
| sender_id | varchar | 36 | YES | NULL | | UUID pengirim (user/admin) |
| is_admin | tinyint | 1 | NO | 0 | | 0=dari customer, 1=dari admin |
| body | text | — | NO | — | | Isi pesan (atau JSON untuk suggested_options) |
| type | varchar | 50 | NO | 'text' | | Jenis: text, image, suggested_options |
| image | varchar | 200 | YES | NULL | | Path gambar (jika type=image) |
| is_read | tinyint | 1 | NO | 0 | | Status centang biru (dibaca) |
| is_delivered | tinyint | 1 | NO | 0 | | Status centang abu-abu ganda (terkirim) |
| created_at | timestamp | — | YES | NULL | | Waktu dibuat |
| updated_at | timestamp | — | YES | NULL | | Waktu diubah |

---

### 5. `settings`

Penyimpanan key-value untuk konfigurasi sistem dan chat.

| Kolom | Tipe | Length | Null | Default | Key | Keterangan |
|-------|------|--------|------|---------|-----|-----------|
| id | bigint unsigned | 20 | NO | — | PRI | Auto increment |
| key | varchar | 100 | NO | — | UNI | Nama key (misal chat_auto_greeting, chat_auto_ack) |
| value | text | — | YES | NULL | | Nilai konfigurasi |
| type | varchar | 20 | NO | 'text' | | Tipe: text, textarea, image, boolean |
| created_at | timestamp | — | YES | NULL | | Waktu dibuat |
| updated_at | timestamp | — | YES | NULL | | Waktu diubah |

---

### 6. `setting_images`

Data gambar untuk pengaturan tertentu (misal logo, favicon).

| Kolom | Tipe | Length | Null | Default | Key | Keterangan |
|-------|------|--------|------|---------|-----|-----------|
| id | bigint unsigned | 20 | NO | — | PRI | Auto increment |
| setting_key | varchar | 100 | NO | — | | Key setting terkait |
| image_path | varchar | 200 | NO | — | | Path file gambar |
| created_at | timestamp | — | YES | NULL | | Waktu dibuat |
| updated_at | timestamp | — | YES | NULL | | Waktu diubah |

---

### 7. `media`

Manajemen media (spatie/laravel-medialibrary).

| Kolom | Tipe | Length | Null | Default | Key | Keterangan |
|-------|------|--------|------|---------|-----|-----------|
| id | char | 36 | NO | — | | UUID |
| model_type | varchar | 255 | NO | — | | Nama class model (polymorphic) |
| model_id | char | 36 | NO | — | | UUID model terkait |
| uuid | char | 36 | YES | NULL | UNI | UUID media |
| collection_name | varchar | 255 | NO | — | | Nama koleksi (misal images, downloads) |
| name | varchar | 255 | NO | — | | Nama asli file |
| file_name | varchar | 255 | NO | — | | Nama file di disk |
| mime_type | varchar | 255 | YES | NULL | | Tipe MIME |
| disk | varchar | 255 | NO | — | | Disk penyimpanan (public/local) |
| conversions_disk | varchar | 255 | YES | NULL | | Disk untuk hasil konversi |
| size | bigint unsigned | 20 | NO | — | | Ukuran file (bytes) |
| manipulations | longtext | — | NO | — | | Manipulasi gambar (JSON) |
| custom_properties | longtext | — | NO | — | | Properti kustom (JSON) |
| generated_conversions | longtext | — | NO | — | | Hasil konversi (JSON) |
| responsive_images | longtext | — | NO | — | | Gambar responsif (JSON) |
| order_column | int unsigned | 10 | YES | NULL | MUL | Urutan sorting |
| created_at | timestamp | — | YES | NULL | | Waktu dibuat |
| updated_at | timestamp | — | YES | NULL | | Waktu diubah |

---

### 8. `password_reset_tokens`

Token reset password.

| Kolom | Tipe | Length | Null | Default | Key | Keterangan |
|-------|------|--------|------|---------|-----|-----------|
| email | varchar | 100 | NO | — | PRI | Email user |
| token | varchar | 64 | NO | — | | Token reset (hash) |
| created_at | timestamp | — | YES | NULL | | Waktu dibuat |

---

### 9. `personal_access_tokens`

Token API personal (Laravel Sanctum).

| Kolom | Tipe | Length | Null | Default | Key | Keterangan |
|-------|------|--------|------|---------|-----|-----------|
| id | bigint unsigned | 20 | NO | — | PRI | Auto increment |
| tokenable_type | varchar | 255 | NO | — | MUL | Nama class model |
| tokenable_id | bigint unsigned | 20 | NO | — | | ID model (numeric) |
| name | varchar | 255 | NO | — | | Nama token |
| token | varchar | 64 | NO | — | UNI | Hash token |
| abilities | text | — | YES | NULL | | Kemampuan token (JSON) |
| last_used_at | timestamp | — | YES | NULL | | Waktu terakhir digunakan |
| expires_at | timestamp | — | YES | NULL | | Waktu kedaluwarsa |
| created_at | timestamp | — | YES | NULL | | Waktu dibuat |
| updated_at | timestamp | — | YES | NULL | | Waktu diubah |

---

### 10. `notifications`

Notifikasi database (Laravel Notification).

| Kolom | Tipe | Length | Null | Default | Key | Keterangan |
|-------|------|--------|------|---------|-----|-----------|
| id | char | 36 | NO | — | PRI | UUID |
| type | varchar | 255 | NO | — | | Nama class notifikasi |
| notifiable_type | varchar | 255 | NO | — | MUL | Nama class model |
| notifiable_id | char | 36 | NO | — | | UUID model |
| data | text | — | NO | — | | Data notifikasi (JSON) |
| read_at | timestamp | — | YES | NULL | | Waktu dibaca |
| created_at | timestamp | — | YES | NULL | | Waktu dibuat |
| updated_at | timestamp | — | YES | NULL | | Waktu diubah |

---

### 11. `failed_jobs`

Daftar job yang gagal di queue.

| Kolom | Tipe | Length | Null | Default | Key | Keterangan |
|-------|------|--------|------|---------|-----|-----------|
| id | bigint unsigned | 20 | NO | — | PRI | Auto increment |
| uuid | varchar | 255 | NO | — | UNI | UUID job |
| connection | text | — | NO | — | | Koneksi queue |
| queue | text | — | NO | — | | Nama queue |
| payload | longtext | — | NO | — | | Data job (JSON) |
| exception | longtext | — | NO | — | | Pesan exception |
| failed_at | timestamp | — | NO | CURRENT_TIMESTAMP | | Waktu gagal |

---

### 12. `jobs`

Antrian job.

| Kolom | Tipe | Length | Null | Default | Key | Keterangan |
|-------|------|--------|------|---------|-----|-----------|
| id | bigint unsigned | 20 | NO | — | PRI | Auto increment |
| queue | varchar | 255 | NO | — | MUL | Nama antrian |
| payload | longtext | — | NO | — | | Data job (JSON) |
| attempts | tinyint unsigned | 3 | NO | — | | Jumlah percobaan |
| reserved_at | int unsigned | 10 | YES | NULL | | Waktu reservasi (timestamp unix) |
| available_at | int unsigned | 10 | NO | — | | Waktu tersedia (timestamp unix) |
| created_at | int unsigned | 10 | NO | — | | Waktu dibuat (timestamp unix) |

---

## B. Tabel Module Shop (14 tabel)

---

### 13. `shop_products`

Master data produk.

| Kolom | Tipe | Length | Null | Default | Key | Keterangan |
|-------|------|--------|------|---------|-----|-----------|
| id | char | 36 | NO | — | PRI | UUID |
| user_id | char | 36 | YES | NULL | MUL | Foreign key ke `users.id` (penjual) |
| sku | varchar | 50 | NO | — | MUL | SKU unik produk |
| type | varchar | 30 | NO | — | | Tipe: simple, configurable |
| parent_id | char | 36 | YES | NULL | MUL | UUID parent (untuk variant/configurable) |
| name | varchar | 150 | NO | — | | Nama produk |
| slug | varchar | 150 | NO | — | | Slug URL |
| price | decimal | 15,2 | YES | NULL | | Harga normal |
| sale_price | decimal | 15,2 | YES | NULL | | Harga diskon |
| status | varchar | 20 | NO | — | | Status: draft, published, archived |
| views_count | bigint unsigned | 20 | NO | 0 | | Jumlah dilihat |
| weight | int | 11 | NO | 0 | | Berat (gram) |
| stock_status | varchar | 20 | NO | 'IN_STOCK' | | IN_STOCK, OUT_OF_STOCK |
| manage_stock | tinyint | 1 | NO | 0 | | Aktifkan manajemen stok |
| publish_date | datetime | — | YES | NULL | MUL | Tanggal publikasi |
| excerpt | text | — | YES | NULL | | Ringkasan deskripsi |
| body | text | — | YES | NULL | | Deskripsi lengkap |
| metas | longtext | — | YES | NULL | | Metadata (JSON) |
| featured_image | varchar | 200 | YES | NULL | | Path gambar utama |
| created_at | timestamp | — | YES | NULL | | Waktu dibuat |
| updated_at | timestamp | — | YES | NULL | | Waktu diubah |
| deleted_at | timestamp | — | YES | NULL | | Soft delete |
| attributes | longtext | — | YES | NULL | | Atribut (JSON) |

---

### 14. `shop_product_images`

Gambar produk (multiple).

| Kolom | Tipe | Length | Null | Default | Key | Keterangan |
|-------|------|--------|------|---------|-----|-----------|
| id | char | 36 | NO | — | PRI | UUID |
| product_id | char | 36 | NO | — | MUL | Foreign key ke `shop_products.id` |
| name | varchar | 200 | YES | NULL | | Nama/path gambar |
| created_at | timestamp | — | YES | NULL | | Waktu dibuat |
| updated_at | timestamp | — | YES | NULL | | Waktu diubah |

---

### 15. `shop_product_inventories`

Stok produk.

| Kolom | Tipe | Length | Null | Default | Key | Keterangan |
|-------|------|--------|------|---------|-----|-----------|
| id | char | 36 | NO | — | PRI | UUID |
| product_id | char | 36 | NO | — | MUL | Foreign key ke `shop_products.id` |
| qty | int | 11 | YES | NULL | | Jumlah stok |
| low_stock_threshold | int | 11 | YES | NULL | | Batas stok minimum |
| created_at | timestamp | — | YES | NULL | | Waktu dibuat |
| updated_at | timestamp | — | YES | NULL | | Waktu diubah |

---

### 16. `shop_categories`

Kategori produk (mendukung nested).

| Kolom | Tipe | Length | Null | Default | Key | Keterangan |
|-------|------|--------|------|---------|-----|-----------|
| id | char | 36 | NO | — | PRI | UUID |
| parent_id | char | 36 | YES | NULL | MUL | Foreign key ke parent kategori (self-referencing) |
| slug | varchar | 100 | NO | — | MUL | Slug URL |
| name | varchar | 100 | NO | — | | Nama kategori |
| created_at | timestamp | — | YES | NULL | MUL | Waktu dibuat |
| updated_at | timestamp | — | YES | NULL | | Waktu diubah |

---

### 17. `shop_categories_products`

Relasi many-to-many kategori dan produk (pivot).

| Kolom | Tipe | Length | Null | Default | Key | Keterangan |
|-------|------|--------|------|---------|-----|-----------|
| product_id | char | 36 | NO | — | PRI | Foreign key ke `shop_products.id` |
| category_id | char | 36 | NO | — | PRI | Foreign key ke `shop_categories.id` |

---

### 18. `shop_addresses`

Alamat pelanggan.

| Kolom | Tipe | Length | Null | Default | Key | Keterangan |
|-------|------|--------|------|---------|-----|-----------|
| id | char | 36 | NO | — | PRI | UUID |
| user_id | char | 36 | NO | — | MUL | Foreign key ke `users.id` |
| is_primary | tinyint | 1 | NO | 0 | | Alamat utama (1=ya) |
| label | varchar | 30 | YES | NULL | | Label (misal Rumah, Kantor) |
| first_name | varchar | 50 | NO | — | | Nama depan penerima |
| last_name | varchar | 50 | NO | — | | Nama belakang penerima |
| address1 | varchar | 200 | YES | NULL | | Alamat baris 1 |
| address2 | varchar | 200 | YES | NULL | | Alamat baris 2 |
| phone | varchar | 20 | YES | NULL | | No telepon penerima |
| email | varchar | 100 | YES | NULL | | Email penerima |
| city | varchar | 100 | YES | NULL | | Kota |
| city_id | int | 11 | YES | NULL | | ID kota (RajaOngkir) |
| province | varchar | 100 | YES | NULL | | Provinsi |
| province_id | int | 11 | YES | NULL | | ID provinsi (RajaOngkir) |
| postcode | int | 11 | YES | NULL | | Kode pos |
| created_at | timestamp | — | YES | NULL | | Waktu dibuat |
| updated_at | timestamp | — | YES | NULL | | Waktu diubah |

---

### 19. `shop_carts`

Data keranjang belanja.

| Kolom | Tipe | Length | Null | Default | Key | Keterangan |
|-------|------|--------|------|---------|-----|-----------|
| id | char | 36 | NO | — | PRI | UUID |
| user_id | char | 36 | YES | NULL | MUL | Foreign key ke `users.id` |
| expired_at | datetime | — | NO | — | MUL | Waktu kedaluwarsa keranjang |
| base_total_price | decimal | 16,2 | NO | 0.00 | | Total harga sebelum diskon/tax |
| total_weight | int | 11 | NO | 0 | | Total berat (gram) |
| tax_amount | decimal | 16,2 | NO | 0.00 | | Jumlah pajak |
| tax_percent | decimal | 16,2 | NO | 0.00 | | Persen pajak |
| discount_amount | decimal | 16,2 | NO | 0.00 | | Jumlah diskon |
| discount_percent | decimal | 16,2 | NO | 0.00 | | Persen diskon |
| grand_total | decimal | 16,2 | NO | 0.00 | | Total akhir |
| voucher_code | varchar | 30 | YES | NULL | | Kode voucher yang digunakan |
| deleted_at | timestamp | — | YES | NULL | | Soft delete |
| created_at | timestamp | — | YES | NULL | | Waktu dibuat |
| updated_at | timestamp | — | YES | NULL | | Waktu diubah |

---

### 20. `shop_cart_items`

Item dalam keranjang belanja.

| Kolom | Tipe | Length | Null | Default | Key | Keterangan |
|-------|------|--------|------|---------|-----|-----------|
| id | char | 36 | NO | — | PRI | UUID |
| cart_id | char | 36 | NO | — | MUL | Foreign key ke `shop_carts.id` |
| product_id | char | 36 | NO | — | MUL | Foreign key ke `shop_products.id` |
| qty | int | 11 | NO | — | | Jumlah item |
| created_at | timestamp | — | YES | NULL | | Waktu dibuat |
| updated_at | timestamp | — | YES | NULL | | Waktu diubah |
| attributes | longtext | — | YES | NULL | | Atribut pilihan (JSON, misal ukuran/warna) |

---

### 21. `shop_orders`

Data pesanan/order.

| Kolom | Tipe | Length | Null | Default | Key | Keterangan |
|-------|------|--------|------|---------|-----|-----------|
| id | char | 36 | NO | — | PRI | UUID |
| user_id | char | 36 | NO | — | MUL | Foreign key ke `users.id` |
| code | varchar | 30 | NO | — | UNI | Kode unik order (format: INV/YYYYMMDD/xxxx) |
| status | varchar | 30 | NO | — | | Status: waiting_payment, processing, completed, cancelled |
| payment_status | varchar | 30 | YES | NULL | | Status pembayaran: pending, approved, rejected |
| shipping_courier | varchar | 30 | YES | NULL | | Kurir pengiriman |
| shipping_service_name | varchar | 100 | YES | NULL | | Nama layanan kurir |
| shipping_number | varchar | 50 | YES | NULL | MUL | No resi pengiriman |
| approved_by | char | 36 | YES | NULL | MUL | UUID admin yang approve |
| approved_at | datetime | — | YES | NULL | | Waktu approval |
| cancelled_by | char | 36 | YES | NULL | MUL | UUID admin/customer yang cancel |
| cancelled_at | datetime | — | YES | NULL | | Waktu pembatalan |
| cancellation_note | text | — | YES | NULL | | Alasan pembatalan |
| order_date | datetime | — | NO | — | | Tanggal order |
| payment_due | datetime | — | NO | — | | Batas waktu pembayaran |
| base_total_price | decimal | 16,2 | NO | 0.00 | | Total harga produk |
| tax_amount | decimal | 16,2 | NO | 0.00 | | Pajak |
| tax_percent | decimal | 16,2 | NO | 0.00 | | Persen pajak |
| discount_amount | decimal | 16,2 | NO | 0.00 | | Diskon |
| discount_percent | decimal | 16,2 | NO | 0.00 | | Persen diskon |
| shipping_cost | decimal | 16,2 | NO | 0.00 | | Ongkos kirim |
| grand_total | decimal | 16,2 | NO | 0.00 | | Total keseluruhan |
| voucher_code | varchar | 30 | YES | NULL | | Kode voucher |
| customer_note | text | — | YES | NULL | | Catatan pelanggan |
| customer_first_name | varchar | 50 | NO | — | | Nama depan penerima |
| customer_last_name | varchar | 50 | NO | — | | Nama belakang penerima |
| customer_address1 | varchar | 200 | YES | NULL | | Alamat pengiriman baris 1 |
| customer_address2 | varchar | 200 | YES | NULL | | Alamat pengiriman baris 2 |
| customer_phone | varchar | 20 | YES | NULL | | No telepon penerima |
| customer_email | varchar | 100 | YES | NULL | | Email penerima |
| customer_city | varchar | 100 | YES | NULL | | Kota pengiriman |
| customer_province | varchar | 100 | YES | NULL | | Provinsi pengiriman |
| customer_postcode | int | 11 | YES | NULL | | Kode pos |
| deleted_at | timestamp | — | YES | NULL | | Soft delete |
| created_at | timestamp | — | YES | NULL | | Waktu dibuat |
| updated_at | timestamp | — | YES | NULL | | Waktu diubah |

---

### 22. `shop_order_items`

Item dalam pesanan.

| Kolom | Tipe | Length | Null | Default | Key | Keterangan |
|-------|------|--------|------|---------|-----|-----------|
| id | char | 36 | NO | — | PRI | UUID |
| order_id | char | 36 | NO | — | MUL | Foreign key ke `shop_orders.id` |
| product_id | char | 36 | NO | — | MUL | Foreign key ke `shop_products.id` |
| qty | int | 11 | NO | — | | Jumlah |
| base_price | decimal | 16,2 | NO | 0.00 | | Harga satuan |
| base_total | decimal | 16,2 | NO | 0.00 | | Subtotal = qty × base_price |
| tax_amount | decimal | 16,2 | NO | 0.00 | | Pajak per item |
| tax_percent | decimal | 16,2 | NO | 0.00 | | Persen pajak |
| discount_amount | decimal | 16,2 | NO | 0.00 | | Diskon per item |
| discount_percent | decimal | 16,2 | NO | 0.00 | | Persen diskon |
| sub_total | decimal | 16,2 | NO | 0.00 | | Total per item (setelah diskon+pajak) |
| sku | varchar | 50 | NO | — | MUL | SKU produk (snapshot) |
| type | varchar | 30 | NO | — | | Tipe item |
| name | varchar | 150 | NO | — | | Nama produk (snapshot) |
| attributes | longtext | — | NO | — | | Atribut yang dipilih (JSON) |
| created_at | timestamp | — | YES | NULL | | Waktu dibuat |
| updated_at | timestamp | — | YES | NULL | | Waktu diubah |

---

### 23. `shop_payments`

Data pembayaran pesanan.

| Kolom | Tipe | Length | Null | Default | Key | Keterangan |
|-------|------|--------|------|---------|-----|-----------|
| id | char | 36 | NO | — | PRI | UUID |
| user_id | char | 36 | NO | — | MUL | Foreign key ke `users.id` |
| order_id | char | 36 | NO | — | MUL | Foreign key ke `shop_orders.id` |
| payment_type | varchar | 50 | NO | — | MUL | Metode: bank_transfer, manual, cod |
| status | varchar | 30 | NO | — | | Status: pending, approved, rejected |
| approved_by | char | 36 | YES | NULL | | UUID admin yang approve |
| approved_at | datetime | — | YES | NULL | | Waktu approval |
| note | text | — | YES | NULL | | Catatan dari pelanggan |
| rejected_by | char | 36 | YES | NULL | | UUID admin yang reject |
| rejected_at | datetime | — | YES | NULL | | Waktu penolakan |
| rejection_note | text | — | YES | NULL | | Alasan penolakan |
| amount | decimal | 16,2 | NO | 0.00 | | Jumlah bayar |
| payloads | longtext | — | YES | NULL | | Data tambahan (JSON) |
| deleted_at | timestamp | — | YES | NULL | | Soft delete |
| created_at | timestamp | — | YES | NULL | | Waktu dibuat |
| updated_at | timestamp | — | YES | NULL | | Waktu diubah |
| token | varchar | 255 | YES | NULL | | Token pembayaran eksternal |

---

### 24. `shop_reviews`

Ulasan produk oleh pelanggan.

| Kolom | Tipe | Length | Null | Default | Key | Keterangan |
|-------|------|--------|------|---------|-----|-----------|
| id | bigint unsigned | 20 | NO | — | PRI | Auto increment |
| user_id | char | 36 | NO | — | MUL | Foreign key ke `users.id` |
| product_id | char | 36 | NO | — | MUL | Foreign key ke `shop_products.id` |
| order_id | char | 36 | NO | — | MUL | Foreign key ke `shop_orders.id` |
| rating | tinyint | 4 | NO | 5 | | Rating 1-5 |
| comment | text | — | YES | NULL | | Komentar |
| status | varchar | 20 | NO | 'approved' | | Status: approved, pending, rejected |
| created_at | timestamp | — | YES | NULL | | Waktu dibuat |
| updated_at | timestamp | — | YES | NULL | | Waktu diubah |

---

### 25. `shop_vouchers`

Voucher diskon.

| Kolom | Tipe | Length | Null | Default | Key | Keterangan |
|-------|------|--------|------|---------|-----|-----------|
| id | char | 36 | NO | — | PRI | UUID |
| code | varchar | 30 | NO | — | UNI | Kode voucher unik |
| description | varchar | 200 | YES | NULL | | Deskripsi |
| type | enum('fixed','percent') | — | NO | 'fixed' | | Jenis: fixed (nominal) atau percent |
| value | decimal | 15,2 | NO | — | | Nilai diskon |
| min_total | decimal | 15,2 | NO | 0.00 | | Minimal belanja |
| is_first_order_only | tinyint | 1 | NO | 0 | | Hanya untuk order pertama |
| min_order_count | int | 11 | NO | 0 | | Minimal jumlah order sebelumnya |
| is_active | tinyint | 1 | NO | 1 | | Aktif/nonaktif |
| expired_at | date | — | YES | NULL | | Tanggal kedaluwarsa |
| created_at | timestamp | — | YES | NULL | | Waktu dibuat |
| updated_at | timestamp | — | YES | NULL | | Waktu diubah |

---

### 26. `shop_wishlists`

Wishlist produk favorit.

| Kolom | Tipe | Length | Null | Default | Key | Keterangan |
|-------|------|--------|------|---------|-----|-----------|
| id | bigint unsigned | 20 | NO | — | PRI | Auto increment |
| user_id | char | 36 | NO | — | MUL | Foreign key ke `users.id` |
| product_id | char | 36 | NO | — | MUL | Foreign key ke `shop_products.id` |
| created_at | timestamp | — | YES | NULL | | Waktu dibuat |
| updated_at | timestamp | — | YES | NULL | | Waktu diubah |

---

## C. Tabel System (1 tabel)

---

### 27. `migrations`

Riwayat migrasi database.

| Kolom | Tipe | Length | Null | Default | Key | Keterangan |
|-------|------|--------|------|---------|-----|-----------|
| id | int unsigned | 10 | NO | — | PRI | Auto increment |
| migration | varchar | 255 | NO | — | | Nama file migration |
| batch | int | 11 | NO | — | | Nomor batch migrasi |

---

## Ringkasan Hubungan Antar Tabel (Relasi)

```
users (1) ──< conversations (M)    conversations (1) ──< messages (M)
users (1) ──< shop_addresses (M)   users (1) ──< shop_carts (M)
users (1) ──< shop_orders (M)      users (1) ──< shop_payments (M)
users (1) ──< shop_reviews (M)     users (1) ──< shop_wishlists (M)
users (1) ──< shop_cart_items (M)  [via shop_carts]

shop_products (1) ──< shop_product_images (M)
shop_products (1) ──< shop_product_inventories (1)
shop_products (M) ──< shop_categories_products >── shop_categories (M)
shop_products (1) ──< shop_order_items (M)
shop_products (1) ──< shop_reviews (M)
shop_products (1) ──< shop_wishlists (M)

shop_orders (1) ──< shop_order_items (M)
shop_orders (1) ──< shop_payments (M)
shop_orders (1) ──< shop_reviews (M)

shop_carts (1) ──< shop_cart_items (M)
```

---

## Catatan Optimasi

17 tabel aplikasi telah dioptimasi melalui migration `2026_06_06_010000_optimize_column_lengths.php` untuk memperkecil `varchar(255)` menjadi ukuran yang realistis. Package tables berikut **tidak** diubah:
- `media` — diatur oleh spatie/laravel-medialibrary
- `notifications` — diatur oleh Laravel Notification
- `personal_access_tokens` — diatur oleh Laravel Sanctum
- `jobs`, `failed_jobs` — diatur oleh Laravel Queue

---

*Dokumentasi ini digenerate langsung dari `DESCRIBE` pada MySQL database `gallery-puandb` setelah seluruh migrasi dijalankan.*
