<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Keluarga Gallery Puan ID</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .header {
            background: linear-gradient(135deg, #1f1f1f 0%, #3a3a3a 100%);
            padding: 40px 20px;
            text-align: center;
        }
        .header h1 {
            color: #C5A059;
            margin: 0;
            font-size: 28px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .header p {
            color: #e0e0e0;
            font-size: 14px;
            margin-top: 10px;
            letter-spacing: 1px;
        }
        .body-content {
            padding: 40px 30px;
            text-align: center;
            line-height: 1.6;
        }
        .body-content h2 {
            color: #222;
            font-size: 22px;
            margin-bottom: 20px;
        }
        .voucher-box {
            background-color: #fdfaf2;
            border: 2px dashed #C5A059;
            padding: 25px;
            margin: 30px 0;
            border-radius: 8px;
        }
        .voucher-title {
            font-size: 14px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }
        .voucher-code {
            font-size: 32px;
            font-weight: bold;
            color: #C5A059;
            letter-spacing: 3px;
        }
        .btn-shop {
            display: inline-block;
            background-color: #C5A059;
            color: #ffffff;
            text-decoration: none;
            padding: 15px 35px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 50px;
            margin-top: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .footer {
            background-color: #f1f1f1;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>Gallery Puan ID</h1>
            <p>Elegance in Every Thread</p>
        </div>

        <!-- Body -->
        <div class="body-content">
            <h2>Halo, {{ $user->name }}! ✨</h2>
            <p>Selamat bergabung di keluarga besar <strong>Gallery Puan ID</strong>!</p>
            <p>Kami sangat bersyukur Anda memilih kami untuk menemani perjalanan gaya busana Anda. Di Gallery Puan, kami percaya bahwa setiap wanita berhak tampil anggun dan percaya diri dengan balutan hijab dan pakaian kualitas premium.</p>
            
            <div class="voucher-box">
                <div class="voucher-title">Khusus Pembelian Pertama Anda</div>
                <div class="voucher-code">NEWPUAN10</div>
                <p style="font-size: 13px; color: #777; margin-top: 15px; margin-bottom: 0;">Gunakan kode di atas saat checkout untuk mendapatkan Diskon 10% tanpa minimal belanja!</p>
            </div>

            <p>Jangan ragu untuk menjelajahi koleksi terbaru kami yang dirancang eksklusif hanya untuk Anda.</p>
            
            <a href="{{ url('/products') }}" class="btn-shop">Mulai Belanja Sekarang</a>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Email ini dikirim secara otomatis oleh sistem Gallery Puan ID.<br>
            Harap tidak membalas email ini secara langsung.</p>
            <p>&copy; {{ date('Y') }} Gallery Puan. Hak Cipta Dilindungi.</p>
        </div>
    </div>
</body>
</html>
