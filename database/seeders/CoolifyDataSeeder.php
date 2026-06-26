<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoolifyDataSeeder extends Seeder
{
    public function run()
    {
        // Cek jika data sudah ada, jangan dioverwrite/dihapus
        if (DB::table('shop_products')->count() > 0) {
            $this->command->info('Data sudah ada di tabel shop_products. Seeding dibatalkan untuk mencegah overwrite.');
            return;
        }

        $categories = array (
  0 => 
  array (
    'id' => '02869d99-6d37-4462-a0dd-4989b6cc61b7',
    'parent_id' => NULL,
    'slug' => 'ciput',
    'name' => 'Ciput',
    'created_at' => '2026-06-01T06:41:40.000000Z',
    'updated_at' => '2026-06-01T06:41:40.000000Z',
  ),
  1 => 
  array (
    'id' => '2b8ea3ca-abaf-4d35-b283-1315d18c306c',
    'parent_id' => NULL,
    'slug' => 'segi-empat-square-hijab',
    'name' => 'Segi Empat (Square Hijab)',
    'created_at' => '2026-05-22T10:40:14.000000Z',
    'updated_at' => '2026-05-22T10:40:14.000000Z',
  ),
  2 => 
  array (
    'id' => '4439b4da-88e7-4472-816f-627edec65ad9',
    'parent_id' => NULL,
    'slug' => 'hijab-instan',
    'name' => 'Hijab Instan',
    'created_at' => '2026-05-22T10:40:41.000000Z',
    'updated_at' => '2026-05-22T10:40:41.000000Z',
  ),
  3 => 
  array (
    'id' => '45b9ff82-dfd1-4eca-bdbb-2cbe88402d41',
    'parent_id' => NULL,
    'slug' => 'pashmina',
    'name' => 'Pashmina',
    'created_at' => '2026-05-22T10:41:02.000000Z',
    'updated_at' => '2026-05-22T10:41:02.000000Z',
  ),
);
        DB::table('shop_categories')->insert($categories);

        $products = array (
  0 => 
  array (
    'id' => '10743503-4051-4c57-9679-558e9a7955a6',
    'user_id' => '1',
    'sku' => 'HIJAB-004',
    'type' => 'CONFIGURABLE',
    'parent_id' => NULL,
    'name' => 'CIput Arab Tali Belakng Bahan rayon',
    'slug' => 'ciput-arab-tali-belakng-bahan-rayon',
    'price' => '20000.00',
    'sale_price' => NULL,
    'status' => 'ACTIVE',
    'views_count' => 8,
    'weight' => 190,
    'stock_status' => 'IN_STOCK',
    'manage_stock' => 1,
    'publish_date' => NULL,
    'excerpt' => 'Ciput Arab Tali Belakang Rayon Premium
Inner hijab klasik model Arab dengan fitur tali ikat belakang untuk tingkat kekencangan yang bisa disesuaikan. Terbuat dari bahan Kaos Rayon Premium yang super lembut, stretch, dingin di kulit, dan menyerap keringat dengan sangat baik. Solusi tepat untuk inner hijab anti-pusing, anti-melorot, dan menjaga rambut tetap rapi seharian. Nyaman banget untuk pemakaian daily!',
    'body' => 'Ciput Arab Tali Belakang Premium – Nyaman, Adem, Anti-Pusing!

Maksimalkan kenyamanan berhijabmu setiap hari dengan Ciput Arab Tali Belakang. Didesain khusus untuk menahan bentuk hijabmu agar tetap rapi, tegak, dan tidak mudah bergeser, sekaligus memberikan kenyamanan ekstra di bagian kepala.

Spesifikasi Produk:

Model: Ciput Arab Klasik (tanpa cepol/konde) dengan tali pengikat di bagian belakang.
Bahan Utama: Kaos Rayon Premium.
Ukuran: All Size (dapat menyesuaikan bentuk dan ukuran kepala).',
    'metas' => NULL,
    'featured_image' => '079d8756-c133-4972-ac34-8ac9c6727c8d',
    'created_at' => '2026-06-01T06:24:35.000000Z',
    'updated_at' => '2026-06-20T05:49:55.000000Z',
    'deleted_at' => NULL,
    'attributes' => NULL,
  ),
  1 => 
  array (
    'id' => '27d5f158-c8b2-43df-b4f4-80ca3cfc6411',
    'user_id' => '1',
    'sku' => 'HIJAB-004-518',
    'type' => 'SIMPLE',
    'parent_id' => '10743503-4051-4c57-9679-558e9a7955a6',
    'name' => 'CIput Arab Tali Belakng Bahan rayon - Taupe',
    'slug' => 'ciput-arab-tali-belakng-bahan-rayon-taupe-6a1d28d99a4ae',
    'price' => '20000.00',
    'sale_price' => NULL,
    'status' => 'ACTIVE',
    'views_count' => 0,
    'weight' => 0,
    'stock_status' => 'IN_STOCK',
    'manage_stock' => 1,
    'publish_date' => NULL,
    'excerpt' => NULL,
    'body' => NULL,
    'metas' => NULL,
    'featured_image' => NULL,
    'created_at' => '2026-06-01T06:38:17.000000Z',
    'updated_at' => '2026-06-01T13:01:33.000000Z',
    'deleted_at' => NULL,
    'attributes' => 
    array (
      'color' => 'Taupe',
    ),
  ),
  2 => 
  array (
    'id' => '29372d62-3ee3-467f-848d-b40f8ae0545c',
    'user_id' => '1',
    'sku' => 'HIJAB-003-5',
    'type' => 'SIMPLE',
    'parent_id' => '8fd9973c-8f83-489d-ba93-570bbeb5eafb',
    'name' => 'Pashmina inner ninja oval spandex - Light Grey',
    'slug' => 'pashmina-inner-ninja-oval-spandex-light-grey-6a1d186532066',
    'price' => '4000.00',
    'sale_price' => NULL,
    'status' => 'ACTIVE',
    'views_count' => 0,
    'weight' => 0,
    'stock_status' => 'IN_STOCK',
    'manage_stock' => 1,
    'publish_date' => NULL,
    'excerpt' => NULL,
    'body' => NULL,
    'metas' => NULL,
    'featured_image' => NULL,
    'created_at' => '2026-06-01T05:28:05.000000Z',
    'updated_at' => '2026-06-01T05:48:04.000000Z',
    'deleted_at' => NULL,
    'attributes' => 
    array (
      'color' => 'Light Grey',
    ),
  ),
  3 => 
  array (
    'id' => '2dedfe16-5aea-4129-8b33-636ac3ead9f0',
    'user_id' => '1',
    'sku' => 'HIJAB-002-2',
    'type' => 'SIMPLE',
    'parent_id' => '86347aca-6f8f-4ac6-9f46-462aad1eff7c',
    'name' => 'Ceruty  - BIru',
    'slug' => 'ceruty-biru-6a1bdd62271f2',
    'price' => '45000.00',
    'sale_price' => NULL,
    'status' => 'ACTIVE',
    'views_count' => 0,
    'weight' => 0,
    'stock_status' => 'IN_STOCK',
    'manage_stock' => 1,
    'publish_date' => NULL,
    'excerpt' => NULL,
    'body' => NULL,
    'metas' => NULL,
    'featured_image' => NULL,
    'created_at' => '2026-05-31T07:04:02.000000Z',
    'updated_at' => '2026-06-01T05:54:41.000000Z',
    'deleted_at' => NULL,
    'attributes' => 
    array (
      'color' => 'BIru',
    ),
  ),
  4 => 
  array (
    'id' => '3bcee996-8a0e-4cab-837a-16a8477329a5',
    'user_id' => '1',
    'sku' => 'HIJAB-002-1',
    'type' => 'SIMPLE',
    'parent_id' => '86347aca-6f8f-4ac6-9f46-462aad1eff7c',
    'name' => 'Ceruty  - Merah',
    'slug' => 'ceruty-merah-6a1bdd6225ff0',
    'price' => '45000.00',
    'sale_price' => NULL,
    'status' => 'ACTIVE',
    'views_count' => 0,
    'weight' => 0,
    'stock_status' => 'OUT_OF_STOCK',
    'manage_stock' => 1,
    'publish_date' => NULL,
    'excerpt' => NULL,
    'body' => NULL,
    'metas' => NULL,
    'featured_image' => NULL,
    'created_at' => '2026-05-31T07:04:02.000000Z',
    'updated_at' => '2026-06-19T06:01:47.000000Z',
    'deleted_at' => NULL,
    'attributes' => 
    array (
      'color' => 'Merah',
    ),
  ),
  5 => 
  array (
    'id' => '42934933-92b1-4a2b-b3ae-a6fdb7a264da',
    'user_id' => '1',
    'sku' => 'HIJAB-003-9',
    'type' => 'SIMPLE',
    'parent_id' => '8fd9973c-8f83-489d-ba93-570bbeb5eafb',
    'name' => 'Pashmina inner ninja oval spandex - Grey',
    'slug' => 'pashmina-inner-ninja-oval-spandex-grey-6a1d186535c0d',
    'price' => '4000.00',
    'sale_price' => NULL,
    'status' => 'ACTIVE',
    'views_count' => 0,
    'weight' => 0,
    'stock_status' => 'IN_STOCK',
    'manage_stock' => 1,
    'publish_date' => NULL,
    'excerpt' => NULL,
    'body' => NULL,
    'metas' => NULL,
    'featured_image' => NULL,
    'created_at' => '2026-06-01T05:28:05.000000Z',
    'updated_at' => '2026-06-01T05:48:04.000000Z',
    'deleted_at' => NULL,
    'attributes' => 
    array (
      'color' => 'Grey',
    ),
  ),
  6 => 
  array (
    'id' => '599909a5-5f24-4c9b-afc7-c2b0bbaebee2',
    'user_id' => '1',
    'sku' => 'HIJAB-003-4',
    'type' => 'SIMPLE',
    'parent_id' => '8fd9973c-8f83-489d-ba93-570bbeb5eafb',
    'name' => 'Pashmina inner ninja oval spandex - Soft Cream',
    'slug' => 'pashmina-inner-ninja-oval-spandex-soft-cream-6a1d186530247',
    'price' => '4000.00',
    'sale_price' => NULL,
    'status' => 'ACTIVE',
    'views_count' => 0,
    'weight' => 0,
    'stock_status' => 'IN_STOCK',
    'manage_stock' => 1,
    'publish_date' => NULL,
    'excerpt' => NULL,
    'body' => NULL,
    'metas' => NULL,
    'featured_image' => NULL,
    'created_at' => '2026-06-01T05:28:05.000000Z',
    'updated_at' => '2026-06-01T05:48:04.000000Z',
    'deleted_at' => NULL,
    'attributes' => 
    array (
      'color' => 'Soft Cream',
    ),
  ),
  7 => 
  array (
    'id' => '70eafac4-5397-438d-853d-bb6d651cf874',
    'user_id' => '1',
    'sku' => 'HIJAB-003-3',
    'type' => 'SIMPLE',
    'parent_id' => '8fd9973c-8f83-489d-ba93-570bbeb5eafb',
    'name' => 'Pashmina inner ninja oval spandex - Frappucino',
    'slug' => 'pashmina-inner-ninja-oval-spandex-frappucino-6a1d18652ef78',
    'price' => '4000.00',
    'sale_price' => NULL,
    'status' => 'ACTIVE',
    'views_count' => 0,
    'weight' => 0,
    'stock_status' => 'IN_STOCK',
    'manage_stock' => 1,
    'publish_date' => NULL,
    'excerpt' => NULL,
    'body' => NULL,
    'metas' => NULL,
    'featured_image' => NULL,
    'created_at' => '2026-06-01T05:28:05.000000Z',
    'updated_at' => '2026-06-01T05:48:04.000000Z',
    'deleted_at' => NULL,
    'attributes' => 
    array (
      'color' => 'Frappucino',
    ),
  ),
  8 => 
  array (
    'id' => '7b53a15f-ac3c-496b-84f0-33a112aaac5f',
    'user_id' => '1',
    'sku' => 'HIJAB-002-3',
    'type' => 'SIMPLE',
    'parent_id' => '86347aca-6f8f-4ac6-9f46-462aad1eff7c',
    'name' => 'Ceruty  - Kuning',
    'slug' => 'ceruty-kuning-6a1bdd6228c88',
    'price' => '45000.00',
    'sale_price' => NULL,
    'status' => 'ACTIVE',
    'views_count' => 0,
    'weight' => 0,
    'stock_status' => 'IN_STOCK',
    'manage_stock' => 1,
    'publish_date' => NULL,
    'excerpt' => NULL,
    'body' => NULL,
    'metas' => NULL,
    'featured_image' => NULL,
    'created_at' => '2026-05-31T07:04:02.000000Z',
    'updated_at' => '2026-06-01T05:54:41.000000Z',
    'deleted_at' => NULL,
    'attributes' => 
    array (
      'color' => 'Kuning',
    ),
  ),
  9 => 
  array (
    'id' => '81b97dca-00d2-430c-a1c4-fd9a03c99be6',
    'user_id' => '1',
    'sku' => 'HIJAB-004-218',
    'type' => 'SIMPLE',
    'parent_id' => '10743503-4051-4c57-9679-558e9a7955a6',
    'name' => 'CIput Arab Tali Belakng Bahan rayon - Beige',
    'slug' => 'ciput-arab-tali-belakng-bahan-rayon-beige-6a1d28d997b4b',
    'price' => '20000.00',
    'sale_price' => NULL,
    'status' => 'ACTIVE',
    'views_count' => 0,
    'weight' => 0,
    'stock_status' => 'IN_STOCK',
    'manage_stock' => 1,
    'publish_date' => NULL,
    'excerpt' => NULL,
    'body' => NULL,
    'metas' => NULL,
    'featured_image' => NULL,
    'created_at' => '2026-06-01T06:38:17.000000Z',
    'updated_at' => '2026-06-01T13:01:33.000000Z',
    'deleted_at' => NULL,
    'attributes' => 
    array (
      'color' => 'Beige',
    ),
  ),
  10 => 
  array (
    'id' => '86347aca-6f8f-4ac6-9f46-462aad1eff7c',
    'user_id' => '1',
    'sku' => 'HIJAB-002',
    'type' => 'CONFIGURABLE',
    'parent_id' => NULL,
    'name' => 'Ceruty ',
    'slug' => 'ceruty',
    'price' => '45000.00',
    'sale_price' => '45000.00',
    'status' => 'ACTIVE',
    'views_count' => 9,
    'weight' => 650,
    'stock_status' => 'IN_STOCK',
    'manage_stock' => 1,
    'publish_date' => NULL,
    'excerpt' => 'Didesain untuk menghadirkan keanggunan yang tak berlebihan, Pashmina Ceruty Babydoll Solmè memadukan kelembutan material dengan siluet yang jatuh sempurna. Menggunakan ceruty babydoll pilihan, setiap helai terasa ringan, halus, dan nyaman menyentuh kulit.',
    'body' => 'Pashmina Ceruty Babydoll – Solmè 

Didesain untuk menghadirkan keanggunan yang tak berlebihan, Pashmina Ceruty Babydoll Solmè memadukan kelembutan material dengan siluet yang jatuh sempurna. Menggunakan ceruty babydoll pilihan, setiap helai terasa ringan, halus, dan nyaman menyentuh kulit.



Tekstur flowy-nya menciptakan drape yang rapi dan refined, memberikan kesan feminin dan sophisticated dalam setiap tampilan. Mudah dibentuk tanpa terlihat kaku, menjadikannya pilihan ideal untuk gaya eksklusif—baik untuk keseharian berkelas maupun momen istimewa.

Signature Details:

	•	Ceruty babydoll selected premium fabric

	•	Ultra soft, airy, dan breathable

	•	Jatuh natural dengan drape elegan

	•	Mudah ditata, tampilan selalu polished

	•	Finishing rapi untuk kesan mewah

 Product Details:

	•	Size: ± 180 x 75 cm

	•	Jahitan halus & presisi

	



 Timeless Elegance for Every Moment



Solmè

Effortless Luxury. Softly Refined.

NOTE :

	•	Warna pada foto dapat sedikit berbeda karena pencahayaan & layar',
    'metas' => NULL,
    'featured_image' => '2fdc9d4b-2508-4d96-9437-a3b0969a0ef0',
    'created_at' => '2026-05-31T07:00:39.000000Z',
    'updated_at' => '2026-06-19T06:36:59.000000Z',
    'deleted_at' => NULL,
    'attributes' => NULL,
  ),
  11 => 
  array (
    'id' => '87edb151-d50f-44e3-92b5-4b89e19e7784',
    'user_id' => '1',
    'sku' => 'HIJAB-003-10',
    'type' => 'SIMPLE',
    'parent_id' => '8fd9973c-8f83-489d-ba93-570bbeb5eafb',
    'name' => 'Pashmina inner ninja oval spandex - Hitam',
    'slug' => 'pashmina-inner-ninja-oval-spandex-hitam-6a1d186536d3d',
    'price' => '4000.00',
    'sale_price' => NULL,
    'status' => 'ACTIVE',
    'views_count' => 0,
    'weight' => 0,
    'stock_status' => 'IN_STOCK',
    'manage_stock' => 1,
    'publish_date' => NULL,
    'excerpt' => NULL,
    'body' => NULL,
    'metas' => NULL,
    'featured_image' => NULL,
    'created_at' => '2026-06-01T05:28:05.000000Z',
    'updated_at' => '2026-06-01T05:48:04.000000Z',
    'deleted_at' => NULL,
    'attributes' => 
    array (
      'color' => 'Hitam',
    ),
  ),
  12 => 
  array (
    'id' => '8b08abe3-4d06-49be-bb3d-49e46d9f7716',
    'user_id' => '1',
    'sku' => 'HIJAB-001-2',
    'type' => 'SIMPLE',
    'parent_id' => 'cdcd752e-334f-46f6-8274-d866f7eff3a6',
    'name' => 'Bella Sequare - Biru',
    'slug' => 'bella-sequare-biru-6a17ed264d9be',
    'price' => '48000.00',
    'sale_price' => NULL,
    'status' => 'ACTIVE',
    'views_count' => 0,
    'weight' => 0,
    'stock_status' => 'IN_STOCK',
    'manage_stock' => 1,
    'publish_date' => NULL,
    'excerpt' => NULL,
    'body' => NULL,
    'metas' => NULL,
    'featured_image' => NULL,
    'created_at' => '2026-05-28T07:22:14.000000Z',
    'updated_at' => '2026-06-13T06:25:10.000000Z',
    'deleted_at' => NULL,
    'attributes' => 
    array (
      'color' => 'Biru',
    ),
  ),
  13 => 
  array (
    'id' => '8fd9973c-8f83-489d-ba93-570bbeb5eafb',
    'user_id' => '1',
    'sku' => 'HIJAB-003',
    'type' => 'CONFIGURABLE',
    'parent_id' => NULL,
    'name' => 'Pashmina inner ninja oval spandex',
    'slug' => 'pashmina-inner-ninja-oval-spandex',
    'price' => '100000.00',
    'sale_price' => '40000.00',
    'status' => 'ACTIVE',
    'views_count' => 6,
    'weight' => 250,
    'stock_status' => 'IN_STOCK',
    'manage_stock' => 1,
    'publish_date' => NULL,
    'excerpt' => 'Pashmina Inner Ninja Oval Spandex
Pashmina instan 2-in-1 anti-ribet dengan inner ninja (menutup leher) yang sudah dijahit menyatu. Terbuat dari bahan Kaos Spandex Rayon berukuran 180 x 75 cm dengan potongan belakang oval yang anggun. Dilengkapi lubang telinga (glasses/mask friendly). Bahannya ringan, adem, tegak di dahi, dan tidak menerawang. Solusi tampil elegan dalam hitungan detik!',
    'body' => 'Pashmina Inner Ninja Oval Spandex (Tinggal Slup, Langsung Cantik!)
Didesain khusus untuk wanita aktif yang mengutamakan kepraktisan tanpa mengorbankan keanggunan. Pashmina ini adalah solusi tepat untuk tampil rapi dan tertutup seharian dengan sangat nyaman.

Spesifikasi Produk  bahan Utama: Kaos Spandex Rayon Premium (Karakteristik: Lembut, stretch, adem di kulit, menyerap keringat, dan ironless atau tidak mudah kusut).

Ukuran: 180 x 75 cm (Ukuran ideal untuk dikreasikan ke berbagai gaya syar\'i maupun kasual).
Desain 2-in-1 Praktis: Inner (ciput) model ninja yang menutupi leher sudah dijahit menyatu dengan pashmina.Bebas ribet mencari inner yang pas, anti-merosot, dan menghemat penggunaan jarum pentul.

Fitur Lubang Telinga (Smart Design), Terdapat lubang khusus di bagian telinga pada inner. Sangat memudahkan Anda untuk menggunakan kacamata, earphone/TWS, stetoskop, hingga masker medis earloop tanpa harus merusak tatanan hijab atau membuat telinga sakit. kemudian potongan belakang oval, Ujung pashmina didesain melengkung (oval), bukan lurus. Potongan ini memberikan siluet jatuh yang lebih anggun, flowy, dan memberikan penutupan area punggung yang lebih maksimal. Nyaman & Aman Seharian karena bahannya terasa ringan di kepala namun memiliki serat yang padat sehingga tidak menerawang. Sangat mudah dibentuk menyesuaikan lengkung wajah (membingkai wajah dengan cantik dan anti-tembem).',
    'metas' => NULL,
    'featured_image' => '799f5683-e2f8-4a82-b99f-bafab8573ec6',
    'created_at' => '2026-06-01T04:58:25.000000Z',
    'updated_at' => '2026-06-01T14:09:33.000000Z',
    'deleted_at' => NULL,
    'attributes' => NULL,
  ),
  14 => 
  array (
    'id' => 'a3d38aea-fba2-4893-8a9c-9fa1708eeecd',
    'user_id' => '1',
    'sku' => 'HIJAB-004-150',
    'type' => 'SIMPLE',
    'parent_id' => '10743503-4051-4c57-9679-558e9a7955a6',
    'name' => 'CIput Arab Tali Belakng Bahan rayon - Abu-abu Muda',
    'slug' => 'ciput-arab-tali-belakng-bahan-rayon-abu-abu-muda-6a1d28d99929e',
    'price' => '20000.00',
    'sale_price' => NULL,
    'status' => 'ACTIVE',
    'views_count' => 0,
    'weight' => 0,
    'stock_status' => 'IN_STOCK',
    'manage_stock' => 1,
    'publish_date' => NULL,
    'excerpt' => NULL,
    'body' => NULL,
    'metas' => NULL,
    'featured_image' => NULL,
    'created_at' => '2026-06-01T06:38:17.000000Z',
    'updated_at' => '2026-06-01T13:01:33.000000Z',
    'deleted_at' => NULL,
    'attributes' => 
    array (
      'color' => 'Abu-abu Muda',
    ),
  ),
  15 => 
  array (
    'id' => 'a5f4849d-b154-4157-96f0-a7340ccc771c',
    'user_id' => '1',
    'sku' => 'HIJAB-003-6',
    'type' => 'SIMPLE',
    'parent_id' => '8fd9973c-8f83-489d-ba93-570bbeb5eafb',
    'name' => 'Pashmina inner ninja oval spandex - Sage',
    'slug' => 'pashmina-inner-ninja-oval-spandex-sage-6a1d186532eda',
    'price' => '4000.00',
    'sale_price' => NULL,
    'status' => 'ACTIVE',
    'views_count' => 0,
    'weight' => 0,
    'stock_status' => 'IN_STOCK',
    'manage_stock' => 1,
    'publish_date' => NULL,
    'excerpt' => NULL,
    'body' => NULL,
    'metas' => NULL,
    'featured_image' => NULL,
    'created_at' => '2026-06-01T05:28:05.000000Z',
    'updated_at' => '2026-06-01T05:48:04.000000Z',
    'deleted_at' => NULL,
    'attributes' => 
    array (
      'color' => 'Sage',
    ),
  ),
  16 => 
  array (
    'id' => 'a623e76c-1f8e-4e2b-847e-645bab5e44f7',
    'user_id' => '1',
    'sku' => 'HIJAB-004-531',
    'type' => 'SIMPLE',
    'parent_id' => '10743503-4051-4c57-9679-558e9a7955a6',
    'name' => 'CIput Arab Tali Belakng Bahan rayon - Cokelat',
    'slug' => 'ciput-arab-tali-belakng-bahan-rayon-cokelat-6a1d28d99b6cc',
    'price' => '20000.00',
    'sale_price' => NULL,
    'status' => 'ACTIVE',
    'views_count' => 0,
    'weight' => 0,
    'stock_status' => 'IN_STOCK',
    'manage_stock' => 1,
    'publish_date' => NULL,
    'excerpt' => NULL,
    'body' => NULL,
    'metas' => NULL,
    'featured_image' => NULL,
    'created_at' => '2026-06-01T06:38:17.000000Z',
    'updated_at' => '2026-06-01T13:01:33.000000Z',
    'deleted_at' => NULL,
    'attributes' => 
    array (
      'color' => 'Cokelat',
    ),
  ),
  17 => 
  array (
    'id' => 'af82f5c5-f80a-4480-bab7-0c4c14aa9f71',
    'user_id' => '1',
    'sku' => 'HIJAB-005',
    'type' => 'CONFIGURABLE',
    'parent_id' => NULL,
    'name' => 'ilbab Instan Bergo Malika Pinguin Lebel Besi Pinguin / Bergo Instan Jersey Ukuran M / Kerudung Wanita / Urwah Al Bariqi',
    'slug' => 'ilbab-instan-bergo-malika-pinguin-lebel-besi-pinguin-bergo-instan-jersey-ukuran-m-kerudung-wanita-urwah-al-bariqi',
    'price' => '23000.00',
    'sale_price' => NULL,
    'status' => 'ACTIVE',
    'views_count' => 11,
    'weight' => 190,
    'stock_status' => 'IN_STOCK',
    'manage_stock' => 1,
    'publish_date' => NULL,
    'excerpt' => '',
    'body' => '● 𝐁𝐚𝐡𝐚𝐧                         : 𝐉𝐞𝐫𝐬𝐞𝐲 𝐏𝐫𝐞𝐦𝐢𝐮𝐦

● 𝐔𝐤𝐮𝐫𝐚𝐧                       : 𝐌 ( 𝐃𝐞𝐰𝐚𝐬𝐚 ) 

● 𝐏𝐚𝐧𝐣𝐚𝐧𝐠 𝐃𝐞𝐩𝐚𝐧         : 𝟔𝟓 𝐂𝐦

● 𝐏𝐚𝐧𝐣𝐚𝐧𝐠 𝐁𝐞𝐥𝐚𝐤𝐚𝐧𝐠    : 𝟕𝟓 𝐂𝐦

● 𝐋𝐢𝐧𝐠𝐤𝐚𝐫 𝐖𝐚𝐣𝐚𝐡           : +/- 𝟓𝟐 - 𝟓𝟓 𝐂𝐦 



● 𝐁𝐚𝐡𝐚𝐧 : 𝐉𝐞𝐫𝐬𝐞𝐲 𝐏𝐫𝐞𝐦𝐢𝐮𝐦

● 𝐍𝐲𝐚𝐦𝐚𝐧 𝐃𝐢 𝐆𝐮𝐧𝐚𝐤𝐚𝐧 𝐃𝐢 𝐬𝐞𝐠𝐚𝐥𝐚 𝐂𝐮𝐚𝐜𝐚

● 𝐋𝐨𝐨𝐤 𝐊𝐚𝐬𝐮𝐚𝐥 𝐒𝐢𝐦𝐩𝐞𝐥 𝐌𝐮𝐝𝐚𝐡 𝐃𝐢 𝐏𝐚𝐤𝐚𝐢

● 𝐍𝐲𝐚𝐦𝐚𝐧 𝐃𝐢 𝐩𝐚𝐤𝐚𝐢 𝐔𝐧𝐭𝐮𝐤 𝐀𝐤𝐭𝐢𝐟𝐢𝐭𝐚𝐬 𝐈𝐧𝐝𝐨𝐨𝐫 𝐌𝐚𝐮𝐩𝐮𝐧 𝐎𝐮𝐭𝐝𝐨𝐨𝐫

● 𝐊𝐞𝐫𝐮𝐝𝐮𝐧𝐠 𝐈𝐧𝐬𝐭𝐚𝐧 𝐂𝐚𝐬𝐮𝐚𝐥 𝐃𝐞𝐧𝐠𝐚𝐢𝐧 𝐝𝐞𝐭𝐚𝐢𝐥 𝐉𝐚𝐡𝐢𝐭 𝐓𝐞𝐩𝐢 𝐃𝐚𝐧 𝐑𝐚𝐩𝐢



● 𝐊𝐮𝐚𝐥𝐢𝐭𝐚𝐬 𝐊𝐚𝐢𝐧 𝐏𝐫𝐞𝐦𝐢𝐮𝐦

𝟏. 𝐊𝐚𝐢𝐧 𝐓𝐞𝐛𝐚𝐥 𝐍𝐚𝐦𝐮𝐧 𝐑𝐢𝐧𝐠𝐚𝐧

𝟐. 𝐓𝐢𝐝𝐚𝐤 𝐍𝐞𝐫𝐚𝐰𝐚𝐧𝐠

𝟑. 𝐁𝐚𝐡𝐚𝐧 𝐌𝐞𝐥𝐚𝐫 , 𝐅𝐥𝐞𝐤𝐬𝐢𝐛𝐞𝐥 , 𝐋𝐞𝐦𝐛𝐮𝐭 𝐃𝐚𝐧 𝐉𝐚𝐭𝐮𝐡

𝟒. 𝐊𝐚𝐢𝐧𝐲𝐚 𝐓𝐢𝐝𝐚𝐤 𝐌𝐮𝐝𝐚𝐡 𝐊𝐮𝐬𝐮𝐭

𝟓. 𝐌𝐞𝐧𝐲𝐞𝐫𝐚𝐩 𝐊𝐞𝐫𝐢𝐧𝐠𝐚𝐭 𝐃𝐞𝐧𝐠𝐚𝐧 𝐁𝐚𝐢𝐤 ( 𝐀𝐝𝐞𝐦 ) 𝐓𝐢𝐝𝐚𝐤 𝐏𝐚𝐧𝐚𝐬 

𝟔. 𝐁𝐚𝐡𝐚𝐧 𝐀𝐰𝐞𝐭 , 𝐄𝐥𝐞𝐠𝐚𝐧 𝐖𝐚𝐥𝐚𝐮 𝐃𝐚𝐥𝐚𝐦 𝐰𝐚𝐤𝐭𝐮 𝐋𝐚𝐦𝐚

𝟕. 𝐓𝐞𝐫𝐣𝐚𝐦𝐢𝐧 𝐊𝐮𝐚𝐥𝐢𝐭𝐚𝐬 𝐊𝐚𝐢𝐧 𝐔𝐧𝐭𝐮𝐤 𝐊𝐞𝐧𝐲𝐚𝐦𝐚𝐧𝐚𝐧 𝐒𝐚𝐚𝐭 𝐃𝐢 𝐩𝐚𝐤𝐚𝐢



● 𝐓𝐢𝐦 𝐏𝐫𝐨𝐝𝐮𝐤𝐬𝐢 𝐘𝐚𝐧𝐠 𝐚𝐡𝐥𝐢 𝐃𝐚𝐧 𝐏𝐞𝐧𝐠𝐚𝐥𝐚𝐦𝐚𝐧 

● 𝐓𝐢𝐦 𝐐𝐜 𝐁𝐞𝐫𝐤𝐨𝐦𝐩𝐞𝐭𝐞𝐧 𝐔𝐧𝐭𝐮𝐤 𝐌𝐞𝐧𝐬𝐨𝐫𝐭𝐢𝐫 𝐏𝐫𝐨𝐝𝐮𝐤 𝐘𝐚𝐧𝐠 𝐑𝐢𝐣𝐞𝐤

● 𝐁𝐚𝐧𝐲𝐚𝐤 𝐕𝐨𝐜𝐞𝐫 

● 𝐃𝐢𝐬𝐤𝐨𝐧 𝐔𝐩 𝐓𝐨 𝟖𝟎%

● 𝐆𝐫𝐚𝐭𝐢𝐬 𝐇𝐚𝐝𝐢𝐚𝐡 

● 𝐏𝐫𝐨𝐝𝐮𝐤 𝐁𝐞𝐫𝐠𝐚𝐫𝐚𝐧𝐬𝐢 𝐒𝐞𝐫𝐭𝐚𝐤𝐚𝐧 𝐯𝐢𝐝𝐞𝐨 𝐔𝐧𝐛𝐨𝐱𝐢𝐧𝐠 𝐒𝐚𝐚𝐭 𝐊𝐨𝐦𝐩𝐥𝐚𝐢𝐧

● 𝐔𝐫𝐰𝐚𝐡 𝐀𝐥 𝐁𝐚𝐫𝐢𝐤𝐢',
    'metas' => NULL,
    'featured_image' => '3203a26e-1f8b-444c-9bfc-b886cf987be6',
    'created_at' => '2026-06-01T13:56:35.000000Z',
    'updated_at' => '2026-06-26T12:10:06.000000Z',
    'deleted_at' => NULL,
    'attributes' => NULL,
  ),
  18 => 
  array (
    'id' => 'bf9ef2c3-70a8-41d0-b656-36690a07601c',
    'user_id' => '1',
    'sku' => 'HIJAB-003-8',
    'type' => 'SIMPLE',
    'parent_id' => '8fd9973c-8f83-489d-ba93-570bbeb5eafb',
    'name' => 'Pashmina inner ninja oval spandex - Rosenude',
    'slug' => 'pashmina-inner-ninja-oval-spandex-rosenude-6a1d186534dc2',
    'price' => '4000.00',
    'sale_price' => NULL,
    'status' => 'ACTIVE',
    'views_count' => 0,
    'weight' => 0,
    'stock_status' => 'IN_STOCK',
    'manage_stock' => 1,
    'publish_date' => NULL,
    'excerpt' => NULL,
    'body' => NULL,
    'metas' => NULL,
    'featured_image' => NULL,
    'created_at' => '2026-06-01T05:28:05.000000Z',
    'updated_at' => '2026-06-01T05:48:04.000000Z',
    'deleted_at' => NULL,
    'attributes' => 
    array (
      'color' => 'Rosenude',
    ),
  ),
  19 => 
  array (
    'id' => 'c3d85248-6ef4-46c9-8af6-698f7061ce0b',
    'user_id' => '1',
    'sku' => 'HIJAB-003-1',
    'type' => 'SIMPLE',
    'parent_id' => '8fd9973c-8f83-489d-ba93-570bbeb5eafb',
    'name' => 'Pashmina inner ninja oval spandex - Milo',
    'slug' => 'pashmina-inner-ninja-oval-spandex-milo-6a1d18652b3a0',
    'price' => '4000.00',
    'sale_price' => NULL,
    'status' => 'ACTIVE',
    'views_count' => 0,
    'weight' => 0,
    'stock_status' => 'IN_STOCK',
    'manage_stock' => 1,
    'publish_date' => NULL,
    'excerpt' => NULL,
    'body' => NULL,
    'metas' => NULL,
    'featured_image' => NULL,
    'created_at' => '2026-06-01T05:28:05.000000Z',
    'updated_at' => '2026-06-01T05:48:04.000000Z',
    'deleted_at' => NULL,
    'attributes' => 
    array (
      'color' => 'Milo',
    ),
  ),
  20 => 
  array (
    'id' => 'caef024d-cb36-41fc-957f-c6619da44cf2',
    'user_id' => '1',
    'sku' => 'HIJAB-003-7',
    'type' => 'SIMPLE',
    'parent_id' => '8fd9973c-8f83-489d-ba93-570bbeb5eafb',
    'name' => 'Pashmina inner ninja oval spandex - Nude',
    'slug' => 'pashmina-inner-ninja-oval-spandex-nude-6a1d186534029',
    'price' => '4000.00',
    'sale_price' => NULL,
    'status' => 'ACTIVE',
    'views_count' => 0,
    'weight' => 0,
    'stock_status' => 'IN_STOCK',
    'manage_stock' => 1,
    'publish_date' => NULL,
    'excerpt' => NULL,
    'body' => NULL,
    'metas' => NULL,
    'featured_image' => NULL,
    'created_at' => '2026-06-01T05:28:05.000000Z',
    'updated_at' => '2026-06-01T05:48:04.000000Z',
    'deleted_at' => NULL,
    'attributes' => 
    array (
      'color' => 'Nude',
    ),
  ),
  21 => 
  array (
    'id' => 'cdcd752e-334f-46f6-8274-d866f7eff3a6',
    'user_id' => '1',
    'sku' => 'HIJAB-001',
    'type' => 'CONFIGURABLE',
    'parent_id' => NULL,
    'name' => 'paris Original Varisha',
    'slug' => 'bella-sequare',
    'price' => '50000.00',
    'sale_price' => '48000.00',
    'status' => 'ACTIVE',
    'views_count' => 10,
    'weight' => 250,
    'stock_status' => 'IN_STOCK',
    'manage_stock' => 1,
    'publish_date' => NULL,
    'excerpt' => 'Hadirkan siluet anggun dan feminin di setiap kesempatan dengan Pashmina eksklusif dari Gallery Puan. Menggunakan material Premium Ceruty Babydoll pilihan, pashmina ini memiliki tekstur pasir halus yang mewah, sangat ringan, dan jatuh (flowy) dengan indah saat dipakai. Memberikan efek drape yang sempurna untuk gaya kasual santai hingga tampilan elegan di acara formal.',
    'body' => 'Material: Premium Ceruty Babydoll.

Karakteristik: Jatuh (flowy), ringan, mudah di- styling dengan berbagai model, dan breathable.

Finishing: Jahit tepi standar butik yang sangat rapi dan rapat.

Ukuran: 180 x 75 cm (Ukuran panjang yang pas untuk berbagai style).

Catatan: Disarankan menggunakan inner/ciput karena material ceruty memiliki sifat sedikit menerawang.',
    'metas' => NULL,
    'featured_image' => 'aa3f4f5d-c967-4bb0-aece-3a9c1e150f96',
    'created_at' => '2026-05-28T07:19:01.000000Z',
    'updated_at' => '2026-06-20T08:31:14.000000Z',
    'deleted_at' => NULL,
    'attributes' => NULL,
  ),
  22 => 
  array (
    'id' => 'dfd90753-90b0-4e65-b417-483e3b1ed054',
    'user_id' => '1',
    'sku' => 'HIJAB-001-1',
    'type' => 'SIMPLE',
    'parent_id' => 'cdcd752e-334f-46f6-8274-d866f7eff3a6',
    'name' => 'Bella Sequare - Merah',
    'slug' => 'bella-sequare-merah-6a17ed264c05f',
    'price' => '48000.00',
    'sale_price' => NULL,
    'status' => 'ACTIVE',
    'views_count' => 0,
    'weight' => 0,
    'stock_status' => 'IN_STOCK',
    'manage_stock' => 1,
    'publish_date' => NULL,
    'excerpt' => NULL,
    'body' => NULL,
    'metas' => NULL,
    'featured_image' => NULL,
    'created_at' => '2026-05-28T07:22:14.000000Z',
    'updated_at' => '2026-06-13T06:25:10.000000Z',
    'deleted_at' => NULL,
    'attributes' => 
    array (
      'color' => 'Merah',
    ),
  ),
  23 => 
  array (
    'id' => 'e7e6f8c0-c093-4061-ba0e-f5bb3968c0b1',
    'user_id' => '1',
    'sku' => 'HIJAB-004-186',
    'type' => 'SIMPLE',
    'parent_id' => '10743503-4051-4c57-9679-558e9a7955a6',
    'name' => 'CIput Arab Tali Belakng Bahan rayon - Putih',
    'slug' => 'ciput-arab-tali-belakng-bahan-rayon-putih-6a1d28d999b8c',
    'price' => '20000.00',
    'sale_price' => NULL,
    'status' => 'ACTIVE',
    'views_count' => 0,
    'weight' => 0,
    'stock_status' => 'IN_STOCK',
    'manage_stock' => 1,
    'publish_date' => NULL,
    'excerpt' => NULL,
    'body' => NULL,
    'metas' => NULL,
    'featured_image' => NULL,
    'created_at' => '2026-06-01T06:38:17.000000Z',
    'updated_at' => '2026-06-01T13:01:33.000000Z',
    'deleted_at' => NULL,
    'attributes' => 
    array (
      'color' => 'Putih',
    ),
  ),
  24 => 
  array (
    'id' => 'f228615a-f316-4aa2-be41-2f6f2ddd877e',
    'user_id' => '1',
    'sku' => 'HIJAB-003-2',
    'type' => 'SIMPLE',
    'parent_id' => '8fd9973c-8f83-489d-ba93-570bbeb5eafb',
    'name' => 'Pashmina inner ninja oval spandex - Soft Cookies',
    'slug' => 'pashmina-inner-ninja-oval-spandex-soft-cookies-6a1d18652d54b',
    'price' => '4000.00',
    'sale_price' => NULL,
    'status' => 'ACTIVE',
    'views_count' => 0,
    'weight' => 0,
    'stock_status' => 'IN_STOCK',
    'manage_stock' => 1,
    'publish_date' => NULL,
    'excerpt' => NULL,
    'body' => NULL,
    'metas' => NULL,
    'featured_image' => NULL,
    'created_at' => '2026-06-01T05:28:05.000000Z',
    'updated_at' => '2026-06-01T05:48:04.000000Z',
    'deleted_at' => NULL,
    'attributes' => 
    array (
      'color' => 'Soft Cookies',
    ),
  ),
  25 => 
  array (
    'id' => 'f7004a83-3ef5-4342-93c0-3a009ea0f9df',
    'user_id' => '1',
    'sku' => 'HIJAB-001-3',
    'type' => 'SIMPLE',
    'parent_id' => 'cdcd752e-334f-46f6-8274-d866f7eff3a6',
    'name' => 'Bella Sequare - Cream',
    'slug' => 'bella-sequare-cream-6a17ed264eae9',
    'price' => '48000.00',
    'sale_price' => NULL,
    'status' => 'ACTIVE',
    'views_count' => 0,
    'weight' => 0,
    'stock_status' => 'IN_STOCK',
    'manage_stock' => 1,
    'publish_date' => NULL,
    'excerpt' => NULL,
    'body' => NULL,
    'metas' => NULL,
    'featured_image' => NULL,
    'created_at' => '2026-05-28T07:22:14.000000Z',
    'updated_at' => '2026-06-13T06:25:10.000000Z',
    'deleted_at' => NULL,
    'attributes' => 
    array (
      'color' => 'Cream',
    ),
  ),
);
        foreach(array_chunk($products, 10) as $chunk) {
            DB::table('shop_products')->insert($chunk);
        }

        $product_images = array (
  0 => 
  array (
    'id' => '079d8756-c133-4972-ac34-8ac9c6727c8d',
    'product_id' => '10743503-4051-4c57-9679-558e9a7955a6',
    'name' => 'Ciput Talibelakang.jpg',
    'created_at' => '2026-06-01T06:32:49.000000Z',
    'updated_at' => '2026-06-01T06:32:49.000000Z',
  ),
  1 => 
  array (
    'id' => '0cab0ba2-e621-46d7-a487-8fff2befdffc',
    'product_id' => '8fd9973c-8f83-489d-ba93-570bbeb5eafb',
    'name' => '5.png',
    'created_at' => '2026-06-01T05:27:54.000000Z',
    'updated_at' => '2026-06-01T05:27:54.000000Z',
  ),
  2 => 
  array (
    'id' => '2fdc9d4b-2508-4d96-9437-a3b0969a0ef0',
    'product_id' => '86347aca-6f8f-4ac6-9f46-462aad1eff7c',
    'name' => 'kauss.jpg',
    'created_at' => '2026-05-31T07:04:20.000000Z',
    'updated_at' => '2026-05-31T07:04:20.000000Z',
  ),
  3 => 
  array (
    'id' => '3203a26e-1f8b-444c-9bfc-b886cf987be6',
    'product_id' => 'af82f5c5-f80a-4480-bab7-0c4c14aa9f71',
    'name' => 'inspirasi hijab modern cek disini 👇👇 https___shope_ee_20Jczw1TuG.jpg',
    'created_at' => '2026-06-01T13:57:33.000000Z',
    'updated_at' => '2026-06-01T13:57:33.000000Z',
  ),
  4 => 
  array (
    'id' => '63285368-0724-4500-ae36-25f25ea13ca6',
    'product_id' => '10743503-4051-4c57-9679-558e9a7955a6',
    'name' => 'l.jpg',
    'created_at' => '2026-06-01T06:32:53.000000Z',
    'updated_at' => '2026-06-01T06:32:53.000000Z',
  ),
  5 => 
  array (
    'id' => '799f5683-e2f8-4a82-b99f-bafab8573ec6',
    'product_id' => '8fd9973c-8f83-489d-ba93-570bbeb5eafb',
    'name' => '6.png',
    'created_at' => '2026-06-01T05:27:29.000000Z',
    'updated_at' => '2026-06-01T05:27:29.000000Z',
  ),
  6 => 
  array (
    'id' => '98b755cd-b0bb-46fa-88a7-a799a4a86431',
    'product_id' => '8fd9973c-8f83-489d-ba93-570bbeb5eafb',
    'name' => '3.png',
    'created_at' => '2026-06-01T05:27:46.000000Z',
    'updated_at' => '2026-06-01T05:27:46.000000Z',
  ),
  7 => 
  array (
    'id' => 'aa3f4f5d-c967-4bb0-aece-3a9c1e150f96',
    'product_id' => 'cdcd752e-334f-46f6-8274-d866f7eff3a6',
    'name' => 'Hijab segiempat paris jadul 𝙊𝙍𝙄 𝙑𝙖𝙧𝙞𝙨𝙝𝙖.jpg',
    'created_at' => '2026-05-28T07:20:12.000000Z',
    'updated_at' => '2026-05-28T07:20:12.000000Z',
  ),
  8 => 
  array (
    'id' => 'c1c8fe4f-7cb6-4711-837a-878341baf909',
    'product_id' => '8fd9973c-8f83-489d-ba93-570bbeb5eafb',
    'name' => '2.png',
    'created_at' => '2026-06-01T05:27:42.000000Z',
    'updated_at' => '2026-06-01T05:27:42.000000Z',
  ),
  9 => 
  array (
    'id' => 'c90c453f-f07c-4856-9e2e-e0b0a2984a63',
    'product_id' => '8fd9973c-8f83-489d-ba93-570bbeb5eafb',
    'name' => '4.png',
    'created_at' => '2026-06-01T05:27:50.000000Z',
    'updated_at' => '2026-06-01T05:27:50.000000Z',
  ),
  10 => 
  array (
    'id' => 'cd4faf81-f943-4fca-9e2a-0321b3d126b9',
    'product_id' => '8fd9973c-8f83-489d-ba93-570bbeb5eafb',
    'name' => '1.png',
    'created_at' => '2026-06-01T05:27:38.000000Z',
    'updated_at' => '2026-06-01T05:27:38.000000Z',
  ),
  11 => 
  array (
    'id' => 'cfcff073-b7ca-4dd4-ab8a-dd6d7ab4a624',
    'product_id' => 'af82f5c5-f80a-4480-bab7-0c4c14aa9f71',
    'name' => 'INSTAN.jpg',
    'created_at' => '2026-06-01T13:57:26.000000Z',
    'updated_at' => '2026-06-01T13:57:26.000000Z',
  ),
);
        foreach(array_chunk($product_images, 10) as $chunk) {
            DB::table('shop_product_images')->insert($chunk);
        }

        $product_inventories = array (
  0 => 
  array (
    'id' => '22e937b0-821c-4a29-80c8-5f8869018610',
    'product_id' => 'c3d85248-6ef4-46c9-8af6-698f7061ce0b',
    'qty' => 5,
    'low_stock_threshold' => NULL,
    'created_at' => '2026-06-01T05:28:05.000000Z',
    'updated_at' => '2026-06-01T05:28:05.000000Z',
  ),
  1 => 
  array (
    'id' => '25c890f8-93fb-4cf2-bfd2-424cc9d8e741',
    'product_id' => '2dedfe16-5aea-4129-8b33-636ac3ead9f0',
    'qty' => 5,
    'low_stock_threshold' => NULL,
    'created_at' => '2026-05-31T07:04:02.000000Z',
    'updated_at' => '2026-05-31T07:04:02.000000Z',
  ),
  2 => 
  array (
    'id' => '2f75c553-099e-4024-bd84-eeee30d294d8',
    'product_id' => '86347aca-6f8f-4ac6-9f46-462aad1eff7c',
    'qty' => 9,
    'low_stock_threshold' => 2,
    'created_at' => '2026-05-31T07:04:02.000000Z',
    'updated_at' => '2026-06-19T06:01:47.000000Z',
  ),
  3 => 
  array (
    'id' => '32fc29fe-3514-43a4-b9c2-af4ad4be0f7b',
    'product_id' => '70eafac4-5397-438d-853d-bb6d651cf874',
    'qty' => 5,
    'low_stock_threshold' => NULL,
    'created_at' => '2026-06-01T05:28:05.000000Z',
    'updated_at' => '2026-06-01T05:28:05.000000Z',
  ),
  4 => 
  array (
    'id' => '3976d9e2-e7e6-4d30-beed-c570b921bc22',
    'product_id' => 'cdcd752e-334f-46f6-8274-d866f7eff3a6',
    'qty' => 13,
    'low_stock_threshold' => 2,
    'created_at' => '2026-05-28T07:22:14.000000Z',
    'updated_at' => '2026-05-31T07:10:48.000000Z',
  ),
  5 => 
  array (
    'id' => '434f1e65-8447-417e-8b6a-1834ffb9d528',
    'product_id' => 'a623e76c-1f8e-4e2b-847e-645bab5e44f7',
    'qty' => 7,
    'low_stock_threshold' => NULL,
    'created_at' => '2026-06-01T06:38:17.000000Z',
    'updated_at' => '2026-06-01T06:38:17.000000Z',
  ),
  6 => 
  array (
    'id' => '4f87099c-e551-4149-8722-1ab6c5d25709',
    'product_id' => '8b08abe3-4d06-49be-bb3d-49e46d9f7716',
    'qty' => 4,
    'low_stock_threshold' => NULL,
    'created_at' => '2026-05-28T07:22:14.000000Z',
    'updated_at' => '2026-05-28T08:27:38.000000Z',
  ),
  7 => 
  array (
    'id' => '534a9479-c91b-41d0-9410-5b4c21b58c60',
    'product_id' => '8fd9973c-8f83-489d-ba93-570bbeb5eafb',
    'qty' => 55,
    'low_stock_threshold' => 2,
    'created_at' => '2026-06-01T05:28:05.000000Z',
    'updated_at' => '2026-06-01T05:28:05.000000Z',
  ),
  8 => 
  array (
    'id' => '54a7b798-6978-4e9d-8e85-f9fb9778948b',
    'product_id' => 'f228615a-f316-4aa2-be41-2f6f2ddd877e',
    'qty' => 5,
    'low_stock_threshold' => NULL,
    'created_at' => '2026-06-01T05:28:05.000000Z',
    'updated_at' => '2026-06-01T05:28:05.000000Z',
  ),
  9 => 
  array (
    'id' => '558df629-cb0b-469d-8b34-48ad9da2ab78',
    'product_id' => '81b97dca-00d2-430c-a1c4-fd9a03c99be6',
    'qty' => 4,
    'low_stock_threshold' => NULL,
    'created_at' => '2026-06-01T06:38:17.000000Z',
    'updated_at' => '2026-06-16T12:06:30.000000Z',
  ),
  10 => 
  array (
    'id' => '5ec2449a-2437-4980-bdb6-05b827079184',
    'product_id' => 'caef024d-cb36-41fc-957f-c6619da44cf2',
    'qty' => 7,
    'low_stock_threshold' => NULL,
    'created_at' => '2026-06-01T05:28:05.000000Z',
    'updated_at' => '2026-06-01T05:28:05.000000Z',
  ),
  11 => 
  array (
    'id' => '61a2d243-5c53-4d99-91d8-f690c6a72d0c',
    'product_id' => '87edb151-d50f-44e3-92b5-4b89e19e7784',
    'qty' => 9,
    'low_stock_threshold' => NULL,
    'created_at' => '2026-06-01T05:28:05.000000Z',
    'updated_at' => '2026-06-01T05:28:05.000000Z',
  ),
  12 => 
  array (
    'id' => '6f98e1e4-5098-4cf7-b141-4e485fc81f85',
    'product_id' => 'f7004a83-3ef5-4342-93c0-3a009ea0f9df',
    'qty' => 4,
    'low_stock_threshold' => NULL,
    'created_at' => '2026-05-28T07:22:14.000000Z',
    'updated_at' => '2026-05-31T07:10:48.000000Z',
  ),
  13 => 
  array (
    'id' => '74e01440-3669-4b20-8908-d19f1c2ab398',
    'product_id' => 'bf9ef2c3-70a8-41d0-b656-36690a07601c',
    'qty' => 5,
    'low_stock_threshold' => NULL,
    'created_at' => '2026-06-01T05:28:05.000000Z',
    'updated_at' => '2026-06-01T05:28:05.000000Z',
  ),
  14 => 
  array (
    'id' => '80c35d57-390e-4a69-83fc-974bd51037c9',
    'product_id' => '3bcee996-8a0e-4cab-837a-16a8477329a5',
    'qty' => -1,
    'low_stock_threshold' => NULL,
    'created_at' => '2026-05-31T07:04:02.000000Z',
    'updated_at' => '2026-06-19T06:01:47.000000Z',
  ),
  15 => 
  array (
    'id' => '86226159-c279-4e48-a6a7-220583d36c03',
    'product_id' => '7b53a15f-ac3c-496b-84f0-33a112aaac5f',
    'qty' => 5,
    'low_stock_threshold' => NULL,
    'created_at' => '2026-05-31T07:04:02.000000Z',
    'updated_at' => '2026-05-31T07:04:02.000000Z',
  ),
  16 => 
  array (
    'id' => '9e39381e-05e2-455e-834e-876950420147',
    'product_id' => 'dfd90753-90b0-4e65-b417-483e3b1ed054',
    'qty' => 5,
    'low_stock_threshold' => NULL,
    'created_at' => '2026-05-28T07:22:14.000000Z',
    'updated_at' => '2026-05-28T08:26:08.000000Z',
  ),
  17 => 
  array (
    'id' => 'a6ec75c0-66ae-4a54-8de2-117f6856a758',
    'product_id' => '599909a5-5f24-4c9b-afc7-c2b0bbaebee2',
    'qty' => 5,
    'low_stock_threshold' => NULL,
    'created_at' => '2026-06-01T05:28:05.000000Z',
    'updated_at' => '2026-06-01T05:28:05.000000Z',
  ),
  18 => 
  array (
    'id' => 'bf297889-aa51-4c6b-af66-b6216aa22926',
    'product_id' => 'af82f5c5-f80a-4480-bab7-0c4c14aa9f71',
    'qty' => 30,
    'low_stock_threshold' => 2,
    'created_at' => '2026-06-01T13:58:05.000000Z',
    'updated_at' => '2026-06-01T13:58:05.000000Z',
  ),
  19 => 
  array (
    'id' => 'c591e159-4ab7-46e8-b563-39afdab5018d',
    'product_id' => '42934933-92b1-4a2b-b3ae-a6fdb7a264da',
    'qty' => 5,
    'low_stock_threshold' => NULL,
    'created_at' => '2026-06-01T05:28:05.000000Z',
    'updated_at' => '2026-06-01T05:28:05.000000Z',
  ),
  20 => 
  array (
    'id' => 'd185b1fc-577d-4f2e-82d4-3a67dc2e2e41',
    'product_id' => 'a3d38aea-fba2-4893-8a9c-9fa1708eeecd',
    'qty' => 6,
    'low_stock_threshold' => NULL,
    'created_at' => '2026-06-01T06:38:17.000000Z',
    'updated_at' => '2026-06-01T06:38:17.000000Z',
  ),
  21 => 
  array (
    'id' => 'd5fb686a-5821-495f-9f1e-ac540bce1733',
    'product_id' => '29372d62-3ee3-467f-848d-b40f8ae0545c',
    'qty' => 5,
    'low_stock_threshold' => NULL,
    'created_at' => '2026-06-01T05:28:05.000000Z',
    'updated_at' => '2026-06-01T05:28:05.000000Z',
  ),
  22 => 
  array (
    'id' => 'db0a6ce4-87a7-4261-b465-4a570b07719c',
    'product_id' => '10743503-4051-4c57-9679-558e9a7955a6',
    'qty' => 28,
    'low_stock_threshold' => 2,
    'created_at' => '2026-06-01T06:38:17.000000Z',
    'updated_at' => '2026-06-16T12:06:30.000000Z',
  ),
  23 => 
  array (
    'id' => 'e19ced0a-1287-42a1-a386-7b77db18d5ff',
    'product_id' => '27d5f158-c8b2-43df-b4f4-80ca3cfc6411',
    'qty' => 6,
    'low_stock_threshold' => NULL,
    'created_at' => '2026-06-01T06:38:17.000000Z',
    'updated_at' => '2026-06-01T06:38:17.000000Z',
  ),
  24 => 
  array (
    'id' => 'eeabbc74-0013-41a6-98cc-df6a22669a46',
    'product_id' => 'e7e6f8c0-c093-4061-ba0e-f5bb3968c0b1',
    'qty' => 6,
    'low_stock_threshold' => NULL,
    'created_at' => '2026-06-01T06:38:17.000000Z',
    'updated_at' => '2026-06-01T06:38:17.000000Z',
  ),
  25 => 
  array (
    'id' => 'f1f20c5d-04aa-409c-a539-2f5bb60345cf',
    'product_id' => 'a5f4849d-b154-4157-96f0-a7340ccc771c',
    'qty' => 5,
    'low_stock_threshold' => NULL,
    'created_at' => '2026-06-01T05:28:05.000000Z',
    'updated_at' => '2026-06-01T05:28:05.000000Z',
  ),
);
        foreach(array_chunk($product_inventories, 10) as $chunk) {
            DB::table('shop_product_inventories')->insert($chunk);
        }

        $categories_products = array (
  0 => 
  array (
    'product_id' => '10743503-4051-4c57-9679-558e9a7955a6',
    'category_id' => '02869d99-6d37-4462-a0dd-4989b6cc61b7',
  ),
  1 => 
  array (
    'product_id' => '86347aca-6f8f-4ac6-9f46-462aad1eff7c',
    'category_id' => '2b8ea3ca-abaf-4d35-b283-1315d18c306c',
  ),
  2 => 
  array (
    'product_id' => '8fd9973c-8f83-489d-ba93-570bbeb5eafb',
    'category_id' => '45b9ff82-dfd1-4eca-bdbb-2cbe88402d41',
  ),
  3 => 
  array (
    'product_id' => 'af82f5c5-f80a-4480-bab7-0c4c14aa9f71',
    'category_id' => '4439b4da-88e7-4472-816f-627edec65ad9',
  ),
  4 => 
  array (
    'product_id' => 'cdcd752e-334f-46f6-8274-d866f7eff3a6',
    'category_id' => '2b8ea3ca-abaf-4d35-b283-1315d18c306c',
  ),
);
        foreach(array_chunk($categories_products, 10) as $chunk) {
            DB::table('shop_categories_products')->insert($chunk);
        }

    }
}
