<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Already Logged In - Guma Landscape</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS Guma -->
    <link href="{{ asset('css/admin-colors.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin-style.css') }}" rel="stylesheet">
    
    <style>
        .already-logged-card {
            max-width: 500px;
            margin: 50px auto;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: none;
        }
        .user-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #A0522D 0%, #8B4513 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 2rem;
        }
        .role-badge {
            font-size: 0.8rem;
            padding: 5px 15px;
            border-radius: 20px;
        }
        .action-btn {
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            text-align: center;
            transition: all 0.3s;
        }
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card already-logged-card">
            <div class="card-header text-center" style="background: linear-gradient(135deg, #A0522D 0%, #8B4513 100%); color: white;">
                <h4 class="mb-0">
                    <i class="fas fa-user-check me-2"></i>
                    Already Logged In
                </h4>
            </div>
            
            <div class="card-body p-4">
                <!-- User Info -->
                <div class="text-center mb-4">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <p class="text-muted mb-2">{{ $user->email }}</p>
                    <span class="badge role-badge bg-{{ $user->role === 'admin' ? 'primary' : 'secondary' }}">
                        {{ $user->role === 'admin' ? 'Administrator' : 'User' }}
                    </span>
                </div>
                
                <!-- Message -->
                <div class="alert alert-info mb-4">
                    <i class="fas fa-info-circle me-2"></i>
                    Anda sudah login ke sistem Guma Landscape.
                    Tidak perlu login lagi.
                </div>
                
                <!-- Action Buttons -->
                <div class="d-grid gap-3">
                    @if($user->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" 
                       class="action-btn btn btn-primary">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        Go to Admin Dashboard
                    </a>
                    @endif
                    
                    <a href="{{ url('/') }}" 
                       class="action-btn btn btn-outline-primary">
                        <i class="fas fa-home me-2"></i>
                        Back to Homepage
                    </a>
                    
                    <form action="{{ route('logout') }}" method="POST" class="d-grid">
                        @csrf
                        <button type="submit" class="action-btn btn btn-outline-danger">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            Logout & Login as Different User
                        </button>
                    </form>
                </div>
                
                <!-- Session Info -->
                <div class="mt-4 pt-3 border-top text-center">
                    <small class="text-muted">
                        <i class="fas fa-clock me-1"></i>
                        Session started: {{ now()->format('d M Y H:i') }}
                    </small>
                </div>
            </div>
            
            <div class="card-footer text-center bg-light">
                <small class="text-muted">
                    <i class="fas fa-leaf me-1"></i>
                    Guma Landscape Cafe & Resort &copy; {{ date('Y') }}
                </small>
            </div>
        </div>
    </div>
    
    <!-- Script -->
    <script>
        // Auto redirect after 10 seconds (optional)
        setTimeout(function() {
            @if($user->role === 'admin')
                window.location.href = "{{ route('admin.dashboard') }}";
            @else
                window.location.href = "{{ url('/') }}";
            @endif
        }, 10000); // 10 seconds
    </script>
</body>
</html>