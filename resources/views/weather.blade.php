<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuaca - Guma Villa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f0f0f0;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h2 class="mb-4">🌤️ Cuaca Guma Villa</h2>
                        
                        @if(isset($error))
                            <p class="text-danger">{{ $error }}</p>
                        @else
                            <img src="https://openweathermap.org/img/wn/{{ $icon }}@2x.png" alt="Weather">
                            <h1 class="display-4">{{ $temp }}°C</h1>
                            <h4>{{ $description }}</h4>
                            <hr>
                            <p>📍 Lokasi: {{ $city }}</p>
                            <p>💧 Kelembapan: {{ $humidity }}%</p>
                        @endif
                        
                        <a href="{{ url()->current() }}" class="btn btn-primary mt-3">Refresh 🔄</a>
                        <a href="/" class="btn btn-secondary mt-3">Kembali ke Beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>