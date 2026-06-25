<!-- CSS Khusus Modal Quick View -->
<style>
    .qv-modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 20px 50px rgba(44, 30, 22, 0.15);
        overflow: hidden;
    }
    .qv-modal-header {
        background: linear-gradient(135deg, #F9F6F0 0%, #FFFDFB 100%);
        border-bottom: 1px solid #E8E2D9;
        padding: 20px 25px;
    }
    .qv-modal-title {
        font-family: 'Playfair Display', serif;
        color: #2C1E16;
        font-weight: 600;
        font-size: 22px;
        margin: 0;
    }
    .qv-close-btn {
        background: #FFFDFB;
        border: 1px solid #E8E2D9;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #5D4B46;
        cursor: pointer;
        transition: 0.3s;
    }
    .qv-close-btn:hover {
        background: #F9F6F0;
        color: #DC3545;
        border-color: #D2C6B6;
    }
    .qv-variant-label {
        cursor: pointer;
        margin: 0;
        display: inline-block;
    }
    .qv-variant-radio {
        display: none;
    }
    .qv-variant-swatch {
        display: inline-block;
        padding: 8px 18px;
        border: 2px solid #E8E2D9;
        border-radius: 30px;
        color: #5D4B46;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
        background-color: #FFFFFF;
    }
    .qv-variant-radio:checked + .qv-variant-swatch {
        border-color: #C5A059;
        background-color: #C5A059;
        color: #FFFFFF;
        box-shadow: 0 4px 15px rgba(197, 160, 89, 0.2);
    }
    .qv-variant-radio:disabled + .qv-variant-swatch {
        opacity: 0.5;
        cursor: not-allowed;
        background-color: #F9F6F0;
        text-decoration: line-through;
    }
</style>

<!-- Modal Quick View (Pop-up Pilih Warna) -->
<div class="modal fade" id="quickViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content qv-modal-content">
            <form id="qv-cart-form" action="{{ route('carts.store') }}" method="POST">
                @csrf
                <!-- Akan diisi otomatis via JS saat warna dipilih -->
                <input type="hidden" name="product_id" id="qv_product_id" value="">
                <input type="hidden" name="qty" value="1">
                
                <div class="modal-header qv-modal-header d-flex justify-content-between align-items-center">
                    <h5 class="qv-modal-title" id="qv_product_title">Pilih Warna</h5>
                    <button type="button" class="qv-close-btn" data-bs-dismiss="modal">
                        <i class='bx bx-x fs-4'></i>
                    </button>
                </div>
                
                <div class="modal-body p-4 text-center">
                    <p class="text-muted mb-4" style="font-size: 14px;">Silakan pilih varian/warna yang tersedia untuk menambahkannya ke keranjang.</p>
                    
                    <div id="qv_variants_container" class="d-flex flex-wrap gap-2 justify-content-center mb-2">
                        <!-- Variant swatches will be injected here via Javascript -->
                    </div>
                </div>
                
                <div class="modal-footer p-4 pt-0" style="border-top: none;">
                    <button type="submit" class="btn w-100" style="background-color: #2C1E16; color: #FFF; padding: 14px; border-radius: 8px; font-weight: 500; letter-spacing: 1px; text-transform: uppercase; transition: 0.3s;" onmouseover="this.style.backgroundColor='#C5A059'" onmouseout="this.style.backgroundColor='#2C1E16'">
                        <i class='bx bx-cart-alt me-1'></i> Masukkan Keranjang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Global function to trigger the Quick View Modal
    window.openQuickView = function(event, productName, variantsJson) {
        event.preventDefault();
        
        // Parsing data variant
        let variants = [];
        try {
            variants = JSON.parse(variantsJson);
        } catch (e) {
            console.error("Gagal parsing variant JSON", e);
            return;
        }

        // Set judul modal
        document.getElementById('qv_product_title').textContent = productName;
        
        // Kosongkan container variant dan ID product
        let container = document.getElementById('qv_variants_container');
        container.innerHTML = '';
        document.getElementById('qv_product_id').value = '';
        
        // Buat swatches warna
        variants.forEach(function(variant) {
            let isOutOfStock = variant.stock <= 0;
            let stockStatus = isOutOfStock ? 'Habis' : 'Tersedia';
            let colorName = variant.color || 'Warna';
            
            let html = `
                <label class="qv-variant-label" title="Stok: ${stockStatus}">
                    <input type="radio" name="qv_variant" value="${variant.id}" class="qv-variant-radio" ${isOutOfStock ? 'disabled' : ''}>
                    <span class="qv-variant-swatch">${colorName}</span>
                </label>
            `;
            container.insertAdjacentHTML('beforeend', html);
        });

        // Event listener saat warna dipilih
        let radios = container.querySelectorAll('.qv-variant-radio');
        radios.forEach(function(radio) {
            radio.addEventListener('change', function() {
                // Set hidden input product_id untuk form keranjang
                document.getElementById('qv_product_id').value = this.value;
            });
        });

        // Event handler submit form (validasi jika warna belum dipilih)
        document.getElementById('qv-cart-form').onsubmit = function(e) {
            let selectedVariant = document.getElementById('qv_product_id').value;
            if (!selectedVariant) {
                e.preventDefault();
                showLuxuryToast('Perhatian', 'Silakan klik salah satu warna sebelum melanjutkan.', 'warning');
            }
        };

        // Tampilkan Bootstrap Modal
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            let quickViewModal = new bootstrap.Modal(document.getElementById('quickViewModal'));
            quickViewModal.show();
        } else if (typeof $ !== 'undefined' && $.fn.modal) {
            $('#quickViewModal').modal('show');
        } else {
            console.error("Bootstrap Modal tidak ditemukan. Menampilkan modal secara manual.");
            document.getElementById('quickViewModal').classList.add('show');
            document.getElementById('quickViewModal').style.display = 'block';
            
            // Add a simple backdrop
            if (!document.querySelector('.modal-backdrop')) {
                let backdrop = document.createElement('div');
                backdrop.className = 'modal-backdrop fade show';
                document.body.appendChild(backdrop);
            }
            
            // Simple close handling
            document.querySelector('.qv-close-btn').onclick = function() {
                document.getElementById('quickViewModal').classList.remove('show');
                document.getElementById('quickViewModal').style.display = 'none';
                let bd = document.querySelector('.modal-backdrop');
                if(bd) bd.remove();
            };
        }
    };
</script>
