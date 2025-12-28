<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Guma Landscape</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- CSS Guma -->
    <link href="{{ asset('css/admin-colors.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin-style.css') }}" rel="stylesheet">
</head>
<body class="auth-page">
    <div class="auth-card">
        <!-- Header -->
        <div class="auth-header">
            <div class="auth-logo">
                <i class="fas fa-leaf"></i>
            </div>
            <h1 class="auth-title">Guma Landscape</h1>
            <p>Buat Akun Baru</p>
        </div>
        
        <!-- Form -->
        <div class="auth-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" 
                           name="name" 
                           class="auth-form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name') }}"
                           required>
                    @error('name')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" 
                           name="email" 
                           class="auth-form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email') }}"
                           required>
                    @error('email')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="password-wrapper">
                        <input type="password" 
                               name="password" 
                               id="password"
                               class="auth-form-control @error('password') is-invalid @enderror" 
                               required>
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <div class="password-wrapper">
                        <input type="password" 
                               name="password_confirmation" 
                               id="password_confirmation"
                               class="auth-form-control" 
                               required>
                        <button type="button" class="password-toggle" id="toggleConfirmPassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <button type="submit" class="auth-btn">
                    <i class="fas fa-user-plus me-2"></i>Daftar Akun
                </button>
                
                <div class="text-center mt-3">
                    <p class="mb-0">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="auth-link">Login disini</a>
                    </p>
                </div>
            </form>
        </div>
        
        <!-- Footer -->
        <div class="auth-footer">
            <p class="mb-0">&copy; {{ date('Y') }} Guma Landscape Cafe & Resort</p>
        </div>
    </div>

    <!-- Script -->
    <script>
        // Password toggle
        function setupPasswordToggle(inputId, buttonId) {
            const button = document.getElementById(buttonId);
            button.addEventListener('click', function() {
                const input = document.getElementById(inputId);
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.replace('fa-eye-slash', 'fa-eye');
                }
            });
        }
        
        setupPasswordToggle('password', 'togglePassword');
        setupPasswordToggle('password_confirmation', 'toggleConfirmPassword');
    </script>
</body>
</html>