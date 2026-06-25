<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih dari Gallery Puan</title>
    <style>
        /* =====================================================
           RESET & BASE
        ===================================================== */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            background-color: #F5F0EB;
            color: #4A3728;
            line-height: 1.7;
            -webkit-font-smoothing: antialiased;
        }

        /* =====================================================
           WRAPPER UTAMA
        ===================================================== */
        .email-wrapper {
            max-width: 600px;
            margin: 40px auto;
            background-color: #FFFFFF;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 4px 30px rgba(74, 55, 40, 0.10);
        }

        /* =====================================================
           HEADER: Banner & Logo
        ===================================================== */
        .email-header {
            background-color: #3E2723;
            padding: 40px 48px;
            text-align: center;
            position: relative;
        }
        .email-header::after {
            content: '';
            display: block;
            width: 60px;
            height: 2px;
            background-color: #C5A059;
            margin: 20px auto 0;
        }
        .brand-name {
            font-family: 'Georgia', serif;
            font-size: 28px;
            font-weight: normal;
            letter-spacing: 6px;
            color: #F5F0EB;
            text-transform: uppercase;
        }
        .brand-tagline {
            font-size: 12px;
            color: #C5A059;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-top: 6px;
            font-family: Arial, sans-serif;
        }

        /* =====================================================
           BODY KONTEN
        ===================================================== */
        .email-body {
            padding: 48px 48px 32px;
        }

        .greeting-label {
            font-size: 11px;
            letter-spacing: 3px;
            color: #C5A059;
            text-transform: uppercase;
            font-family: Arial, sans-serif;
            margin-bottom: 12px;
        }
        .greeting-name {
            font-size: 32px;
            font-weight: normal;
            color: #3E2723;
            line-height: 1.2;
            margin-bottom: 24px;
        }

        .divider-gold {
            width: 48px;
            height: 1px;
            background-color: #C5A059;
            margin: 0 0 28px 0;
        }

        .body-text {
            font-family: Arial, 'Helvetica Neue', sans-serif;
            font-size: 15px;
            color: #6B5040;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        /* =====================================================
           KOTAK TIPS PERAWATAN
        ===================================================== */
        .care-tips-box {
            background-color: #FAF7F3;
            border-left: 3px solid #C5A059;
            border-radius: 0 4px 4px 0;
            padding: 28px 32px;
            margin: 32px 0;
        }
        .care-tips-title {
            font-size: 11px;
            letter-spacing: 3px;
            color: #C5A059;
            text-transform: uppercase;
            font-family: Arial, sans-serif;
            margin-bottom: 20px;
        }
        .care-tip-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 18px;
            font-family: Arial, 'Helvetica Neue', sans-serif;
        }
        .care-tip-item:last-child { margin-bottom: 0; }
        .tip-number {
            background-color: #3E2723;
            color: #F5F0EB;
            font-size: 11px;
            font-weight: bold;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-right: 14px;
            margin-top: 1px;
            font-family: Arial, sans-serif;
        }
        .tip-content { font-size: 14px; color: #5C4537; line-height: 1.6; }
        .tip-content strong { color: #3E2723; font-size: 14px; }

        /* =====================================================
           KOTAK VOUCHER PREMIUM
        ===================================================== */
        .voucher-section {
            margin: 36px 0;
            text-align: center;
        }
        .voucher-label {
            font-size: 11px;
            letter-spacing: 3px;
            color: #C5A059;
            text-transform: uppercase;
            font-family: Arial, sans-serif;
            margin-bottom: 16px;
        }
        .voucher-box {
            border: 1.5px dashed #C5A059;
            border-radius: 4px;
            padding: 28px 32px;
            background: linear-gradient(135deg, #FFFDF8 0%, #FBF5EC 100%);
            position: relative;
        }
        .voucher-headline {
            font-size: 13px;
            color: #6B5040;
            font-family: Arial, sans-serif;
            margin-bottom: 14px;
        }
        .voucher-code {
            font-family: 'Courier New', Courier, monospace;
            font-size: 26px;
            font-weight: bold;
            letter-spacing: 5px;
            color: #3E2723;
            background-color: #FFFFFF;
            padding: 14px 28px;
            border-radius: 4px;
            display: inline-block;
            border: 1px solid #E8DDD2;
            margin-bottom: 14px;
        }
        .voucher-meta {
            font-size: 12px;
            color: #9E8070;
            font-family: Arial, sans-serif;
            line-height: 1.7;
        }
        .voucher-meta strong { color: #C5A059; }

        /* =====================================================
           CTA BUTTON
        ===================================================== */
        .cta-section {
            text-align: center;
            margin: 32px 0;
        }
        .cta-button {
            display: inline-block;
            background-color: #3E2723;
            color: #F5F0EB !important;
            text-decoration: none;
            font-family: Arial, 'Helvetica Neue', sans-serif;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 16px 40px;
            border-radius: 2px;
        }

        /* =====================================================
           FOOTER
        ===================================================== */
        .email-footer {
            background-color: #3E2723;
            padding: 32px 48px;
            text-align: center;
        }
        .footer-brand {
            font-family: 'Georgia', serif;
            font-size: 16px;
            letter-spacing: 4px;
            color: #F5F0EB;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        .footer-text {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #9E8070;
            line-height: 1.8;
        }
        .footer-text a { color: #C5A059; text-decoration: none; }

        /* =====================================================
           RESPONSIVE (Mobile-friendly)
        ===================================================== */
        @media only screen and (max-width: 620px) {
            .email-wrapper { margin: 0; border-radius: 0; }
            .email-body { padding: 32px 24px; }
            .email-header { padding: 32px 24px; }
            .email-footer { padding: 24px; }
            .care-tips-box { padding: 20px; }
            .voucher-code { font-size: 20px; letter-spacing: 3px; }
        }
    </style>
</head>
<body>

<div class="email-wrapper">

    {{-- ============================================================
         HEADER
    ============================================================ --}}
    <div class="email-header">
        <div class="brand-name">Gallery Puan</div>
        <div class="brand-tagline">Hijab &amp; Fashion Muslim</div>
    </div>

    {{-- ============================================================
         BODY
    ============================================================ --}}
    <div class="email-body">

        <div class="greeting-label">Pesan Untuk Anda</div>
        <div class="greeting-name">
            Terima kasih,<br>
            {{ $order->customer_first_name }}.
        </div>
        <div class="divider-gold"></div>

        <p class="body-text">
            Pesanan Anda dengan nomor <strong>#{{ $order->code }}</strong> telah selesai
            dan semoga produk kami hadir membawa keindahan dalam keseharian Anda. ✨
        </p>
        <p class="body-text">
            Sebagai bentuk apresiasi kami atas kepercayaan yang Anda berikan kepada
            <em>Gallery Puan</em>, kami ingin berbagi beberapa tips merawat kain hijab agar
            tetap indah, awet, dan nyaman dipakai setiap hari.
        </p>

        {{-- ============================================================
             TIPS PERAWATAN HIJAB
        ============================================================ --}}
        <div class="care-tips-box">
            <div class="care-tips-title">✦ &nbsp; Tips Merawat Hijab Anda &nbsp; ✦</div>
            <div style="font-family: Arial, 'Helvetica Neue', sans-serif; font-size: 14px; color: #5C4537; line-height: 1.8;">
                {!! nl2br(e(\App\Models\Setting::getValue('email_care_tips') ?: "1. Cuci Tangan dengan Air Dingin\nHindari mesin cuci untuk kain premium. Cuci dengan tangan menggunakan air dingin dan deterjen lembut agar serat kain tetap halus dan tidak melar.\n\n2. Hindari Panas Langsung Saat Menyetrika\nGunakan suhu rendah atau mode \"Sutera\" pada setrika. Letakkan kain tipis sebagai pelapis di antara setrika dan hijab.\n\n3. Simpan dalam Posisi Terlipat atau Digulung\nSimpan hijab dalam kondisi terlipat rapi atau digulung longgar di laci bersih dan kering.")) !!}
            </div>
        </div>

        {{-- ============================================================
             VOUCHER EKSKLUSIF
        ============================================================ --}}
        <div class="voucher-section">
            <div class="voucher-label">✦ &nbsp; Hadiah Eksklusif Untuk Anda &nbsp; ✦</div>
            <div class="voucher-box">
                <p class="voucher-headline">
                    Sebagai bentuk terima kasih kami, nikmati diskon spesial
                    untuk pembelian berikutnya:
                </p>
                <div class="voucher-code">{{ $voucher->code }}</div>
                <div class="voucher-meta">
                    {{--
                        Data Formatting:
                        - Tipe 'percent' → cast ke (int) agar "10.00" menjadi "10%", bukan "10.00%"
                        - Tipe 'fixed'   → format number_format() agar "40000.00" menjadi "Rp 40.000"
                    --}}
                    @if($voucher->type === 'percent')
                        <strong>Diskon {{ (int) $voucher->value }}%</strong> untuk semua produk<br>
                    @else
                        {{-- Tipe fixed: potongan harga nominal Rupiah --}}
                        <strong>Diskon Rp {{ number_format($voucher->value, 0, ',', '.') }}</strong> untuk semua produk<br>
                    @endif
                    Berlaku hingga: <strong>{{ \Carbon\Carbon::parse($voucher->expired_at)->translatedFormat('d F Y') }}</strong><br>
                    <em>*Satu kode per transaksi. Tidak dapat digabungkan dengan promo lain.</em>
                </div>
            </div>
        </div>

        <p class="body-text" style="text-align: center; font-size: 14px; color: #9E8070;">
            Salin kode di atas dan masukkan saat checkout untuk mendapatkan diskon Anda.
        </p>

        {{-- CTA --}}
        <div class="cta-section">
            <a href="{{ url('/products') }}" class="cta-button">
                Belanja Sekarang
            </a>
        </div>

        <p class="body-text" style="font-size: 14px; color: #9E8070; text-align: center; margin-top: 8px;">
            Dengan cinta &amp; kehangatan,<br>
            <strong style="color: #3E2723; font-family: Georgia, serif; letter-spacing: 1px;">
                Tim Gallery Puan
            </strong>
        </p>

    </div>{{-- end .email-body --}}

    {{-- ============================================================
         FOOTER
    ============================================================ --}}
    <div class="email-footer">
        <div class="footer-brand">Gallery Puan</div>
        <div class="footer-text">
            Email ini dikirim secara otomatis. Mohon tidak membalas pesan ini.<br>
            &copy; {{ date('Y') }} Gallery Puan. All rights reserved.<br>
            <a href="{{ url('/') }}">gallerypuan.com</a>
        </div>
    </div>

</div>{{-- end .email-wrapper --}}

</body>
</html>
