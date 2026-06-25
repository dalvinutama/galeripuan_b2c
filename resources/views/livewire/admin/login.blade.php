<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal - Gallery Puan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* CORE DESIGN PRINCIPLES */
        * { 
            box-sizing: border-box; 
        }
        
        body, html {
            margin: 0;
            padding: 0;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
            background-color: #FAF7F2; /* Warna latar belakang hangat khas Gallery Puan */
        }

        /* CENTERED LAYOUT CONTAINER */
        .admin-login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            min-height: 100vh;
            padding: 20px;
        }

        /* RESPONSIVE CARD STYLE LOGIN FORM */
        .form-side {
            width: 100%;
            max-width: 440px; /* Lebar maksimal form yang ideal */
            background-color: #FFFFFF;
            padding: 40px 35px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(74, 63, 53, 0.08);
            border: 1px solid rgba(74, 63, 53, 0.05);
            text-align: center;
        }

        .brand-logo {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            color: #4A3F35;
            font-weight: 700;
            letter-spacing: 2px;
            margin-bottom: 30px;
        }

        .login-header h2 {
            font-size: 28px;
            color: #1e293b;
            margin: 0 0 10px 0;
        }

        .login-header p {
            color: #64748b;
            margin-bottom: 35px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 22px;
            text-align: left; /* Label dan input tetap rata kiri */
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }

        .form-group input:focus {
            outline: none;
            border-color: #8C7A6B;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(140, 122, 107, 0.15);
        }

        .btn-login {
            background-color: #4A3F35;
            color: white;
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
            margin-top: 10px;
        }

        .btn-login:hover {
            background-color: #352d26;
            transform: translateY(-1px);
        }

        .btn-login:active {
            transform: translateY(1px);
        }

        .alert-error {
            background-color: #fee2e2;
            color: #b91c1c;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 14px;
            border-left: 4px solid #b91c1c;
            text-align: left;
        }

        .footer-text {
            margin-top: 35px;
            font-size: 12px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

<div class="admin-login-container">
    <div class="form-side">
        <div class="brand-logo">GALLERY PUAN</div>
        
        <div class="login-header">
            <h2>Selamat Datang</h2>
            <p>Silakan masuk ke akun admin Anda.</p>
        </div>

        @if (session()->has('error'))
            <div class="alert-error">
                <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
            </div>
        @endif

        <form wire:submit.prevent="login">
            <div class="form-group">
                <label>Alamat Email</label>
                <input type="email" wire:model="email" placeholder="owner@gallerypuan.com" required autocomplete="email">
            </div>

            <div class="form-group">
                <label>Kata Sandi</label>
                <input type="password" wire:model="password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-login">
                Masuk ke Dashboard
            </button>
        </form>

        <div class="footer-text">
            &copy; 2026 Gallery Puan Control Panel. v1.0.4
        </div>
    </div>
</div>

</body>
</html>