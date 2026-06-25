<style>
    .luxury-toast-container {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
        z-index: 999999;
        display: flex;
        flex-direction: column;
        pointer-events: none;
    }
    .luxury-toast {
        background: rgba(44, 30, 22, 0.95);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        color: #F9F6F0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        padding: 12px 24px;
        border-radius: 0;
        border-bottom: 2px solid #C5A059;
        font-family: 'Poppins', sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        width: 100%;
        animation: toastSlideDownBanner 0.5s cubic-bezier(0.2, 0.9, 0.3, 1) forwards, toastFadeOutBanner 0.4s ease 3.5s forwards;
    }
    
    .toast-icon-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .luxury-toast.success .toast-icon-wrapper {
        background: #C5A059;
    }
    .luxury-toast.success .toast-icon-wrapper i {
        color: #2C1E16;
        font-size: 16px;
    }
    
    .luxury-toast.error .toast-icon-wrapper {
        background: #FF6B6B;
    }
    .luxury-toast.error .toast-icon-wrapper i {
        color: #FFFFFF;
        font-size: 16px;
    }
    .luxury-toast.error {
        border-bottom-color: #FF6B6B;
    }

    .toast-content {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .toast-title {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
    }
    .luxury-toast.success .toast-title { color: #C5A059; }
    .luxury-toast.error .toast-title { color: #FF6B6B; }
    
    .toast-message {
        font-size: 14px;
        font-weight: 400;
        color: #FFFFFF;
    }

    @keyframes toastSlideDownBanner {
        0% { transform: translateY(-100%); opacity: 0; }
        100% { transform: translateY(0); opacity: 1; }
    }
    @keyframes toastFadeOutBanner {
        0% { transform: translateY(0); opacity: 1; }
        100% { transform: translateY(-100%); opacity: 0; }
    }
</style>

<div class="luxury-toast-container" id="toast-container">
    @if ($errors->any())
        <div class="luxury-toast error">
            <div class="toast-icon-wrapper">
                <i class='bx bx-error-circle'></i>
            </div>
            <div class="toast-content">
                <span class="toast-title">Peringatan:</span>
                <span class="toast-message">Mohon periksa kembali input Anda.</span>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="luxury-toast success">
            <div class="toast-icon-wrapper">
                <i class='bx bx-check'></i>
            </div>
            <div class="toast-content">
                <span class="toast-title">Berhasil:</span>
                <span class="toast-message">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="luxury-toast error">
            <div class="toast-icon-wrapper">
                <i class='bx bx-x'></i>
            </div>
            <div class="toast-content">
                <span class="toast-title">Gagal:</span>
                <span class="toast-message">{{ session('error') }}</span>
            </div>
        </div>
    @endif
</div>

<script>
    setTimeout(function() {
        let container = document.getElementById('toast-container');
        if(container) {
            setTimeout(() => container.remove(), 1000);
        }
    }, 4000);

    window.showLuxuryToast = function(title, message, type = 'success') {
        let container = document.getElementById('dynamic-toast-container');
        if(container) container.remove();

        let icon = type === 'success' ? 'bx-check' : (type === 'warning' ? 'bx-error-circle' : 'bx-x');
        let iconBg = type === 'success' ? '#C5A059' : '#FF6B6B';
        if(type === 'warning') iconBg = '#F39C12'; // Warning goldish color
        let iconColor = type === 'success' ? '#2C1E16' : '#FFFFFF';
        let borderColor = type === 'success' ? '#C5A059' : '#FF6B6B';
        if(type === 'warning') borderColor = '#F39C12';
        
        let html = `
            <div class="luxury-toast-container" id="dynamic-toast-container">
                <div class="luxury-toast ${type}" style="border-bottom-color: ${borderColor};">
                    <div class="toast-icon-wrapper" style="background: ${iconBg};">
                        <i class='bx ${icon}' style="color: ${iconColor}; font-size: 16px;"></i>
                    </div>
                    <div class="toast-content">
                        <span class="toast-title" style="color: ${borderColor};">${title}:</span>
                        <span class="toast-message">${message}</span>
                    </div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', html);
        
        setTimeout(function() {
            let dynContainer = document.getElementById('dynamic-toast-container');
            if(dynContainer) {
                setTimeout(() => dynContainer.remove(), 1000);
            }
        }, 4000);
    };

    window.confirmLuxury = function(event, target, title, message, iconType = 'trash') {
        event.preventDefault();
        
        let iconClass = iconType === 'trash' ? 'bx-trash' : (iconType === 'check' ? 'bx-check-circle' : 'bx-question-mark');
        let colorClass = iconType === 'trash' ? '#DC3545' : (iconType === 'check' ? '#28A745' : '#C5A059');
        let bgClass = iconType === 'trash' ? '#FFF5F5' : (iconType === 'check' ? '#F0FFF4' : '#FFFDF5');
        let gradClass = iconType === 'trash' ? 'linear-gradient(90deg, #FF6B6B, #DC3545, #FF6B6B)' : (iconType === 'check' ? 'linear-gradient(90deg, #28A745, #20C997, #28A745)' : 'linear-gradient(90deg, #D1A7A0, #C5A059, #D1A7A0)');
        
        Swal.fire({
            html: `
                <div style="background-color: #FFFFFF; border-radius: 24px; overflow: hidden; position: relative; text-align: center;">
                    <div style="height: 5px; width: 100%; background: ${gradClass};"></div>
                    <div style="padding: 35px 30px 25px;">
                        <div style="display: flex; justify-content: center; margin-bottom: 20px;">
                            <div style="width: 65px; height: 65px; border-radius: 50%; background: ${bgClass}; display: flex; align-items: center; justify-content: center;">
                                <i class="bx ${iconClass}" style="font-size: 32px; color: ${colorClass};"></i>
                            </div>
                        </div>
                        <h3 style="font-family: 'Playfair Display', serif; font-weight: 600; color: #2C1E16; margin-bottom: 10px; font-size: 22px;">${title}</h3>
                        <p style="color: #6C5A49; font-size: 14px; margin-bottom: 30px;">${message}</p>
                        <div style="display: flex; gap: 10px; justify-content: center;">
                            <button onclick="Swal.close()" style="flex: 1; padding: 12px; border-radius: 8px; border: 1px solid #E8E2D9; background: #FFFFFF; font-weight: 500; cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='#F9F6F0'" onmouseout="this.style.background='#FFFFFF'">Batal</button>
                            <button onclick="executeConfirmAction(this)" style="flex: 1; padding: 12px; border-radius: 8px; border: none; background: ${colorClass}; color: #FFF; font-weight: 500; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 15px rgba(0,0,0,0.1);" onmouseover="this.style.filter='brightness(0.9)'" onmouseout="this.style.filter='brightness(1)'">Ya, Lanjutkan</button>
                        </div>
                    </div>
                </div>
            `,
            showConfirmButton: false,
            padding: '0',
            background: 'transparent',
            backdrop: 'rgba(20, 15, 10, 0.65)',
            customClass: { popup: 'ultra-premium-logout-popup' } // reusable CSS class from header
        });
        
        // Simpan referensi target
        window.tempConfirmTarget = typeof target === 'string' ? target : target;
    };

    window.executeConfirmAction = function(btn) {
        let originalText = btn.innerHTML;
        btn.innerHTML = '<i class="bx bx-loader bx-spin"></i>';
        
        setTimeout(() => {
            Swal.close();
            let target = window.tempConfirmTarget;
            
            if (typeof target === 'string') {
                if (target.startsWith('http')) {
                    window.location.href = target;
                } else {
                    document.getElementById(target).submit();
                }
            } else if (target && target.submit) {
                target.submit();
            } else if (target && target.tagName === 'A') {
                window.location.href = target.href;
            }
        }, 300);
    };
</script>