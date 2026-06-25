<div>
    <style>
        .history-slider {
            display: flex;
            overflow-x: auto;
            gap: 10px;
            padding-bottom: 10px;
            scrollbar-width: thin;
        }
        .history-item {
            flex: 0 0 calc(20% - 8px); /* Show 5 items */
            position: relative;
            border: 2px solid transparent;
            border-radius: 6px;
            overflow: hidden;
            transition: 0.2s;
        }
        .history-item img {
            width: 100%;
            height: 60px;
            object-fit: cover;
            cursor: pointer;
        }
        .history-item:hover {
            border-color: #C5A059;
            transform: scale(1.05);
        }
        .history-delete {
            position: absolute;
            top: 2px;
            right: 2px;
            background: rgba(220, 53, 69, 0.9);
            color: white;
            border: none;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
        }
        .history-delete:hover {
            background: #dc3545;
        }
        /* Custom scrollbar for slider */
        .history-slider::-webkit-scrollbar {
            height: 6px;
        }
        .history-slider::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 3px;
        }
    </style>
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Manage</div>
                    <h2 class="page-title">Konten Homepage</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            
            <div class="row row-cards">
                
                <!-- PENGATURAN IDENTITAS -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Identitas Website</h3>
                        </div>
                        <div class="card-body">
                            @if (session()->has('success_identity'))
                                <div class="alert alert-success">{{ session('success_identity') }}</div>
                            @endif
                            <form wire:submit.prevent="saveIdentity">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Logo Header & Footer</label>
                                        <div class="text-muted mb-2 small">Rekomendasi: Ukuran 1:1 (persegi), maks 2MB. Logo ini akan terhubung antara header dan footer.</div>
                                        @if ($new_site_logo)
                                            <img src="{{ $new_site_logo->temporaryUrl() }}" width="100" class="mb-2 rounded">
                                        @elseif ($site_logo)
                                            <img src="{{ asset($site_logo) }}" width="100" class="mb-2 rounded">
                                        @endif
                                        <input type="file" class="form-control mb-2" wire:model="new_site_logo" accept="image/*">
                                        @error('new_site_logo') <span class="text-danger small">{{ $message }}</span> @enderror
                                        
                                        @if(count($history_site_logo) > 0)
                                        <div class="mt-3">
                                            <span class="small fw-bold text-muted mb-1 d-block">Riwayat Logo</span>
                                            <div class="history-slider">
                                                @foreach($history_site_logo as $h_logo)
                                                    <div class="history-item">
                                                        <img src="{{ asset($h_logo->image_path) }}" wire:click="selectFromHistory('site_logo', '{{ $h_logo->image_path }}')" title="Gunakan gambar ini">
                                                        <button type="button" class="history-delete" wire:click.stop="deleteHistory({{ $h_logo->id }})" title="Hapus riwayat"><i class="bx bx-trash"></i></button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Logo Tab Browser (Favicon)</label>
                                        <div class="text-muted mb-2 small">Rekomendasi: Ukuran 512x512 pixel, format PNG/JPG, maks 1MB.</div>
                                        @if ($new_site_favicon)
                                            <img src="{{ $new_site_favicon->temporaryUrl() }}" width="50" class="mb-2 rounded">
                                        @elseif ($site_favicon)
                                            <img src="{{ asset($site_favicon) }}" width="50" class="mb-2 rounded">
                                        @endif
                                        <input type="file" class="form-control mb-2" wire:model="new_site_favicon" accept="image/*">
                                        @error('new_site_favicon') <span class="text-danger small">{{ $message }}</span> @enderror

                                        @if(count($history_site_favicon) > 0)
                                        <div class="mt-3">
                                            <span class="small fw-bold text-muted mb-1 d-block">Riwayat Favicon</span>
                                            <div class="history-slider">
                                                @foreach($history_site_favicon as $h_fav)
                                                    <div class="history-item">
                                                        <img src="{{ asset($h_fav->image_path) }}" wire:click="selectFromHistory('site_favicon', '{{ $h_fav->image_path }}')" title="Gunakan gambar ini">
                                                        <button type="button" class="history-delete" wire:click.stop="deleteHistory({{ $h_fav->id }})" title="Hapus riwayat"><i class="bx bx-trash"></i></button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="saveIdentity, new_site_logo, new_site_favicon">Simpan Identitas</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- PENGATURAN BANNER UTAMA -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Banner Utama (Hero Section)</h3>
                        </div>
                        <div class="card-body">
                            @if (session()->has('success_hero'))
                                <div class="alert alert-success">{{ session('success_hero') }}</div>
                            @endif
                            <form wire:submit.prevent="saveHero">
                                <div class="mb-3">
                                    <label class="form-label">Judul Banner (Gunakan &lt;br&gt; untuk baris baru)</label>
                                    <input type="text" class="form-control" wire:model="home_hero_title">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Subjudul / Deskripsi Banner</label>
                                    <textarea class="form-control" wire:model="home_hero_subtitle" rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Gambar Background Banner</label>
                                    <div class="text-muted mb-2 small">Rekomendasi: 1920x1080 pixel (Landscape), maks 3MB. Resolusi tinggi agar tidak pecah.</div>
                                    @if ($new_home_hero_image)
                                        <img src="{{ $new_home_hero_image->temporaryUrl() }}" class="img-fluid mb-2 rounded" style="max-height: 200px; object-fit: cover;">
                                    @elseif ($home_hero_image)
                                        <img src="{{ Str::startsWith($home_hero_image, 'http') ? $home_hero_image : asset($home_hero_image) }}" class="img-fluid mb-2 rounded" style="max-height: 200px; object-fit: cover;">
                                    @endif
                                    <input type="file" class="form-control mb-2" wire:model="new_home_hero_image" accept="image/*">

                                    @if(count($history_home_hero_image) > 0)
                                        <div class="mt-3">
                                            <span class="small fw-bold text-muted mb-1 d-block">Riwayat Background Banner (Geser untuk melihat)</span>
                                            <div class="history-slider">
                                                @foreach($history_home_hero_image as $h_hero)
                                                    <div class="history-item">
                                                        <img src="{{ asset($h_hero->image_path) }}" wire:click="selectFromHistory('home_hero_image', '{{ $h_hero->image_path }}')" title="Gunakan gambar ini">
                                                        <button type="button" class="history-delete" wire:click.stop="deleteHistory({{ $h_hero->id }})" title="Hapus riwayat"><i class="bx bx-trash"></i></button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="saveHero, new_home_hero_image">Simpan Banner</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- PENGATURAN PROMO TERBATAS -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Bagian Promo</h3>
                        </div>
                        <div class="card-body">
                            @if (session()->has('success_promo'))
                                <div class="alert alert-success">{{ session('success_promo') }}</div>
                            @endif
                            <form wire:submit.prevent="savePromo">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Label Promo (Badge)</label>
                                            <input type="text" class="form-control" wire:model="home_promo_badge" placeholder="Contoh: Promo Terbatas">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Judul Promo</label>
                                            <input type="text" class="form-control" wire:model="home_promo_title">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Deskripsi Promo</label>
                                            <textarea class="form-control" wire:model="home_promo_subtitle" rows="4"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Gambar Promo</label>
                                            <div class="text-muted mb-2 small">Rekomendasi: 800x800 pixel (Portrait/Persegi), maks 2MB.</div>
                                            @if ($new_home_promo_image)
                                                <img src="{{ $new_home_promo_image->temporaryUrl() }}" class="img-fluid mb-2 rounded" style="max-height: 250px; object-fit: cover;">
                                            @elseif ($home_promo_image)
                                                <div class="position-relative d-inline-block mb-2">
                                                    <img src="{{ Str::startsWith($home_promo_image, 'http') ? $home_promo_image : asset($home_promo_image) }}" class="img-fluid rounded" style="max-height: 250px; object-fit: cover;">
                                                    <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: 5px; right: 5px; padding: 2px 6px;" wire:click="removeActiveImage('home_promo_image')" title="Hapus foto aktif" onclick="confirm('Yakin ingin menghapus foto promo aktif ini?') || event.stopImmediatePropagation()"><i class="bx bx-trash"></i></button>
                                                </div>
                                            @endif
                                            <input type="file" class="form-control mb-2" wire:model="new_home_promo_image" accept="image/*">

                                            @if(count($history_home_promo_image) > 0)
                                                <div class="mt-3">
                                                    <span class="small fw-bold text-muted mb-1 d-block">Riwayat Gambar Promo</span>
                                                    <div class="history-slider">
                                                        @foreach($history_home_promo_image as $h_promo)
                                                            <div class="history-item">
                                                                <img src="{{ asset($h_promo->image_path) }}" wire:click="selectFromHistory('home_promo_image', '{{ $h_promo->image_path }}')" title="Gunakan gambar ini">
                                                                <button type="button" class="history-delete" wire:click.stop="deleteHistory({{ $h_promo->id }})" title="Hapus riwayat"><i class="bx bx-trash"></i></button>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="savePromo, new_home_promo_image">Simpan Promo</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- PENGATURAN TENTANG KAMI -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Bagian Tentang Kami</h3>
                        </div>
                        <div class="card-body">
                            @if (session()->has('success_about'))
                                <div class="alert alert-success">{{ session('success_about') }}</div>
                            @endif
                            <form wire:submit.prevent="saveAbout">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Judul Banner Utama (Hero)</label>
                                            <input type="text" class="form-control" wire:model="about_hero_title" placeholder="Contoh: Kecantikan dalam Balutan Kesantunan">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Subjudul Banner (Hero)</label>
                                            <textarea class="form-control" wire:model="about_hero_subtitle" rows="3" placeholder="Contoh: Hadir untuk menemani setiap langkah..."></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Judul Cerita Kami</label>
                                            <input type="text" class="form-control" wire:model="about_story_title" placeholder="Contoh: Cerita Kami">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Deskripsi Cerita Kami (bisa HTML atau text biasa)</label>
                                            <textarea class="form-control" wire:model="about_story_description" rows="5" placeholder="Contoh: Gallery Puan lahir dari sebuah keinginan sederhana..."></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Gambar Cerita Kami</label>
                                            <div class="text-muted mb-2 small">Rekomendasi: Gambar potrait atau landscape, maks 2MB.</div>
                                            @if ($new_about_story_image)
                                                <img src="{{ $new_about_story_image->temporaryUrl() }}" class="img-fluid mb-2 rounded" style="max-height: 250px; object-fit: cover;">
                                            @elseif ($about_story_image)
                                                <div class="position-relative d-inline-block mb-2">
                                                    <img src="{{ Str::startsWith($about_story_image, 'http') ? $about_story_image : asset($about_story_image) }}" class="img-fluid rounded" style="max-height: 250px; object-fit: cover;">
                                                    <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: 5px; right: 5px; padding: 2px 6px;" wire:click="removeActiveImage('about_story_image')" title="Hapus foto aktif" onclick="confirm('Yakin ingin menghapus foto cerita kami aktif ini?') || event.stopImmediatePropagation()"><i class="bx bx-trash"></i></button>
                                                </div>
                                            @endif
                                            <input type="file" class="form-control mb-2" wire:model="new_about_story_image" accept="image/*">

                                            @if(count($history_about_story_image) > 0)
                                                <div class="mt-3">
                                                    <span class="small fw-bold text-muted mb-1 d-block">Riwayat Gambar Cerita Kami</span>
                                                    <div class="history-slider">
                                                        @foreach($history_about_story_image as $h_about)
                                                            <div class="history-item">
                                                                <img src="{{ asset($h_about->image_path) }}" wire:click="selectFromHistory('about_story_image', '{{ $h_about->image_path }}')" title="Gunakan gambar ini">
                                                                <button type="button" class="history-delete" wire:click.stop="deleteHistory({{ $h_about->id }})" title="Hapus riwayat"><i class="bx bx-trash"></i></button>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="saveAbout, new_about_story_image">Simpan Tentang Kami</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- PENGATURAN EMAIL AFTER-SALES -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Pengaturan Email After-Sales</h3>
                        </div>
                        <div class="card-body">
                            @if (session()->has('success_email'))
                                <div class="alert alert-success">{{ session('success_email') }}</div>
                            @endif
                            <form wire:submit.prevent="saveEmail">
                                <div class="mb-4">
                                    <label class="form-label">Tips Perawatan Hijab (Dikirim setelah order selesai)</label>
                                    <div class="text-muted mb-2 small">Tuliskan tips perawatan secara normal (seperti menulis di catatan). Baris baru otomatis akan disesuaikan.</div>
                                    <textarea class="form-control" wire:model="email_care_tips" rows="8"></textarea>
                                </div>

                                <h4 class="mb-3 border-bottom pb-2">Pengaturan Hadiah Voucher (Otomatis Dibuat)</h4>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Awalan Kode Voucher</label>
                                        <input type="text" class="form-control" wire:model="voucher_prefix" placeholder="Contoh: PUAN-THANKS-">
                                        <div class="text-muted small mt-1">Sistem akan menambahkan 6 karakter acak di belakangnya.</div>
                                        @error('voucher_prefix') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Diskon (Persentase %)</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" wire:model="voucher_discount" min="1" max="100">
                                            <span class="input-group-text">%</span>
                                        </div>
                                        @error('voucher_discount') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Masa Berlaku (Hari)</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" wire:model="voucher_days" min="1">
                                            <span class="input-group-text">Hari</span>
                                        </div>
                                        @error('voucher_days') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="text-end mt-2">
                                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="saveEmail">Simpan Pengaturan Email</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- PENGATURAN GALERI ESTETIK -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Galeri Estetik (Tentang Kami)</h3>
                        </div>
                        <div class="card-body">
                            @if (session()->has('success_gallery'))
                                <div class="alert alert-success">{{ session('success_gallery') }}</div>
                            @endif

                            <div class="mb-4">
                                <form wire:submit.prevent="uploadGalleryImage">
                                    <label class="form-label">Tambah Foto Galeri Baru</label>
                                    <div class="d-flex gap-2 align-items-start">
                                        <div class="flex-grow-1">
                                            <input type="file" class="form-control" wire:model="new_gallery_image" accept="image/*">
                                            @error('new_gallery_image') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="uploadGalleryImage, new_gallery_image">
                                            <i class="bx bx-upload me-1"></i> Upload
                                        </button>
                                    </div>
                                    @if ($new_gallery_image)
                                        <div class="mt-2">
                                            <span class="small text-muted d-block mb-1">Preview:</span>
                                            <img src="{{ $new_gallery_image->temporaryUrl() }}" class="rounded" style="height: 100px; object-fit: cover;">
                                        </div>
                                    @endif
                                </form>
                            </div>

                            <div>
                                <label class="form-label">Daftar Foto Galeri Saat Ini</label>
                                @if(count($about_gallery_images) > 0)
                                    <div class="row g-3">
                                        @foreach($about_gallery_images as $gallery)
                                            <div class="col-6 col-md-3 col-lg-2">
                                                <div class="position-relative rounded overflow-hidden" style="border: 1px solid #ddd;">
                                                    <img src="{{ asset($gallery->image_path) }}" class="img-fluid w-100" style="height: 150px; object-fit: cover;">
                                                    <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: 5px; right: 5px; padding: 2px 6px;" wire:click="deleteGalleryImage({{ $gallery->id }})" title="Hapus foto ini" onclick="confirm('Yakin ingin menghapus foto ini?') || event.stopImmediatePropagation()">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="alert alert-info mb-0">Belum ada foto galeri yang diupload. Pada halaman depan akan ditampilkan foto default.</div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
