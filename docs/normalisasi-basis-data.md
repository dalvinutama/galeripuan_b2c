# Normalisasi Basis Data

Normalisasi merupakan suatu teknik dalam perancangan basis data yang bertujuan untuk menghasilkan sejumlah relasi atau tabel dengan struktur yang memenuhi kriteria tertentu. Proses ini dilakukan untuk menyederhanakan data yang semula tidak terstruktur secara efisien menjadi bentuk yang lebih terorganisir dan optimal. Adapun bentuk-bentuk normalisasi yang diterapkan pada sistem basis data E-Commerce Gallery Puan dijelaskan sebagai berikut:

## 1. Bentuk Unnormalized Form (UNF)

id_pesanan + kode_pesanan + status_pesanan + payment_status_pesanan + shipping_courier_pesanan + shipping_service_name_pesanan + shipping_number_pesanan + order_date_pesanan + payment_due_pesanan + base_total_price_pesanan + tax_amount_pesanan + tax_percent_pesanan + discount_amount_pesanan + discount_percent_pesanan + shipping_cost_pesanan + grand_total_pesanan + voucher_code_pesanan + customer_note_pesanan + customer_first_name_pesanan + customer_last_name_pesanan + customer_address1_pesanan + customer_address2_pesanan + customer_phone_pesanan + customer_email_pesanan + customer_city_pesanan + customer_province_pesanan + customer_postcode_pesanan + approved_by_pesanan + approved_at_pesanan + cancelled_by_pesanan + cancelled_at_pesanan + cancellation_note_pesanan + deleted_at_pesanan + created_at_pesanan + updated_at_pesanan + id_user + name_user + email_user + password_user + email_verified_at_user + created_at_user + updated_at_user + id_item_pesanan + product_id_item_pesanan + qty_item_pesanan + base_price_item_pesanan + base_total_item_pesanan + tax_amount_item_pesanan + tax_percent_item_pesanan + discount_amount_item_pesanan + discount_percent_item_pesanan + sub_total_item_pesanan + sku_item_pesanan + type_item_pesanan + name_item_pesanan + attributes_item_pesanan + created_at_item_pesanan + updated_at_item_pesanan + id_produk + parent_id_produk + nama_produk + slug_produk + tipe_produk + harga_produk + harga_diskon_produk + status_produk + status_stok_produk + manage_stok_produk + berat_produk + publish_date_produk + excerpt_produk + body_produk + metas_produk + featured_image_produk + views_count_produk + attributes_produk + deleted_at_produk + created_at_produk + updated_at_produk + id_inventori + qty_inventori + low_stock_threshold_inventori + created_at_inventori + updated_at_inventori + id_gambar + nama_gambar + created_at_gambar + updated_at_gambar + id_kategori + parent_id_kategori + slug_kategori + nama_kategori + created_at_kategori + updated_at_kategori + id_pembayaran + payment_type_pembayaran + status_pembayaran + amount_pembayaran + payloads_pembayaran + note_pembayaran + approved_by_pembayaran + approved_at_pembayaran + rejected_by_pembayaran + rejected_at_pembayaran + rejection_note_pembayaran + deleted_at_pembayaran + created_at_pembayaran + updated_at_pembayaran + id_keranjang + expired_at_keranjang + base_total_price_keranjang + total_weight_keranjang + tax_amount_keranjang + tax_percent_keranjang + discount_amount_keranjang + discount_percent_keranjang + grand_total_keranjang + voucher_code_keranjang + deleted_at_keranjang + created_at_keranjang + updated_at_keranjang + id_item_keranjang + product_id_item_keranjang + qty_item_keranjang + attributes_item_keranjang + created_at_item_keranjang + updated_at_item_keranjang + id_ulasan + rating_ulasan + comment_ulasan + status_ulasan + created_at_ulasan + updated_at_ulasan + id_wishlist + created_at_wishlist + updated_at_wishlist + id_alamat + is_primary_alamat + label_alamat + first_name_alamat + last_name_alamat + address1_alamat + address2_alamat + phone_alamat + email_alamat + city_alamat + city_id_alamat + province_alamat + province_id_alamat + postcode_alamat + created_at_alamat + updated_at_alamat + id_voucher + kode_voucher + deskripsi_voucher + tipe_voucher + nilai_voucher + minimal_total_voucher + is_first_order_only_voucher + min_order_count_voucher + is_active_voucher + expired_at_voucher + created_at_voucher + updated_at_voucher

## 2. Bentuk First Normal Form (1NF)

Pada tahap ini, seluruh data dari UNF dikelompokkan ke dalam tabel-tabel berdasarkan entitasnya. Setiap tabel memiliki primary key dan tidak boleh mengandung grup berulang (*repeating group*). Data redundan masih dipertahankan pada tahap ini.

Tabel Order = {id + user_id + code + status + payment_status + shipping_courier + shipping_service_name + shipping_number + approved_by + approved_at + cancelled_by + cancelled_at + cancellation_note + order_date + payment_due + base_total_price + tax_amount + tax_percent + discount_amount + discount_percent + shipping_cost + grand_total + voucher_code + customer_note + customer_first_name + customer_last_name + customer_address1 + customer_address2 + customer_phone + customer_email + customer_city + customer_province + customer_postcode + deleted_at + created_at + updated_at + name_user + email_user + password_user + email_verified_at_user}

Tabel OrderItem = {id + order_id + product_id + qty + base_price + base_total + tax_amount + tax_percent + discount_amount + discount_percent + sub_total + sku + type + name + attributes + created_at + updated_at + nama_produk + slug_produk + tipe_produk + harga_produk + harga_diskon_produk + status_produk + status_stok_produk + manage_stok_produk + berat_produk + publish_date_produk + excerpt_produk + body_produk + metas_produk + featured_image_produk + views_count_produk + attributes_produk + qty_inventori + low_stock_threshold_inventori + nama_gambar + parent_id_kategori + slug_kategori + nama_kategori}

Tabel Payment = {id + user_id + order_id + payment_type + status + amount + payloads + note + approved_by + approved_at + rejected_by + rejected_at + rejection_note + deleted_at + created_at + updated_at}

Tabel Cart = {id + user_id + expired_at + base_total_price + total_weight + tax_amount + tax_percent + discount_amount + discount_percent + grand_total + voucher_code + deleted_at + created_at + updated_at}

Tabel CartItem = {id + cart_id + product_id + qty + attributes + created_at + updated_at + nama_produk + slug_produk + tipe_produk + harga_produk + harga_diskon_produk + status_produk + status_stok_produk + attributes_produk + qty_inventori + low_stock_threshold_inventori + nama_gambar + parent_id_kategori + slug_kategori + nama_kategori}

Tabel Review = {id + user_id + product_id + order_id + rating + comment + status + created_at + updated_at}

Tabel Wishlist = {id + user_id + product_id + created_at + updated_at}

Tabel Address = {id + user_id + is_primary + label + first_name + last_name + address1 + address2 + phone + email + city + city_id + province + province_id + postcode + created_at + updated_at}

Tabel Voucher = {id + code + description + type + value + min_total + is_first_order_only + min_order_count + is_active + expired_at + created_at + updated_at}

## 3. Bentuk Second Normal Form (2NF)

Pada tahap ini, seluruh tabel dari 1NF telah memiliki *primary key* tunggal sehingga tidak terdapat ketergantungan parsial (*partial dependency*). Namun, masih terdapat redundansi data akibat ketergantungan fungsional terhadap *foreign key*. Maka dilakukan pemisahan data yang bergantung pada *foreign key* ke dalam tabel tersendiri.

Tabel Order = {id + user_id + code + status + payment_status + shipping_courier + shipping_service_name + shipping_number + approved_by + approved_at + cancelled_by + cancelled_at + cancellation_note + order_date + payment_due + base_total_price + tax_amount + tax_percent + discount_amount + discount_percent + shipping_cost + grand_total + voucher_code + customer_note + customer_first_name + customer_last_name + customer_address1 + customer_address2 + customer_phone + customer_email + customer_city + customer_province + customer_postcode + deleted_at + created_at + updated_at}

Tabel OrderItem = {id + order_id + product_id + qty + base_price + base_total + tax_amount + tax_percent + discount_amount + discount_percent + sub_total + attributes + created_at + updated_at}

Tabel User = {id + name + email + password + email_verified_at + created_at + updated_at}

Tabel Payment = {id + user_id + order_id + payment_type + status + amount + payloads + note + approved_by + approved_at + rejected_by + rejected_at + rejection_note + deleted_at + created_at + updated_at}

Tabel Cart = {id + user_id + expired_at + base_total_price + total_weight + tax_amount + tax_percent + discount_amount + discount_percent + grand_total + voucher_code + deleted_at + created_at + updated_at}

Tabel CartItem = {id + cart_id + product_id + qty + attributes + created_at + updated_at}

Tabel Review = {id + user_id + product_id + order_id + rating + comment + status + created_at + updated_at}

Tabel Wishlist = {id + user_id + product_id + created_at + updated_at}

Tabel Address = {id + user_id + is_primary + label + first_name + last_name + address1 + address2 + phone + email + city + city_id + province + province_id + postcode + created_at + updated_at}

Tabel Voucher = {id + code + description + type + value + min_total + is_first_order_only + min_order_count + is_active + expired_at + created_at + updated_at}

Tabel Product = {id + user_id + parent_id + sku + type + name + slug + price + sale_price + status + stock_status + manage_stock + weight + publish_date + excerpt + body + metas + featured_image + views_count + attributes + deleted_at + created_at + updated_at + qty_inventori + low_stock_threshold_inventori + nama_gambar + parent_id_kategori + slug_kategori + nama_kategori}
(Catatan: Data inventori, gambar, dan kategori masih menempel di Product karena ketergantungan transitif (*transitive dependency*) yang akan dihapus di 3NF)

## 4. Bentuk Third Normal Form (3NF)

Pada tahap ini, seluruh ketergantungan transitif dihilangkan. Data yang tidak bergantung langsung pada *primary key* tetapi bergantung pada atribut non-key lainnya dipisahkan ke dalam tabel tersendiri.

Tabel User = {id + name + email + password + email_verified_at + created_at + updated_at}

Tabel Category = {id + parent_id + slug + name + created_at + updated_at}

Tabel Product = {id + user_id + parent_id + sku + type + name + slug + price + sale_price + status + stock_status + manage_stock + weight + publish_date + excerpt + body + metas + featured_image + views_count + attributes + deleted_at + created_at + updated_at}

Tabel ProductInventory = {id + product_id + qty + low_stock_threshold + created_at + updated_at}

Tabel ProductImage = {id + product_id + name + created_at + updated_at}

Tabel Address = {id + user_id + is_primary + label + first_name + last_name + address1 + address2 + phone + email + city + city_id + province + province_id + postcode + created_at + updated_at}

Tabel Cart = {id + user_id + expired_at + base_total_price + total_weight + tax_amount + tax_percent + discount_amount + discount_percent + grand_total + voucher_code + deleted_at + created_at + updated_at}

Tabel CartItem = {id + cart_id + product_id + qty + attributes + created_at + updated_at}

Tabel Order = {id + user_id + code + status + payment_status + shipping_courier + shipping_service_name + shipping_number + approved_by + approved_at + cancelled_by + cancelled_at + cancellation_note + order_date + payment_due + base_total_price + tax_amount + tax_percent + discount_amount + discount_percent + shipping_cost + grand_total + voucher_code + customer_note + customer_first_name + customer_last_name + customer_address1 + customer_address2 + customer_phone + customer_email + customer_city + customer_province + customer_postcode + deleted_at + created_at + updated_at}

Tabel OrderItem = {id + order_id + product_id + qty + base_price + base_total + tax_amount + tax_percent + discount_amount + discount_percent + sub_total + attributes + created_at + updated_at}

Tabel Payment = {id + user_id + order_id + payment_type + status + amount + payloads + note + approved_by + approved_at + rejected_by + rejected_at + rejection_note + deleted_at + created_at + updated_at}

Tabel Voucher = {id + code + description + type + value + min_total + is_first_order_only + min_order_count + is_active + expired_at + created_at + updated_at}

Tabel Wishlist = {id + user_id + product_id + created_at + updated_at}

Tabel Review = {id + user_id + product_id + order_id + rating + comment + status + created_at + updated_at}

Tabel CategoryProduct = {product_id + category_id}

Berdasarkan hasil normalisasi hingga bentuk Third Normal Form (3NF), diperoleh lima belas tabel yang saling berelasi. Proses normalisasi telah menghilangkan redundansi data dan memastikan integritas data dalam sistem. Tabel-tabel tersebut telah sesuai dengan perancangan basis data yang diimplementasikan pada sistem E-Commerce Gallery Puan.
