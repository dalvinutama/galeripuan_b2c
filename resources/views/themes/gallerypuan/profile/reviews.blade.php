@extends('themes.gallerypuan.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold"><i class="bx bx-star text-warning"></i> Ulasan Saya</h2>
            <p class="text-muted">Bagikan pengalaman belanja Anda dan bantu pelanggan lain memilih produk terbaik.</p>
        </div>
    </div>

    <div class="row">
        @include('themes.gallerypuan.components.profile-sidebar')

        <div class="col-md-9">
            
            <ul class="nav nav-tabs nav-fill mb-4" id="reviewTabs" role="tablist" style="border-bottom: 2px solid #E1DDD7;">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold text-dark" id="unreviewed-tab" data-bs-toggle="tab" data-bs-target="#unreviewed" type="button" role="tab" style="border:none; border-bottom: 3px solid #B8952E; background-color: transparent;">Menunggu Ulasan <span class="badge bg-danger rounded-pill ms-1">{{ count($unreviewed) }}</span></button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold text-muted" id="reviewed-tab" data-bs-toggle="tab" data-bs-target="#reviewed" type="button" role="tab" style="border:none; border-bottom: 3px solid transparent; background-color: transparent;" onclick="this.style.borderBottom='3px solid #B8952E'; this.style.color='#212529'; document.getElementById('unreviewed-tab').style.borderBottom='3px solid transparent'; document.getElementById('unreviewed-tab').style.color='#6c757d';">Riwayat Ulasan</button>
                </li>
            </ul>

            <div class="tab-content" id="reviewTabsContent">
                
                <div class="tab-pane fade show active" id="unreviewed" role="tabpanel">
                    @forelse ($unreviewed as $item)
                        <div class="card shadow-sm border-0 mb-3" style="border-radius: 12px;">
                            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    @php $pImgObj = $item['product']->images->first() ?? ($item['product']->parent ? $item['product']->parent->images->first() : null); @endphp
                                    <img src="{{ shop_product_image($pImgObj) }}" alt="Foto" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                                    <div>
                                        <h6 class="fw-bold mb-1" style="color: #4A3F35;">{{ $item['product']->name }}</h6>
                                        <p class="text-muted small mb-0">No. Order: <span class="text-primary">{{ $item['order']->code }}</span></p>
                                    </div>
                                </div>
                                <button class="btn text-white px-4" style="background-color: #8C7A6B; border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#modalReview-{{ $item['order']->id }}-{{ $item['product']->id }}">Tulis Ulasan</button>
                            </div>
                        </div>

                        <div class="modal fade" id="modalReview-{{ $item['order']->id }}-{{ $item['product']->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content" style="border-radius: 12px;">
                                    <div class="modal-header border-bottom-0">
                                        <h5 class="modal-title fw-bold">Nilai Produk</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('profile.reviews.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                        <input type="hidden" name="order_id" value="{{ $item['order']->id }}">
                                        <div class="modal-body pt-0 text-center">
                                            @php $pImgObjModal = $item['product']->images->first() ?? ($item['product']->parent ? $item['product']->parent->images->first() : null); @endphp
                                            <img src="{{ shop_product_image($pImgObjModal) }}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; margin-bottom: 15px;">
                                            <h6 class="fw-bold">{{ $item['product']->name }}</h6>
                                            
                                            <div class="my-4">
                                                <p class="mb-2 text-muted small">Beri Bintang (1-5)</p>
                                                <select name="rating" class="form-select w-50 mx-auto text-center" style="font-size: 1.2rem; color: #B8952E;" required>
                                                    <option value="5">⭐⭐⭐⭐⭐ Sangat Bagus</option>
                                                    <option value="4">⭐⭐⭐⭐ Bagus</option>
                                                    <option value="3">⭐⭐⭐ Lumayan</option>
                                                    <option value="2">⭐⭐ Kurang</option>
                                                    <option value="1">⭐ Sangat Buruk</option>
                                                </select>
                                            </div>

                                            <div class="text-start">
                                                <label class="form-label text-muted small">Bagaimana pengalamanmu dengan produk ini?</label>
                                                <textarea name="comment" class="form-control" rows="3" placeholder="Tulis komentar Anda di sini (opsional)..."></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top-0">
                                            <button type="submit" class="btn btn-warning w-100 fw-bold">Kirim Ulasan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bx bx-check-shield text-muted mb-3" style="font-size: 4rem; opacity: 0.3;"></i>
                            <h5 class="fw-bold text-muted">Belum ada produk yang perlu diulas</h5>
                            <p class="text-muted small">Selesaikan pesanan Anda terlebih dahulu untuk memberikan ulasan.</p>
                        </div>
                    @endforelse
                </div>

                <div class="tab-pane fade" id="reviewed" role="tabpanel">
                    @forelse ($reviewed as $rev)
                        <div class="card shadow-sm border-0 mb-3" style="border-radius: 12px;">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="d-flex align-items-center gap-3">
                                        @php $revImgObj = $rev->product ? ($rev->product->images->first() ?? ($rev->product->parent ? $rev->product->parent->images->first() : null)) : null; @endphp
                                        @if($revImgObj)
                                            <img src="{{ shop_product_image($revImgObj) }}" alt="Foto" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                        @endif
                                        <div>
                                            <h6 class="fw-bold mb-1" style="color: #4A3F35;">{{ $rev->product ? $rev->product->name : 'Produk Dihapus' }}</h6>
                                            <div class="text-warning small">
                                                @for($i=1; $i<=5; $i++)
                                                    <i class="bx {{ $i <= $rev->rating ? 'bxs-star' : 'bx-star' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-muted small">{{ \Carbon\Carbon::parse($rev->created_at)->format('d M Y') }}</span>
                                </div>
                                <div class="p-3 rounded" style="background-color: #FAF7F2;">
                                    <p class="mb-0 text-dark small">"{{ $rev->comment ?? 'Tidak ada komentar tertulis.' }}"</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bx bx-message-square-detail text-muted mb-3" style="font-size: 4rem; opacity: 0.3;"></i>
                            <h5 class="fw-bold text-muted">Belum ada riwayat ulasan</h5>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</div>
@endsection