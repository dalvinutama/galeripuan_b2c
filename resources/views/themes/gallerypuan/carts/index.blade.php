@extends('themes.gallerypuan.layouts.app')

@section('content')
<style>
    .cart-page {
        background-color: #FAF8F5;
        font-family: 'Poppins', sans-serif;
        color: #333333;
    }
    .text-luxury { color: #4A3F35; }
    .text-gold { color: #BC9C6C; }
    
    .breadcrumb-section { background-color: #FAF8F5; }
    .breadcrumb-item a { color: #8C7A6B; text-decoration: none; transition: 0.3s; }
    .breadcrumb-item a:hover { color: #BC9C6C; }
    .breadcrumb-item.active { color: #4A3F35; font-weight: 500; }

    .premium-card {
        background: #FFFFFF;
        border: 1px solid #EFEBE7;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(74, 63, 53, 0.03);
    }

    /* Custom Checkbox Mewah */
    .custom-checkbox {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: #4A3F35;
    }

    /* Input Plus Minus Styling */
    .qty-group {
        display: inline-flex;
        align-items: center;
        background: #FFFFFF;
        border: 1px solid #EFEBE7;
        border-radius: 8px;
        overflow: hidden;
    }
    .qty-btn {
        background: #FAF8F5;
        border: none;
        color: #4A3F35;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.2s;
    }
    .qty-btn:hover { background: #EFEBE7; }
    .qty-input {
        width: 45px;
        border: none;
        text-align: center;
        font-weight: 600;
        font-size: 14px;
        color: #4A3F35;
        -moz-appearance: textfield;
    }
    .qty-input::-webkit-outer-spin-button,
    .qty-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Action Buttons */
    .btn-trash {
        color: #8C7A6B;
        background: transparent;
        border: none;
        padding: 5px;
        transition: 0.3s;
    }
    .btn-trash:hover { color: #DC3545; transform: scale(1.1); }

    .btn-luxury-primary {
        background-color: #4A3F35;
        color: #FFFFFF;
        border: 1px solid #4A3F35;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        box-shadow: 0 4px 14px rgba(74, 63, 53, 0.18);
        transition: all 0.3s ease;
        text-decoration: none;
    }
    .btn-luxury-primary:hover:not(.disabled) {
        background-color: #382F27;
        color: #FFFFFF;
        transform: translateY(-2px);
    }
    .btn-luxury-primary.disabled {
        background-color: #D1C7BD;
        border-color: #D1C7BD;
        cursor: not-allowed;
        box-shadow: none;
        pointer-events: none;
    }
    .btn-luxury-outline {
        background-color: transparent;
        color: #4A3F35;
        border: 1px solid #4A3F35;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-luxury-outline:hover {
        background-color: #4A3F35;
        color: #FFFFFF;
    }

    .sticky-sidebar { position: sticky; top: 20px; }
</style>

<div class="cart-page pb-5">
    <section class="breadcrumb-section py-3">
        <div class="container">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Keranjang Belanja</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="main-content pt-3">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="fw-bold text-luxury mb-0" style="font-family: 'Playfair Display', serif;">Keranjang Anda</h2>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-8 col-md-7">
                    <form action="{{ route('carts.update') }}" method="POST" id="cart-form">
                        @csrf
                        @method('PUT')
                        
                        <div class="premium-card p-0 overflow-hidden mb-4">
                            <div class="d-flex align-items-center p-3 p-md-4 border-bottom bg-light bg-opacity-50">
                                <input type="checkbox" class="custom-checkbox me-3" id="selectAll" checked>
                                <label for="selectAll" class="fw-bold text-luxury mb-0" style="cursor: pointer;">Pilih Semua Item</label>
                            </div>

                            <ul class="list-group list-group-flush">
                                @forelse ($cart->items as $item)
                                <li class="list-group-item p-3 p-md-4 product-row">
                                    <div class="row align-items-center g-3">
                                        
                                        <div class="col-auto d-flex align-items-center">
                                            <input type="checkbox" class="custom-checkbox item-check me-3" name="selected_items[]" value="{{ $item->id }}" data-price="{{ $item->product->has_sale_price ? $item->product->sale_price : $item->product->price }}" data-qty="{{ $item->qty }}" checked>
                                            
                                            @php
                                                $product = $item->product;
                                                $parentProduct = $product->parent_id ? $product->parent : null;
                                                $productLink = $parentProduct ? shop_product_link($parentProduct) : shop_product_link($product);
                                                $productImageObj = $product->images->first() ?? ($parentProduct ? $parentProduct->images->first() : null);
                                            @endphp
                                            <img src="{{ shop_product_image($productImageObj, 'img-thumb') }}" alt="{{ $item->product->name }}" class="shadow-sm" style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px; border: 1px solid #EFEBE7;">
                                        </div>

                                        <div class="col">
                                            <a href="{{ $productLink }}" class="text-decoration-none text-luxury fw-bold mb-1 d-block" style="font-size: 15px;">
                                                {{ $item->product->name }}
                                            </a>
                                            @if($item->attributes && count($item->attributes) > 0)
                                                <div class="text-muted small mb-1">
                                                    @foreach($item->attributes as $key => $val)
                                                        <span class="me-2">{{ ucfirst($key == 'color' ? 'Warna' : $key) }}: <span class="fw-bold">{{ $val }}</span></span>
                                                    @endforeach
                                                </div>
                                            @endif
                                            <div class="mb-2">
                                                @if ($item->product->has_sale_price)
                                                    <span class="fw-bold text-dark">Rp {{ number_format($item->product->sale_price, 0, ',', '.') }}</span>
                                                    <span class="text-muted text-decoration-line-through small ms-2">Rp {{ number_format($item->product->price, 0, ',', '.') }}</span>
                                                @else
                                                    <span class="fw-bold text-dark">Rp {{ number_format($item->product->price, 0, ',', '.') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-auto d-flex align-items-center justify-content-between justify-content-sm-end gap-4 mt-3 mt-sm-0">
                                            <div class="qty-group shadow-sm">
                                                <button type="button" class="qty-btn btn-minus"><i class='bx bx-minus'></i></button>
                                                <input type="number" name="qty[{{ $item->id }}]" value="{{ $item->qty }}" class="qty-input item-qty" min="1" readonly>
                                                <button type="button" class="qty-btn btn-plus"><i class='bx bx-plus'></i></button>
                                            </div>
                                            
                                            <a href="{{ route('carts.destroy', [$item->id]) }}" onclick="confirmLuxury(event, this, 'Hapus Item', 'Hapus produk ini dari keranjang?', 'trash')" class="btn-trash" title="Hapus Item">
                                                <i class='bx bx-trash fs-5'></i>
                                            </a>
                                        </div>

                                    </div>
                                </li>
                                @empty
                                <li class="list-group-item p-5 text-center">
                                    <i class='bx bx-shopping-bag text-muted opacity-25' style="font-size: 4rem;"></i>
                                    <p class="mt-3 fw-medium text-muted">Keranjang belanja Anda masih kosong.</p>
                                    <a href="{{ route('products.index') }}" class="btn btn-luxury-outline mt-2">Mulai Belanja</a>
                                </li>
                                @endforelse
                            </ul>
                        </div>

                        @if(count($cart->items) > 0)
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <a href="{{ route('products.index') }}" class="text-decoration-none fw-semibold text-muted d-none d-sm-block">
                                <i class='bx bx-arrow-back me-1'></i> Lanjut Belanja
                            </a>
                            <button type="submit" class="btn btn-luxury-outline w-100 w-sm-auto">
                                <i class='bx bx-refresh me-1'></i> Simpan Perubahan Jumlah
                            </button>
                        </div>
                        @endif
                    </form>
                </div>

                <div class="col-lg-4 col-md-5">
                    <div class="sticky-sidebar">
                        <div class="premium-card p-4 border-0 shadow-sm">
                            <h5 class="fw-bold text-luxury border-bottom pb-3 mb-4"><i class='bx bx-receipt text-gold me-2 align-middle fs-5'></i>Ringkasan Belanja</h5>
                            
                            <div class="d-flex justify-content-between mb-3 small text-muted">
                                <span>Total Item Terpilih</span>
                                <span class="fw-bold text-dark" id="summary-items">0 Item</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3 small text-muted">
                                <span>Total Harga Barang</span>
                                <span class="fw-bold text-dark" id="summary-price">Rp 0</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3 small text-muted">
                                <span>Estimasi Pajak (11%)</span>
                                <span class="fw-bold text-dark" id="summary-tax">Rp 0</span>
                            </div>
                            
                            <div class="border-top border-light border-opacity-50 pt-3 mt-3 mb-4 d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-luxury">Subtotal</span>
                                <span class="fw-bold text-luxury fs-5" style="font-family: 'Playfair Display', serif;" id="summary-subtotal">Rp 0</span>
                            </div>

                            <div class="d-grid">
                                <a href="#" id="btn-checkout" class="btn btn-luxury-primary d-flex justify-content-center align-items-center gap-2 py-3">
                                    Checkout Sekarang <i class='bx bx-right-arrow-alt fs-5'></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkAll = document.getElementById('selectAll');
    const itemChecks = document.querySelectorAll('.item-check');
    const btnCheckout = document.getElementById('btn-checkout');
    
    const summaryItems = document.getElementById('summary-items');
    const summaryPrice = document.getElementById('summary-price');
    const summaryTax = document.getElementById('summary-tax');
    const summarySubtotal = document.getElementById('summary-subtotal');
    
    const baseCheckoutUrl = "{{ route('orders.checkout') }}";

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID').format(Math.round(number));
    }

    // Fungsi Kalkulasi Live saat Centang / Qty Berubah
    function calculateTotal() {
        let totalItems = 0;
        let totalPrice = 0;
        let selectedIds = [];

        itemChecks.forEach(check => {
            if (check.checked) {
                let qty = parseInt(check.dataset.qty);
                let price = parseInt(check.dataset.price);
                totalItems += qty;
                totalPrice += (price * qty);
                selectedIds.push(check.value);
            }
        });

        // Hitung Pajak 11% secara live di layar browser
        let taxAmount = totalPrice * 0.11;
        let grandTotal = totalPrice + taxAmount;

        // Tampilkan ke layar
        summaryItems.innerText = totalItems + " Item";
        summaryPrice.innerText = "Rp " + formatRupiah(totalPrice);
        summaryTax.innerText = "Rp " + formatRupiah(taxAmount);
        summarySubtotal.innerText = "Rp " + formatRupiah(grandTotal);

        // Atur Tombol Checkout & URL parameter
        if (selectedIds.length > 0) {
            btnCheckout.href = baseCheckoutUrl + "?items=" + selectedIds.join(',');
            btnCheckout.classList.remove('disabled');
        } else {
            btnCheckout.href = "javascript:void(0)";
            btnCheckout.classList.add('disabled');
        }
    }

    if (checkAll) {
        checkAll.addEventListener('change', function() {
            itemChecks.forEach(check => check.checked = this.checked);
            calculateTotal();
        });
    }

    itemChecks.forEach(check => {
        check.addEventListener('change', function() {
            if (!this.checked) checkAll.checked = false;
            if (document.querySelectorAll('.item-check:checked').length === itemChecks.length) {
                checkAll.checked = true;
            }
            calculateTotal();
        });
    });

    // Interaksi Tombol Plus Minus
    document.querySelectorAll('.product-row').forEach(row => {
        const btnMinus = row.querySelector('.btn-minus');
        const btnPlus = row.querySelector('.btn-plus');
        const inputQty = row.querySelector('.item-qty');
        const checkbox = row.querySelector('.item-check');

        btnMinus.addEventListener('click', function() {
            let qty = parseInt(inputQty.value);
            if (qty > 1) {
                inputQty.value = qty - 1;
                checkbox.dataset.qty = inputQty.value;
                calculateTotal();
            }
        });

        btnPlus.addEventListener('click', function() {
            let qty = parseInt(inputQty.value);
            inputQty.value = qty + 1;
            checkbox.dataset.qty = inputQty.value;
            calculateTotal();
        });
    });

    calculateTotal();
});
</script>
@endsection