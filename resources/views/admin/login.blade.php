<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - PTUN Bandung</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('AdminCss/login.css') }}">
</head>
<body>
    <div class="page-container">
        <div class="login-container">
            <div class="left-section">
                 <img src="{{ asset('ImageHome/logoptun-removebg-preview.png') }}" alt="PTUN Logo" class="welcome-logo">
                  <h4>Pengadilan Tata Usaha  Negara Bandung</h4>
                <h1>Let's Get Started</h1>
                <p>Selamat datang di Sistem Informasi Buku Tamu PTUN Bandung. Silakan login untuk melanjutkan.</p>

            </div>
            <div class="right-section">
                <h2>Login</h2>
                
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif
                <form action="{{ route('admin.login') }}" method="POST" class="login-form">
                    @csrf
                    <div class="input-group">
                        <input type="email" name="email" id="email" placeholder="Your Email" required>
                        @error('email')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-group">
                        <input type="password" name="password" id="password" placeholder="Password" required>
                        @error('password')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="login-btn">
                        Sign in
                    </button>

                    <div class="social-login">
            
    
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
