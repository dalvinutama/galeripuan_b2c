<?php

namespace App\Livewire\Admin\Setting;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;
use App\Models\SettingImage;
use Illuminate\Support\Facades\Storage;

class SettingIndex extends Component
{
    use WithFileUploads;

    // Identitas
    public $site_logo;
    public $new_site_logo;
    public $site_favicon;
    public $new_site_favicon;

    // Hero Section
    public $home_hero_title;
    public $home_hero_subtitle;
    public $home_hero_image;
    public $new_home_hero_image;

    // Promo Section
    public $home_promo_badge;
    public $home_promo_title;
    public $home_promo_subtitle;
    public $home_promo_image;
    public $new_home_promo_image;

    // About Section
    public $about_hero_title;
    public $about_hero_subtitle;
    public $about_story_title;
    public $about_story_description;
    public $about_story_image;
    public $new_about_story_image;

    // Gallery Section
    public $new_gallery_image;
    public $about_gallery_images = [];

    // Email Section
    public $email_care_tips;
    public $voucher_prefix;
    public $voucher_discount;
    public $voucher_days;

    // Profil Admin
    public $admin_name;
    public $admin_email;
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    // Histories
    public $history_site_logo = [];
    public $history_site_favicon = [];
    public $history_home_hero_image = [];
    public $history_home_promo_image = [];
    public $history_about_story_image = [];

    public function mount()
    {
        // Load admin profile
        $user = auth('admin')->user();
        $this->admin_name = $user?->name ?? '';
        $this->admin_email = $user?->email ?? '';

        // Load existing settings
        $this->site_logo = Setting::getValue('site_logo');
        $this->site_favicon = Setting::getValue('site_favicon');

        $this->home_hero_title = Setting::getValue('home_hero_title');
        $this->home_hero_subtitle = Setting::getValue('home_hero_subtitle');
        $this->home_hero_image = Setting::getValue('home_hero_image');

        $this->home_promo_badge = Setting::getValue('home_promo_badge');
        $this->home_promo_title = Setting::getValue('home_promo_title');
        $this->home_promo_subtitle = Setting::getValue('home_promo_subtitle');
        $this->home_promo_image = Setting::getValue('home_promo_image');

        $this->about_hero_title = Setting::getValue('about_hero_title') ?: 'Kecantikan dalam Balutan Kesantunan';
        $this->about_hero_subtitle = Setting::getValue('about_hero_subtitle') ?: 'Hadir untuk menemani setiap langkah muslimah tampil anggun, nyaman, dan percaya diri dalam segala suasana.';
        $this->about_story_title = Setting::getValue('about_story_title') ?: 'Cerita Kami';
        
        $defaultDesc = "<p class=\"text-luxury\">Gallery Puan lahir dari sebuah keinginan sederhana: menghadirkan koleksi hijab yang tidak hanya memenuhi syariat, tetapi juga menonjolkan estetika modern dan elegan. Kami percaya bahwa setiap wanita berhak merasa cantik dan istimewa.</p>\n<p class=\"text-luxury\">Oleh karena itu, kami selalu mengedepankan kualitas material premium, jahitan yang rapi, serta mengikuti perkembangan tren fashion muslimah masa kini. Kepuasan Anda adalah prioritas kami dalam merangkai keanggunan sejati.</p>";
        $this->about_story_description = Setting::getValue('about_story_description') ?: $defaultDesc;
        
        $this->about_story_image = Setting::getValue('about_story_image') ?: 'themes/gallerypuan/assets/img/product_single_01.jpg';

        $defaultCareTips = "1. Cuci Tangan dengan Air Dingin\nHindari mesin cuci untuk kain premium. Cuci dengan tangan menggunakan air dingin dan deterjen lembut agar serat kain tetap halus dan tidak melar.\n\n2. Hindari Panas Langsung Saat Menyetrika\nGunakan suhu rendah atau mode \"Sutera\" pada setrika. Letakkan kain tipis sebagai pelapis di antara setrika dan hijab.\n\n3. Simpan dalam Posisi Terlipat atau Digulung\nSimpan hijab dalam kondisi terlipat rapi atau digulung longgar di laci bersih dan kering.";
        $this->email_care_tips = Setting::getValue('email_care_tips') ?: $defaultCareTips;

        $this->voucher_prefix = Setting::getValue('after_sales_voucher_prefix', 'PUAN-THANKS-');
        $this->voucher_discount = Setting::getValue('after_sales_voucher_discount', 10);
        $this->voucher_days = Setting::getValue('after_sales_voucher_days', 30);

        $this->loadHistories();
        $this->loadGallery();
    }

    public function loadGallery()
    {
        $count = SettingImage::where('setting_key', 'about_gallery')->count();
        if ($count === 0) {
            $defaultImages = [
                'themes/gallerypuan/assets/img/product_single_01.jpg',
                'themes/gallerypuan/assets/img/product_single_02.jpg',
                'themes/gallerypuan/assets/img/product_single_03.jpg',
                'themes/gallerypuan/assets/img/product_single_04.jpg',
            ];
            foreach ($defaultImages as $img) {
                SettingImage::create([
                    'setting_key' => 'about_gallery',
                    'image_path' => $img
                ]);
            }
        }
        
        $this->about_gallery_images = SettingImage::where('setting_key', 'about_gallery')->orderBy('id', 'asc')->get();
    }

    public function loadHistories()
    {
        $this->history_site_logo = SettingImage::where('setting_key', 'site_logo')->orderBy('created_at', 'desc')->get();
        $this->history_site_favicon = SettingImage::where('setting_key', 'site_favicon')->orderBy('created_at', 'desc')->get();
        $this->history_home_hero_image = SettingImage::where('setting_key', 'home_hero_image')->orderBy('created_at', 'desc')->get();
        $this->history_home_promo_image = SettingImage::where('setting_key', 'home_promo_image')->orderBy('created_at', 'desc')->get();
        $this->history_about_story_image = SettingImage::where('setting_key', 'about_story_image')->orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.admin.setting.index')->layout('components.layouts.app');
    }

    public function saveProfile()
    {
        $this->validate([
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|max:255|unique:admins,email,' . auth()->id(),
            'current_password' => 'required_with:new_password|current_password:admin',
            'new_password' => 'nullable|string|min:8|confirmed',
        ], [
            'admin_name.required' => 'Nama admin wajib diisi.',
            'admin_email.required' => 'Email wajib diisi.',
            'admin_email.email' => 'Format email tidak valid.',
            'admin_email.unique' => 'Email sudah digunakan admin lain.',
            'current_password.required_with' => 'Password saat ini wajib diisi untuk mengganti password.',
            'current_password.current_password' => 'Password saat ini tidak cocok.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user = auth('admin')->user();
        if (!$user) {
            session()->flash('error', 'Admin tidak ditemukan.');
            return;
        }
        $user->name = $this->admin_name;
        $user->email = $this->admin_email;

        if ($this->new_password) {
            $user->password = bcrypt($this->new_password);
        }

        $user->save();

        $this->current_password = null;
        $this->new_password = null;
        $this->new_password_confirmation = null;

        session()->flash('success_profile', 'Profil admin berhasil diperbarui!');
    }

    public function saveIdentity()
    {
        if ($this->new_site_logo) {
            $path = $this->new_site_logo->store('settings', 'public');
            $fullPath = 'storage/' . $path;
            Setting::setValue('site_logo', $fullPath, 'image');
            $this->site_logo = $fullPath;
            $this->new_site_logo = null;
            $this->addToHistory('site_logo', $fullPath);
        }

        if ($this->new_site_favicon) {
            $path = $this->new_site_favicon->store('settings', 'public');
            $fullPath = 'storage/' . $path;
            Setting::setValue('site_favicon', $fullPath, 'image');
            $this->site_favicon = $fullPath;
            $this->new_site_favicon = null;
            $this->addToHistory('site_favicon', $fullPath);
        }

        $this->loadHistories();
        session()->flash('success_identity', 'Pengaturan Identitas berhasil disimpan!');
    }

    public function saveHero()
    {
        Setting::setValue('home_hero_title', $this->home_hero_title);
        Setting::setValue('home_hero_subtitle', $this->home_hero_subtitle);

        if ($this->new_home_hero_image) {
            $path = $this->new_home_hero_image->store('settings', 'public');
            $fullPath = 'storage/' . $path;
            Setting::setValue('home_hero_image', $fullPath, 'image');
            $this->home_hero_image = $fullPath;
            $this->new_home_hero_image = null;
            $this->addToHistory('home_hero_image', $fullPath);
        }

        $this->loadHistories();
        session()->flash('success_hero', 'Pengaturan Banner Utama berhasil disimpan!');
    }

    public function savePromo()
    {
        Setting::setValue('home_promo_badge', $this->home_promo_badge);
        Setting::setValue('home_promo_title', $this->home_promo_title);
        Setting::setValue('home_promo_subtitle', $this->home_promo_subtitle);

        if ($this->new_home_promo_image) {
            $path = $this->new_home_promo_image->store('settings', 'public');
            $fullPath = 'storage/' . $path;
            Setting::setValue('home_promo_image', $fullPath, 'image');
            $this->home_promo_image = $fullPath;
            $this->new_home_promo_image = null;
            $this->addToHistory('home_promo_image', $fullPath);
        }

        $this->loadHistories();
        session()->flash('success_promo', 'Pengaturan Promo berhasil disimpan!');
    }

    public function saveAbout()
    {
        Setting::setValue('about_hero_title', $this->about_hero_title);
        Setting::setValue('about_hero_subtitle', $this->about_hero_subtitle);
        Setting::setValue('about_story_title', $this->about_story_title);
        Setting::setValue('about_story_description', $this->about_story_description);

        if ($this->new_about_story_image) {
            $path = $this->new_about_story_image->store('settings', 'public');
            $fullPath = 'storage/' . $path;
            Setting::setValue('about_story_image', $fullPath, 'image');
            $this->about_story_image = $fullPath;
            $this->new_about_story_image = null;
            $this->addToHistory('about_story_image', $fullPath);
        }

        $this->loadHistories();
        session()->flash('success_about', 'Pengaturan Tentang Kami berhasil disimpan!');
    }

    public function saveEmail()
    {
        $this->validate([
            'voucher_prefix' => 'required|string|max:20',
            'voucher_discount' => 'required|numeric|min:1|max:100',
            'voucher_days' => 'required|numeric|min:1',
        ], [
            'voucher_prefix.required' => 'Awalan kode voucher wajib diisi.',
            'voucher_discount.required' => 'Nominal diskon wajib diisi.',
            'voucher_days.required' => 'Masa berlaku wajib diisi.',
        ]);

        Setting::setValue('email_care_tips', $this->email_care_tips);
        Setting::setValue('after_sales_voucher_prefix', $this->voucher_prefix);
        Setting::setValue('after_sales_voucher_discount', $this->voucher_discount);
        Setting::setValue('after_sales_voucher_days', $this->voucher_days);
        
        session()->flash('success_email', 'Pengaturan Email & Voucher berhasil disimpan!');
    }

    public function uploadGalleryImage()
    {
        $this->validate([
            'new_gallery_image' => 'required|image|max:2048'
        ], [
            'new_gallery_image.required' => 'Pilih gambar terlebih dahulu.',
            'new_gallery_image.image' => 'File harus berupa gambar.',
            'new_gallery_image.max' => 'Ukuran gambar maksimal 2MB.'
        ]);

        $path = $this->new_gallery_image->store('settings/gallery', 'public');
        $fullPath = 'storage/' . $path;
        
        SettingImage::create([
            'setting_key' => 'about_gallery',
            'image_path' => $fullPath
        ]);

        $this->new_gallery_image = null;
        $this->loadGallery();
        session()->flash('success_gallery', 'Foto galeri berhasil ditambahkan!');
    }

    public function deleteGalleryImage($id)
    {
        $image = SettingImage::find($id);
        if ($image && $image->setting_key === 'about_gallery') {
            $storagePath = str_replace('storage/', '', $image->image_path);
            Storage::disk('public')->delete($storagePath);
            $image->delete();
            
            $this->loadGallery();
            session()->flash('success_gallery', 'Foto galeri berhasil dihapus!');
        }
    }

    public function removeActiveImage($key)
    {
        Setting::setValue($key, null);
        if (property_exists($this, $key)) {
            $this->$key = null;
        }

        $flashKey = 'success_identity';
        if (str_contains($key, 'hero')) $flashKey = 'success_hero';
        if (str_contains($key, 'promo')) $flashKey = 'success_promo';
        if (str_contains($key, 'about')) $flashKey = 'success_about';

        session()->flash($flashKey, 'Gambar aktif berhasil dihapus!');
    }

    private function addToHistory($key, $path)
    {
        SettingImage::create([
            'setting_key' => $key,
            'image_path' => $path
        ]);

        // Keep only the last 10 images
        $count = SettingImage::where('setting_key', $key)->count();
        if ($count > 10) {
            $oldest = SettingImage::where('setting_key', $key)->orderBy('created_at', 'asc')->first();
            
            // Optionally delete file from storage if not used by current setting
            $currentSetting = Setting::where('key', $key)->first();
            if ($currentSetting && $currentSetting->value !== $oldest->image_path) {
                $storagePath = str_replace('storage/', '', $oldest->image_path);
                Storage::disk('public')->delete($storagePath);
            }
            
            $oldest->delete();
        }
    }

    public function selectFromHistory($key, $path)
    {
        Setting::setValue($key, $path, 'image');
        
        // Update local state
        if (property_exists($this, $key)) {
            $this->$key = $path;
        }

        $this->loadHistories();

        $flashKey = 'success_identity';
        if (str_contains($key, 'hero')) $flashKey = 'success_hero';
        if (str_contains($key, 'promo')) $flashKey = 'success_promo';
        if (str_contains($key, 'about')) $flashKey = 'success_about';

        session()->flash($flashKey, 'Gambar berhasil diganti dari riwayat!');
    }

    public function deleteHistory($id)
    {
        $history = SettingImage::find($id);
        if ($history) {
            $key = $history->setting_key;
            
            $currentSetting = Setting::where('key', $key)->first();
            if ($currentSetting && $currentSetting->value !== $history->image_path) {
                $storagePath = str_replace('storage/', '', $history->image_path);
                Storage::disk('public')->delete($storagePath);
            }
            
            $history->delete();
            $this->loadHistories();
        }
    }
}
