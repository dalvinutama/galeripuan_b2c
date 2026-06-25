@extends('themes.gallerypuan.layouts.app')

@section('content')

<style>
    :root {
        --gold-primary: #c49a45;
        --gold-hover: #b38a36;
        --light-bg: #fdfcf9;
    }

    body {
        background-color: var(--light-bg);
    }

    /* Ikon Judul Halaman */
    .page-icon-box {
        width: 48px;
        height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 2px solid var(--gold-primary);
        border-radius: 12px;
        color: var(--gold-primary);
        background-color: #fff;
    }

    /* Tombol Utama (Emas) */
    .btn-gold {
        background: var(--gold-primary);
        color: #fff;
        border-radius: 50px;
        padding: 8px 20px;
        font-weight: 600;
        transition: 0.3s;
        border: none;
    }
    .btn-gold:hover {
        background: var(--gold-hover);
        color: #fff;
        transform: translateY(-2px);
    }

    /* Card Alamat Custom */
    .address-card {
        border-radius: 12px;
        transition: all 0.3s ease;
        border: 1px solid #eaeaea;
        background: #ffffff;
    }
    .address-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
        border-color: var(--gold-primary);
    }
    .address-card.is-primary {
        border: 2px solid var(--gold-primary);
        background: #fffbf2; /* Warna latar belakang emas sangat tipis */
    }

    /* Tombol Aksi di Card */
    .btn-action-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    .btn-action-circle:hover {
        background-color: #f8f9fa;
        color: var(--gold-primary);
    }
    
    /* Input & Form Styling */
    .form-control:focus, .form-select:focus {
        border-color: var(--gold-primary);
        box-shadow: 0 0 0 0.25rem rgba(196, 154, 69, 0.25);
    }
    
    /* Header Card Transparan */
    .custom-header-transparent {
        background: transparent;
        border-bottom: 1px solid #eaeaea;
    }
</style>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12 d-flex align-items-center">
            <div class="page-icon-box shadow-sm me-3">
                <i class="bx bx-map fs-3"></i>
            </div>
            <div>
                <h2 class="fw-bold mb-0 text-dark" style="font-family: 'Playfair Display', serif;">Buku Alamat</h2>
                <p class="text-muted mb-0 small">Kelola daftar alamat pengiriman Anda.</p>
            </div>
        </div>
    </div>

    <div class="row">
        @include('themes.gallerypuan.components.profile-sidebar')

        <div class="col-md-9">
            <div class="card shadow-sm border-0 rounded-4" style="overflow: hidden;">
                
                <div class="card-header custom-header-transparent py-3 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">Daftar Alamat</h5>
                    <button class="btn btn-gold btn-sm d-flex align-items-center gap-1 shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahAlamatModal">
                        <i class="bx bx-plus fs-5"></i> Tambah Alamat Baru
                    </button>
                </div>

                <div class="card-body p-4 bg-white">
                    
                    <div class="row g-4">
                        @forelse($addresses as $address)
                            <div class="col-md-6">
                                <div class="card h-100 address-card position-relative {{ $address->is_primary ? 'is-primary shadow-sm' : 'shadow-sm' }}">
                                    
                                    <div class="position-absolute top-0 end-0 m-3 d-flex gap-2" style="z-index: 10;">
                                        <button type="button" class="btn btn-light border btn-action-circle shadow-sm" data-bs-toggle="modal" data-bs-target="#editAlamatModal{{ $address->id }}" title="Ubah Alamat">
                                            <i class='bx bx-edit text-secondary'></i>
                                        </button>
                                        <button type="button" class="btn btn-light border btn-action-circle shadow-sm" title="Hapus Alamat" onclick="confirmLuxury(event, 'delete-form-{{ $address->id }}', 'Hapus Alamat', 'Yakin ingin menghapus alamat ini secara permanen?', 'trash')">
                                            <i class='bx bx-trash text-danger'></i>
                                        </button>
                                    </div>
                                    
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center gap-2 mb-3">
                                            <span class="badge rounded-pill" style="background-color: #f1f3f5; color: #495057; border: 1px solid #e9ecef;">
                                                <i class="bx {{ $address->label == 'Rumah' ? 'bx-home' : ($address->label == 'Kantor' ? 'bx-building' : 'bx-map') }} me-1"></i>
                                                {{ $address->label }}
                                            </span>
                                            
                                            @if($address->is_primary)
                                                <span class="badge rounded-pill" style="background-color: #fff4e5; color: #b38a36; border: 1px solid #c49a45;">
                                                    <i class="bx bx-check me-1"></i> Utama
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <div class="mb-1">
                                            <h6 class="fw-bold mb-1 text-dark" style="font-size: 1.1rem;">{{ $address->first_name }} {{ $address->last_name }}</h6>
                                            <p class="text-muted mb-0 small d-flex align-items-center gap-1">
                                                <i class="bx bx-phone"></i> {{ $address->phone }}
                                            </p>
                                        </div>
                                        
                                        <hr class="text-muted" style="opacity: 0.15">
                                        
                                        <address class="mb-0 text-muted" style="font-size: 0.9rem; line-height: 1.6;">
                                            {{ $address->address1 }}<br>
                                            {{ $address->city }}, {{ $address->province }}<br>
                                            Kodepos: {{ $address->postcode }}
                                        </address>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <i class="bx bx-map-pin mb-3" style="font-size: 4.5rem; color: #e0e0e0;"></i>
                                <h5 class="fw-bold text-dark" style="font-family: 'Playfair Display', serif;">Belum Ada Alamat Tersimpan</h5>
                                <p class="text-muted mb-4">Tambahkan alamat pengiriman agar proses checkout belanja Anda menjadi lebih cepat dan mudah.</p>
                                <button class="btn btn-gold shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahAlamatModal">
                                    <i class="bx bx-plus me-1"></i> Tambah Alamat Sekarang
                                </button>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahAlamatModal" tabindex="-1" aria-labelledby="tambahAlamatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-dark" id="tambahAlamatModalLabel">
                    <i class="bx bx-map text-warning me-2"></i> Tambah Alamat Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('orders.checkout.address.store') }}" method="POST">
                @csrf
                <div class="modal-body px-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-semibold mb-1">Label Alamat</label>
                            <select name="label" class="form-select rounded-3">
                                <option value="Rumah">Rumah</option>
                                <option value="Kantor">Kantor</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-semibold mb-1">No. Telepon / WA *</label>
                            <input type="text" name="phone" class="form-control rounded-3" placeholder="Contoh: 08123456789" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-semibold mb-1">Nama Depan *</label>
                            <input type="text" name="first_name" class="form-control rounded-3" value="{{ auth()->user()->name }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-semibold mb-1">Nama Belakang</label>
                            <input type="text" name="last_name" class="form-control rounded-3" placeholder="(Opsional)">
                        </div>
                        
                        <div class="col-12 mt-3 mb-1">
                            <hr style="border-style: dashed; opacity: 0.15">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-semibold mb-1">Provinsi *</label>
                            <select name="province" class="form-select province-select rounded-3" data-target="#citySelectAdd" required>
                                <option value="">Loading Provinsi...</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-semibold mb-1">Kota / Kabupaten *</label>
                            <select name="city" class="form-select rounded-3" id="citySelectAdd" required>
                                <option value="">Pilih provinsi Terlebih Dahulu</option>
                            </select>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label text-muted small fw-semibold mb-1">Alamat Lengkap *</label>
                            <textarea name="address1" class="form-control rounded-3" rows="2" placeholder="Nama Jalan, Gedung, No. Rumah, RT/RW, Patokan" required></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-semibold mb-1">Kode Pos *</label>
                            <input type="number" name="postcode" class="form-control rounded-3" placeholder="Contoh: 12345" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4 border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-gold px-4">Simpan Alamat</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach ($addresses as $address)
<div class="modal fade" id="editAlamatModal{{ $address->id }}" tabindex="-1" aria-labelledby="editAlamatModalLabel{{ $address->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-dark" id="editAlamatModalLabel{{ $address->id }}">
                    <i class="bx bx-edit text-warning me-2"></i> Ubah Alamat
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('orders.checkout.address.update', $address->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body px-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-semibold mb-1">Label Alamat</label>
                            <select name="label" class="form-select rounded-3">
                                <option value="Rumah" {{ $address->label == 'Rumah' ? 'selected' : '' }}>Rumah</option>
                                <option value="Kantor" {{ $address->label == 'Kantor' ? 'selected' : '' }}>Kantor</option>
                                <option value="Lainnya" {{ $address->label == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-semibold mb-1">No. Telepon / WA *</label>
                            <input type="text" name="phone" class="form-control rounded-3" value="{{ $address->phone }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-semibold mb-1">Nama Depan *</label>
                            <input type="text" name="first_name" class="form-control rounded-3" value="{{ $address->first_name }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-semibold mb-1">Nama Belakang</label>
                            <input type="text" name="last_name" class="form-control rounded-3" value="{{ $address->last_name }}">
                        </div>
                        
                        <div class="col-12 mt-3 mb-1">
                            <hr style="border-style: dashed; opacity: 0.15">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-semibold mb-1">Provinsi *</label>
                            <select name="province" class="form-select province-select rounded-3" data-target="#citySelect{{ $address->id }}" data-selected="{{ $address->province_id }}|{{ $address->province }}" required>
                                <option value="">Loading Provinsi...</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-semibold mb-1">Kota / Kabupaten *</label>
                            <select name="city" class="form-select rounded-3" id="citySelect{{ $address->id }}" data-selected="{{ $address->city_id }}|{{ $address->city }}" required>
                                <option value="">Pilih Provinsi Terlebih Dahulu</option>
                            </select>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label text-muted small fw-semibold mb-1">Alamat Lengkap *</label>
                            <textarea name="address1" class="form-control rounded-3" rows="2" required>{{ $address->address1 }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-semibold mb-1">Kode Pos *</label>
                            <input type="number" name="postcode" class="form-control rounded-3" value="{{ $address->postcode }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4 border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-gold px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<form id="delete-form-{{ $address->id }}" action="{{ route('orders.checkout.address.destroy', $address->id) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endforeach

<script>
document.addEventListener('DOMContentLoaded', function() {
    const baseUrl = "{{ url('/') }}";

    // 1. Ambil Data Provinsi API Komerce
    fetch(baseUrl + '/orders/checkout/provinces')
        .then(res => res.json())
        .then(resData => {
            if (resData.error || (resData.meta && resData.meta.code !== 200)) {
                showLuxuryToast('Gagal', 'Masalah API: ' + (resData.error || resData.meta.message), 'error');
                document.querySelectorAll('.province-select').forEach(s => s.innerHTML = '<option value="">API Error / Limit Habis</option>');
                return;
            }

            let provinces = resData.data || resData;
            let options = '<option value="">-- Pilih Provinsi --</option>';
            
            if (Array.isArray(provinces) && provinces.length > 0) {
                provinces.forEach(p => {
                    options += `<option value="${p.id}|${p.name}">${p.name}</option>`;
                });
            } else {
                options = '<option value="">Data tidak tersedia</option>';
            }
            
            // Masukkan data provinsi ke semua form (Tambah & Edit)
            document.querySelectorAll('.province-select').forEach(select => {
                select.innerHTML = options;

                // FITUR PINTAR: Jika ini form Edit, otomatis pilih provinsi yang lama!
                let selectedValue = select.getAttribute('data-selected');
                if (selectedValue) {
                    select.value = selectedValue;
                    // Memicu trigger change agar kota otomatis ter-load
                    select.dispatchEvent(new Event('change', { bubbles: true }));
                }
            });
        })
        .catch(err => console.error("Gagal ambil provinsi:", err));

    // 2. Ambil Kota berdasarkan Provinsi Terpilih
    document.body.addEventListener('change', function(e) {
        if(e.target.classList.contains('province-select')) {
            let targetId = e.target.getAttribute('data-target');
            let citySelect = document.querySelector(targetId);
            let provId = e.target.value.split('|')[0];

            if(!provId) {
                citySelect.innerHTML = '<option value="">Pilih Provinsi Terlebih Dahulu</option>';
                return;
            }
            
            citySelect.innerHTML = '<option value="">Loading...</option>';

            fetch(baseUrl + '/orders/checkout/cities?province_id=' + provId)
                .then(res => res.json())
                .then(resData => {
                    let cities = resData.data || [];
                    let cityOptions = '<option value="">-- Pilih Kota --</option>';
                    
                    cities.forEach(c => {
                        cityOptions += `<option value="${c.id}|${c.name}">${c.name}</option>`;
                    });
                    
                    citySelect.innerHTML = cityOptions;

                    // FITUR PINTAR: Jika ini form Edit, otomatis pilih kota yang lama!
                    let selectedCity = citySelect.getAttribute('data-selected');
                    if (selectedCity) {
                        citySelect.value = selectedCity;
                    }
                });
        }
    });
});
</script>
@endsection