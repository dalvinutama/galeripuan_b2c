<div>
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title fw-bold" style="color: #A47E1B;">
                        <i class='bx bx-message-dots me-2'></i> Pengaturan Chat
                    </h3>
                </div>

                @if(session('success'))
                    <div class="alert alert-success m-3">{{ session('success') }}</div>
                @endif

                <div class="card-body">
                    <div class="row">
                        {{-- SAPAAN OTOMATIS --}}
                        <div class="col-12 col-lg-6">
                            <div class="card mb-4 border shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="card-title m-0 fw-bold">
                                        <i class='bx bx-bot me-2' style="color: #A47E1B;"></i> Sapaan Otomatis
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="autoGreetingToggle" 
                                            wire:model="autoGreetingEnabled" style="cursor: pointer;">
                                        <label class="form-check-label" for="autoGreetingToggle" style="cursor: pointer;">
                                            Aktifkan sapaan otomatis
                                        </label>
                                        <small class="d-block text-muted mt-1">
                                            Saat pelanggan mengirim pesan pertama, sistem akan otomatis membalas dengan teks di bawah.
                                        </small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Teks Sapaan</label>
                                        <textarea wire:model="autoGreetingText" class="form-control" rows="3" 
                                            placeholder="Halo, ada yang bisa kami bantu?"
                                            style="border-color: #ddd; resize: vertical;"></textarea>
                                        <small class="text-muted">Maksimal 500 karakter</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Pesan Otomatis Setelah Pelanggan Memilih</label>
                                        <textarea wire:model="autoAckMessage" class="form-control" rows="3"
                                            placeholder="Terima kasih, pesan Anda sudah kami terima..."
                                            style="border-color: #ddd; resize: vertical;"></textarea>
                                        <small class="text-muted">
                                            Pesan ini akan otomatis terkirim setelah pelanggan mengklik salah satu pilihan pertanyaan.
                                        </small>
                                    </div>

                                    <button wire:click="saveAutoGreeting" class="btn px-4 text-white" 
                                        style="background-color: #A47E1B;">
                                        <i class='bx bx-save me-1'></i> Simpan
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- BALASAN CEPAT --}}
                        <div class="col-12 col-lg-6">
                            <div class="card mb-4 border shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="card-title m-0 fw-bold">
                                        <i class='bx bx-time-five me-2' style="color: #A47E1B;"></i> Balasan Cepat
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted small">
                                        Balasan cepat bisa digunakan saat admin membalas chat pelanggan.
                                        Cukup klik satu kali untuk langsung mengirim.
                                    </p>

                                    {{-- Daftar Balasan Cepat --}}
                                    @if(count($quickReplies) > 0)
                                        <div class="list-group mb-4">
                                            @foreach($quickReplies as $index => $reply)
                                                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <strong class="d-block text-dark">{{ $reply['label'] }}</strong>
                                                        <small class="text-muted">{{ Str::limit($reply['text'], 80) }}</small>
                                                    </div>
                                                    <button wire:click="deleteQuickReply({{ $index }})" 
                                                        wire:confirm="Hapus balasan cepat ini?"
                                                        class="btn btn-sm btn-link text-danger p-0 ms-2">
                                                        <i class='bx bx-trash'></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center text-muted py-3">
                                            <i class='bx bx-message-square-x fs-2 mb-2 d-block'></i>
                                            <small>Belum ada balasan cepat. Tambahkan di bawah.</small>
                                        </div>
                                    @endif

                                    {{-- Form Tambah --}}
                                    <hr>
                                    <h6 class="fw-bold mb-3">Tambah Balasan Cepat</h6>
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold">Label</label>
                                        <input type="text" wire:model="newReplyLabel" class="form-control" 
                                            placeholder="Misal: Salam, Ongkir, Stok" style="border-color: #ddd;">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold">Teks Balasan</label>
                                        <textarea wire:model="newReplyText" class="form-control" rows="2" 
                                            placeholder="Tulis teks balasan..."
                                            style="border-color: #ddd; resize: vertical;"></textarea>
                                    </div>
                                    <button wire:click="addQuickReply" class="btn px-4 text-white"
                                        style="background-color: #A47E1B;">
                                        <i class='bx bx-plus me-1'></i> Tambah
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- OPSI PELANGGAN --}}
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card border shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="card-title m-0 fw-bold">
                                        <i class='bx bx-list-ul me-2' style="color: #A47E1B;"></i> Opsi Pilihan untuk Pelanggan
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted small">
                                        Setelah auto-greeting terkirim, pelanggan akan melihat tombol-tombol pilihan di bawah chat.
                                        Pelanggan tinggal klik salah satu untuk melanjutkan percakapan.
                                    </p>

                                    @if(count($customerOptions) > 0)
                                        <div class="d-flex flex-wrap gap-2 mb-4">
                                            @foreach($customerOptions as $index => $opt)
                                            <div class="d-inline-flex align-items-center gap-1 rounded-pill px-3 py-2 shadow-sm"
                                                style="background-color: #FFF; border: 1.5px solid #A47E1B; font-size: 13px;">
                                                <span>{{ $opt }}</span>
                                                <button wire:click="deleteCustomerOption({{ $index }})"
                                                    wire:confirm="Hapus opsi ini?"
                                                    class="btn btn-sm btn-link text-danger p-0 ms-1">
                                                    <i class='bx bx-x'></i>
                                                </button>
                                            </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center text-muted py-3">
                                            <i class='bx bx-message-square-x fs-2 mb-2 d-block'></i>
                                            <small>Belum ada opsi untuk pelanggan.</small>
                                        </div>
                                    @endif

                                    <hr>
                                    <h6 class="fw-bold mb-3">Tambah Opsi Baru</h6>
                                    <div class="row g-2 align-items-center">
                                        <div class="col-8 col-md-6">
                                            <input type="text" wire:model="newCustomerOption" class="form-control"
                                                placeholder="Misal: Cek Status Pesanan" style="border-color: #ddd;">
                                        </div>
                                        <div class="col-4 col-md-3">
                                            <button wire:click="addCustomerOption" class="btn px-4 text-white"
                                                style="background-color: #A47E1B;">
                                                <i class='bx bx-plus me-1'></i> Tambah
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-control:focus {
            border-color: #A47E1B !important;
            box-shadow: 0 0 0 3px rgba(164,126,27,0.15) !important;
        }
        .form-check-input:checked {
            background-color: #A47E1B;
            border-color: #A47E1B;
        }
    </style>
</div>
