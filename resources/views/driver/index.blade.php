@extends('layouts.app')

@section('title', 'Driver Tracking')
@section('header', 'Panel Driver Distribusi')

@section('content')
<div class="row">
    <!-- Kontrol Pengiriman -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow-sm border-0 rounded-1 h-100">
            <div class="card-header bg-bgn-primary text-white d-flex align-items-center">
                <i class="fas fa-truck fa-lg me-2 text-bgn-gold"></i>
                <h3 class="card-title mb-0">Kontrol Pengiriman</h3>
            </div>
            <div class="card-body p-4">
                <div class="mb-4">
                    <h6 class="text-uppercase text-muted fw-bold mb-3" style="font-size: 0.8rem; letter-spacing: 1px;">Informasi Logistik</h6>
                    <ul class="list-group list-group-flush rounded-1 border mb-3">
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                            <span class="text-muted small">ID Pengiriman</span>
                            <span class="fw-bold">TRX-BGN-88291</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Armada / Nopol</span>
                            <span class="fw-bold">Box Pendingin / AB 1234 XY</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                            <span class="text-muted small">Rute Distribusi</span>
                            <span class="fw-bold text-end">SDN 1 Sleman & SMPN 2 Depok</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Muatan Porsi</span>
                            <span class="fw-bold text-bgn-primary">500 Porsi Standar</span>
                        </li>
                    </ul>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light border rounded-1">
                    <span class="text-muted fw-bold small text-uppercase">Status Operasional</span>
                    <span id="tracking-status" class="badge bg-secondary">MENUNGGU KEBERANGKATAN</span>
                </div>

                <div class="d-grid gap-3">
                    <button id="btn-start" class="btn btn-success rounded-1 py-3 fw-bold">
                        <i class="fas fa-satellite-dish me-2"></i> AKTIFKAN TRACKING GPS
                    </button>
                    
                    <button id="btn-confirm" class="btn bg-bgn-primary text-white rounded-1 py-3 fw-bold d-none">
                        <i class="fas fa-check-square me-2"></i> KONFIRMASI SAMPAI & FOTO
                    </button>
                </div>

                <div class="mt-4 alert alert-warning border-0 rounded-1">
                    <small><i class="fas fa-exclamation-triangle me-1"></i> <strong>Instruksi Resmi:</strong> Pastikan GPS perangkat Anda aktif selama perjalanan dinas distribusi berlangsung.</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Live Preview Map -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow-sm border-0 rounded-1 h-100">
            <div class="card-header bg-bgn-primary text-white d-flex justify-content-between align-items-center">
                <span><i class="fas fa-map-marked-alt me-2 text-bgn-gold"></i> Peta Pantauan Kurir</span>
                <span class="badge bg-bgn-gold text-dark">Live</span>
            </div>
            <div class="card-body p-0">
                <div id="mini-map" style="height: 100%; min-height: 450px;" class="rounded-bottom"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let watchId = null;
    const miniMap = L.map('mini-map').setView([-7.7956, 110.3695], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(miniMap);
    let driverMarker = L.marker([-7.7956, 110.3695]).addTo(miniMap);

    const btnStart = document.getElementById('btn-start');
    const btnConfirm = document.getElementById('btn-confirm');
    const statusBox = document.getElementById('tracking-status');

    btnStart.addEventListener('click', () => {
        if (!navigator.geolocation) {
            alert('GPS tidak didukung oleh browser Anda.');
            return;
        }

        btnStart.classList.add('d-none');
        btnConfirm.classList.remove('d-none');
        statusBox.classList.replace('bg-secondary', 'bg-success');
        statusBox.innerHTML = 'SEDANG MENGIRIM (LIVE)';

        watchId = navigator.geolocation.watchPosition((position) => {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            // Update local mini map
            const newPos = [lat, lng];
            driverMarker.setLatLng(newPos);
            miniMap.panTo(newPos);

            // Update database via API
            fetch('/api/location', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ lat, lng })
            });

        }, (err) => {
            console.error(err);
        }, {
            enableHighAccuracy: true,
            maximumAge: 0,
            timeout: 5000
        });
    });

    // btnConfirm event listener
    btnConfirm.addEventListener('click', () => {
        if (watchId) navigator.geolocation.clearWatch(watchId);
        
        btnConfirm.classList.add('disabled');
        btnConfirm.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Mengunggah Foto...';
        
        setTimeout(() => {
            alert('Pengiriman Berhasil Dikonfirmasi! Foto bukti telah tersimpan.');
            // Update status via API instead of socket
            fetch('/api/location', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: 'delivered' })
            }).then(() => location.reload());
        }, 2000);
    });
</script>
@endsection
