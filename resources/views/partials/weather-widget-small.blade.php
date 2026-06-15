<div class="weather-float" style="position: fixed; left: 20px; bottom: 20px; z-index: 1000; width: 220px; background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); padding: 12px; border-left: 4px solid #0288D1;">
    <div class="d-flex align-items-center">
        <div class="flex-shrink-0">
            <img src="https://openweathermap.org/img/wn/{{ $icon ?? '01d' }}@2x.png" alt="weather" style="width: 50px;">
        </div>
        <div class="flex-grow-1 ms-2">
            <div class="fw-bold fs-5">{{ $temp ?? '--' }}°C</div>
            <div class="small text-capitalize text-muted">{{ $description ?? 'Memuat...' }}</div>
            <div class="small text-muted">
                <i class="fas fa-map-marker-alt"></i> {{ $city ?? 'Guma Villa' }}
            </div>
        </div>
    </div>
    <div class="small text-muted mt-2 text-center">
        <i class="fas fa-tint"></i> Kelembapan: {{ $humidity ?? '--' }}%
    </div>
</div>

<script>
    // Load data cuaca via AJAX agar tidak mengganggu layout
    fetch('{{ route("user.weather") }}')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.log('Weather error:', data.error);
                return;
            }
            const widget = document.querySelector('.weather-float');
            if (widget) {
                widget.innerHTML = `
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <img src="https://openweathermap.org/img/wn/${data.icon}@2x.png" style="width: 50px;">
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <div class="fw-bold fs-5">${data.temp}°C</div>
                            <div class="small text-capitalize text-muted">${data.description}</div>
                            <div class="small text-muted">
                                <i class="fas fa-map-marker-alt"></i> ${data.city}
                            </div>
                        </div>
                    </div>
                    <div class="small text-muted mt-2 text-center">
                        <i class="fas fa-tint"></i> Kelembapan: ${data.humidity}%
                    </div>
                `;
            }
        })
        .catch(error => console.log('Weather API error:', error));
</script>