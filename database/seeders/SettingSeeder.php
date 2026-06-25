<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            // Identitas
            [
                'key'   => 'site_logo',
                'value' => 'themes/gallerypuan/assets/img/logo.jpg',
                'type'  => 'image'
            ],
            [
                'key'   => 'site_favicon',
                'value' => 'themes/gallerypuan/assets/img/logo.jpg',
                'type'  => 'image'
            ],
            
            // Hero Banner
            [
                'key'   => 'home_hero_title',
                'value' => 'Koleksi Hijab<br>Elegan & Nyaman',
                'type'  => 'text'
            ],
            [
                'key'   => 'home_hero_subtitle',
                'value' => 'Didesain dengan material premium yang sejuk. Sempurnakan penampilan harian dan momen spesialmu dengan koleksi warna pastel eksklusif dari Gallery Puan.',
                'type'  => 'textarea'
            ],
            [
                'key'   => 'home_hero_image',
                'value' => 'https://images.unsplash.com/photo-1584273143981-41c073dfe8f8?q=80&w=1974&auto=format&fit=crop',
                'type'  => 'image'
            ],
            
            // Promo Banner
            [
                'key'   => 'home_promo_badge',
                'value' => 'Promo Terbatas',
                'type'  => 'text'
            ],
            [
                'key'   => 'home_promo_title',
                'value' => 'Exclusive Bundle Raya',
                'type'  => 'text'
            ],
            [
                'key'   => 'home_promo_subtitle',
                'value' => 'Dapatkan harga spesial untuk pembelian paket bundle hijab pastel series. Pilihan sempurna untuk hadiah orang terkasih atau melengkapi koleksi harian Anda.',
                'type'  => 'textarea'
            ],
            [
                'key'   => 'home_promo_image',
                'value' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?q=80&w=2071&auto=format&fit=crop',
                'type'  => 'image'
            ],
            
            // Email
            [
                'key'   => 'email_care_tips',
                'value' => "1. Cuci Tangan dengan Air Dingin\nHindari mesin cuci untuk kain premium. Cuci dengan tangan menggunakan air dingin dan deterjen lembut agar serat kain tetap halus dan tidak melar.\n\n2. Hindari Panas Langsung Saat Menyetrika\nGunakan suhu rendah atau mode \"Sutera\" pada setrika. Letakkan kain tipis sebagai pelapis di antara setrika dan hijab.\n\n3. Simpan dalam Posisi Terlipat atau Digulung\nSimpan hijab dalam kondisi terlipat rapi atau digulung longgar di laci bersih dan kering.",
                'type'  => 'textarea'
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'type' => $setting['type']]
            );
        }
    }
}
