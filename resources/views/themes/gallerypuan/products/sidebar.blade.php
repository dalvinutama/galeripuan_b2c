<style>
    .sidebar-widget {
        background-color: #F9F6F0;
        border-radius: 8px;
        padding: 25px;
        margin-bottom: 30px;
        border: 1px solid #E8E2D9;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }
    .widget-title h5 {
        font-family: 'Playfair Display', serif;
        font-size: 19px;
        color: #1A110D;
        margin-bottom: 25px;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 800;
        border-bottom: 3px solid #C5A059;
        padding-bottom: 12px;
    }
    .nav-category {
        padding-left: 0;
        list-style: none;
        max-height: 320px;
        overflow-y: auto;
        padding-right: 5px;
    }
    /* Custom Scrollbar for Category List */
    .nav-category::-webkit-scrollbar {
        width: 6px;
    }
    .nav-category::-webkit-scrollbar-track {
        background: transparent;
    }
    .nav-category::-webkit-scrollbar-thumb {
        background-color: #E8E2D9;
        border-radius: 10px;
    }
    .nav-category::-webkit-scrollbar-thumb:hover {
        background-color: #C5A059;
    }
    .nav-category .nav-item {
        margin-bottom: 10px;
    }
    .nav-category .nav-link {
        color: #1A110D;
        font-size: 14px;
        padding: 12px 15px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-radius: 4px;
        border-left: 5px solid transparent;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        background-color: #FFFFFF;
        border: 1px solid #F0E6D2;
    }
    .nav-category .nav-link:hover, .nav-category .nav-link[aria-expanded="true"] {
        color: #1A110D;
        background-color: #F4ECE1;
        border-left-color: #C5A059;
        border-color: #E8E2D9;
    }
    .nav-category .nav-link.active {
        color: #FFFFFF;
        font-weight: 700;
        background-color: #1A110D;
        border-left-color: #C5A059;
        border-top-color: #1A110D;
        border-right-color: #1A110D;
        border-bottom-color: #1A110D;
        box-shadow: 0 4px 10px rgba(26, 17, 13, 0.2);
    }
    .nav-category .nav-link i {
        font-size: 18px;
        color: #A3736C;
        transition: transform 0.3s ease;
    }
    .nav-category .nav-link.active i {
        color: #C5A059;
    }
    .nav-category .nav-link[aria-expanded="true"] i {
        transform: rotate(90deg);
        color: #C5A059;
    }
    .subcategory-list {
        padding-left: 15px;
        list-style: none;
        margin-top: 5px;
    }
    .subcategory-list .nav-link {
        font-size: 13px;
        padding: 8px 12px;
        text-transform: none;
        letter-spacing: 0;
    }

    /* Styling Tombol Filter */
    .btn-apply-filter {
        background-color: #B6867F; 
        color: #FFFFFF; 
        font-size: 13px; 
        text-transform: uppercase; 
        letter-spacing: 2px; 
        font-weight: 600; 
        padding: 12px; 
        border-radius: 6px; 
        transition: all 0.4s ease; 
        border: 1px solid #B6867F;
    }
    .btn-apply-filter:hover { 
        background-color: #A3736C !important; 
        border-color: #A3736C !important;
        color: #FFFFFF !important;
        transform: translateY(-2px); 
        box-shadow: 0 8px 15px rgba(163, 115, 108, 0.25); 
    }
</style>

@php
    $currentCategorySlug = request()->route('categorySlug');
@endphp

<div class="sidebar">
    @if ($categories->count() > 0)
    <div class="sidebar-widget">
        <div class="widget-title">
            <h5>Kategori</h5>
        </div>
        <div class="widget-content widget-categories">
            <ul class="nav nav-category flex-column" id="accordionCategory">
                @foreach($categories as $category)
                    @php
                        $isActive = $currentCategorySlug == $category->slug;
                        $hasChildren = $category->children->count() > 0;
                        $isChildActive = $hasChildren && $category->children->contains('slug', $currentCategorySlug);
                        $isExpanded = $isActive || $isChildActive;
                    @endphp
                    <li class="nav-item w-100">
                        @if($hasChildren)
                            <a class="nav-link {{ $isExpanded ? 'active' : '' }}" href="#collapse-{{ $category->id }}" data-bs-toggle="collapse" aria-expanded="{{ $isExpanded ? 'true' : 'false' }}" aria-controls="collapse-{{ $category->id }}">
                                {{ $category->name }} 
                                <i class='bx bx-chevron-right'></i>
                            </a>
                            <div class="collapse {{ $isExpanded ? 'show' : '' }}" id="collapse-{{ $category->id }}" data-bs-parent="#accordionCategory">
                                <ul class="subcategory-list">
                                    <li>
                                        <a class="nav-link {{ $isActive ? 'active' : '' }}" href="{{ shop_category_link($category) }}">Semua {{ $category->name }}</a>
                                    </li>
                                    @foreach($category->children as $child)
                                        <li>
                                            <a class="nav-link {{ $currentCategorySlug == $child->slug ? 'active' : '' }}" href="{{ shop_category_link($child) }}">
                                                {{ $child->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <a class="nav-link {{ $isActive ? 'active' : '' }}" href="{{ shop_category_link($category) }}">
                                {{ $category->name }} 
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
    <div class="sidebar-widget mt-4">
        <div class="widget-title">
            <h5>Kisaran Harga</h5>
        </div>
        <div class="widget-content shop-by-price">

            <form method="GET" action="{{ url()->current() }}">
                <div class="price-filter">
                    <div class="price-filter-inner">
                        
                        <div id="nouislider-range" style="margin: 15px 10px 25px 10px;"></div>

                        <div class="price_slider_amount">
                            <div class="label-input d-flex flex-column align-items-stretch gap-3">
                                <input type="hidden" id="min_price" value="{{ $filter['price']['min'] ?? 0 }}"/>
                                <input type="hidden" id="max_price" value="{{ $filter['price']['max'] ?? 100000 }}"/>
                                
                                <input type="text" id="amount" name="price" placeholder="Add Your Price" readonly style="border:1px solid #E8E2D9; border-radius:4px; padding:8px 12px; color:#3E2723; font-weight:500; background:#FFFFFF; width:100%; font-size: 13px; outline:none; text-align:center; letter-spacing:0.5px; font-family: 'Poppins', sans-serif;" />
                                
                                <button type="submit" class="btn btn-apply-filter w-100">Terapkan Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js"></script>

<style>
    /* Modern Slider Styles */
    .noUi-target { 
        background: #E8E2D9; 
        border: none; 
        box-shadow: none; 
        height: 6px; 
        border-radius: 4px; 
    }
    .noUi-connect { 
        background: #C5A059; 
        transition: background 0.3s;
    }
    .noUi-handle { 
        border: 2px solid #FFFFFF; 
        border-radius: 50%; 
        background: #C5A059; 
        cursor: grab; 
        box-shadow: 0 4px 10px rgba(197, 160, 89, 0.4); 
        transition: transform 0.2s ease, background 0.2s ease;
    }
    .noUi-handle:active {
        cursor: grabbing;
        transform: scale(1.1);
        background: #B6867F;
    }
    .noUi-handle:before, .noUi-handle:after { display: none; }
    .noUi-horizontal .noUi-handle { 
        width: 16px; 
        height: 16px; 
        right: -8px; 
        top: -5px; 
    }
    
    .price_slider_amount button:hover { 
        background-color: #A3736C !important; 
        transform: translateY(-2px); 
        box-shadow: 0 4px 10px rgba(163, 115, 108, 0.2); 
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var slider = document.getElementById('nouislider-range');
    var minPrice = parseInt(document.getElementById('min_price').value) || 0;
    var maxPrice = parseInt(document.getElementById('max_price').value) || 100000;
    var amountInput = document.getElementById('amount');

    // Aktifkan Slider
    if(slider) {
        noUiSlider.create(slider, {
            start: [minPrice, maxPrice],
            connect: true,
            range: {
                'min': 0,
                'max': 500000 // Harga maksimal mentok di Rp 500.000
            },
            step: 1000, // Gesernya per kelipatan Rp 1.000
            format: {
                to: function (value) { return Math.round(value); },
                from: function (value) { return Number(value); }
            }
        });

        // Update teks angka tiap kali pentolannya digeser
        slider.noUiSlider.on('update', function (values, handle) {
            amountInput.value = values[0] + " - " + values[1];
        });

        // Submit form otomatis saat pengguna selesai menggeser slider
        slider.noUiSlider.on('change', function (values, handle) {
            amountInput.closest('form').submit();
        });
    }
});
</script>