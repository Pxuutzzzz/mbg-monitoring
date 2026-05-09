@extends('layouts.app')

@section('title', 'Dashboard Publik')
@section('container-type', 'container-fluid p-0')
@section('header', '')

@section('content')
<!-- Dashboard Banner -->
<div class="dashboard-banner text-white position-relative d-flex align-items-center hero-responsive" style="border-bottom: 4px solid var(--bgn-gold); background: linear-gradient(rgba(7, 30, 73, 0.75), rgba(7, 30, 73, 0.90)), url('{{ asset('images/children.png') }}') center center/cover no-repeat;">
    <div class="container position-relative z-index-2">
        <div class="row align-items-center">
            <div class="col-lg-9">
                <h5 class="text-bgn-gold mb-3 d-none d-md-block" style="letter-spacing: 3px; font-weight: 700; text-transform: uppercase;">Badan Gizi Nasional Republik Indonesia</h5>
                <h6 class="text-bgn-gold mb-2 d-md-none" style="letter-spacing: 1px; font-weight: 700; text-transform: uppercase;">Badan Gizi Nasional RI</h6>
                <h1 class="fw-bold mb-4 hero-title" style="font-family: 'Montserrat', sans-serif; line-height: 1.2;">Sistem Monitoring Nasional Program Makan Bergizi Gratis</h1>
                <p class="text-white-75 mb-0 fs-5" style="font-weight: 300;">Portal Transparansi dan Pengawasan Distribusi Nutrisi Nasional</p>
            </div>
            <div class="col-lg-3 text-lg-end mt-4 mt-lg-0">
                <a href="#kpi-section" class="btn btn-gold-outline btn-lg rounded-1 px-4 py-3 fw-bold w-100 d-lg-inline-block" style="font-size: 1.1rem; max-width: 300px;">
                    <i class="fas fa-chart-bar me-2"></i> DATA STATISTIK
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Section (Former KPI) -->
<div id="kpi-section" class="container mt-4 mb-5">
    <div class="row text-center g-3">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-1 h-100">
                <div class="card-body py-4">
                    <h3 class="fw-bold text-bgn-primary mb-1">12,500</h3>
                    <p class="text-muted fw-semibold mb-0" style="font-size: 0.85rem; letter-spacing: 1px;">TOTAL PORSI</p>
                </div>
                <div class="card-footer bg-bgn-primary p-1"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-1 h-100">
                <div class="card-body py-4">
                    <h3 class="fw-bold text-bgn-success mb-1">98.5%</h3>
                    <p class="text-muted fw-semibold mb-0" style="font-size: 0.85rem; letter-spacing: 1px;">KETEPATAN WAKTU</p>
                </div>
                <div class="card-footer bg-bgn-success p-1"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-1 h-100">
                <div class="card-body py-4">
                    <h3 class="fw-bold text-bgn-primary mb-1">Rp 15.000</h3>
                    <p class="text-muted fw-semibold mb-0" style="font-size: 0.85rem; letter-spacing: 1px;">ANGGARAN / PORSI</p>
                </div>
                <div class="card-footer bg-bgn-info p-1"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-1 h-100">
                <div class="card-body py-4">
                    <h3 class="fw-bold text-bgn-gold mb-1">2045</h3>
                    <p class="text-muted fw-semibold mb-0" style="font-size: 0.85rem; letter-spacing: 1px;">VISI INDONESIA</p>
                </div>
                <div class="card-footer bg-bgn-gold p-1"></div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Real-time Map -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-bgn-primary text-white">
                    <h3 class="card-title"><i class="fas fa-map-marker-alt"></i> Live Tracking Distribusi</h3>
                </div>
                <div class="card-body p-0">
                    <div id="map"></div>
                </div>
            </div>
        </div>

        <!-- Budget Breakdown Chart -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-bgn-primary text-white">
                    <h3 class="card-title"><i class="fas fa-chart-pie"></i> Breakdown Anggaran</h3>
                </div>
                <div class="card-body">
                    <canvas id="budgetChart"></canvas>
                    <div class="mt-4">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                Bahan Baku (67%)
                                <span class="badge bg-bgn-success rounded-pill">Rp 10.000</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                Transportasi (13%)
                                <span class="badge bg-bgn-gold rounded-pill">Rp 2.000</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                Tenaga Kerja (20%)
                                <span class="badge bg-bgn-info rounded-pill">Rp 3.000</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Leaflet Map Initialization - Centered on Indonesia
    const map = L.map('map').setView([-2.5489, 118.0149], 5);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Custom Marker for Kitchens (Dapur Umum)
    const kitchenIcon = L.divIcon({
        html: '<i class="fas fa-store fa-lg text-bgn-gold shadow-sm" style="background: white; padding: 5px; border-radius: 50%; border: 2px solid #071e49;"></i>',
        className: 'custom-kitchen-icon',
        iconSize: [30, 30],
        iconAnchor: [15, 15]
    });

    // Kitchen Locations Array (Nasional)
    const kitchens = [
        // Sumatera
        { name: "SPPG Banda Aceh", lat: 5.5483, lng: 95.3238, porsi: "8.500 Porsi" },
        { name: "SPPG Medan", lat: 3.5952, lng: 98.6722, porsi: "15.000 Porsi" },
        { name: "SPPG Padang", lat: -0.9471, lng: 100.3692, porsi: "10.000 Porsi" },
        { name: "SPPG Pekanbaru", lat: 0.5071, lng: 101.4451, porsi: "12.000 Porsi" },
        { name: "SPPG Jambi", lat: -1.6101, lng: 103.6131, porsi: "7.000 Porsi" },
        { name: "SPPG Palembang", lat: -2.9909, lng: 104.7566, porsi: "14.000 Porsi" },
        { name: "SPPG Bengkulu", lat: -3.7928, lng: 102.2608, porsi: "6.500 Porsi" },
        { name: "SPPG Bandar Lampung", lat: -5.4500, lng: 105.2667, porsi: "11.500 Porsi" },
        { name: "SPPG Pangkal Pinang", lat: -2.1290, lng: 106.1097, porsi: "5.000 Porsi" },
        
        // Jawa & Bali
        { name: "SPPG Jakarta Pusat", lat: -6.1805, lng: 106.8284, porsi: "20.000 Porsi" },
        { name: "SPPG Bogor", lat: -6.5971, lng: 106.7915, porsi: "18.000 Porsi" },
        { name: "SPPG Bandung", lat: -6.9175, lng: 107.6191, porsi: "19.000 Porsi" },
        { name: "SPPG Cirebon", lat: -6.7320, lng: 108.5523, porsi: "9.000 Porsi" },
        { name: "SPPG Semarang", lat: -6.9667, lng: 110.4167, porsi: "16.000 Porsi" },
        { name: "SPPG Surakarta", lat: -7.5666, lng: 110.8166, porsi: "12.000 Porsi" },
        { name: "SPPG Yogyakarta", lat: -7.7956, lng: 110.3695, porsi: "15.000 Porsi" },
        { name: "SPPG Surabaya", lat: -7.2504, lng: 112.7688, porsi: "22.000 Porsi" },
        { name: "SPPG Malang", lat: -7.9797, lng: 112.6304, porsi: "14.500 Porsi" },
        { name: "SPPG Banyuwangi", lat: -8.2192, lng: 114.3692, porsi: "8.000 Porsi" },
        { name: "SPPG Denpasar", lat: -8.6500, lng: 115.2167, porsi: "12.500 Porsi" },

        // Nusa Tenggara
        { name: "SPPG Mataram", lat: -8.5833, lng: 116.1167, porsi: "9.000 Porsi" },
        { name: "SPPG Kupang", lat: -10.1583, lng: 123.5833, porsi: "11.000 Porsi" },

        // Kalimantan
        { name: "SPPG Pontianak", lat: -0.0227, lng: 109.3324, porsi: "10.000 Porsi" },
        { name: "SPPG Palangkaraya", lat: -2.2083, lng: 113.9167, porsi: "7.500 Porsi" },
        { name: "SPPG Banjarmasin", lat: -3.3167, lng: 114.5833, porsi: "11.000 Porsi" },
        { name: "SPPG Balikpapan", lat: -1.2651, lng: 116.8279, porsi: "13.000 Porsi" },
        { name: "SPPG Samarinda", lat: -0.5022, lng: 117.1536, porsi: "12.500 Porsi" },
        { name: "SPPG Tarakan", lat: 3.3034, lng: 117.6326, porsi: "6.000 Porsi" },

        // Sulawesi
        { name: "SPPG Manado", lat: 1.4822, lng: 124.8489, porsi: "9.500 Porsi" },
        { name: "SPPG Gorontalo", lat: 0.5408, lng: 123.0595, porsi: "6.000 Porsi" },
        { name: "SPPG Palu", lat: -0.8917, lng: 119.8707, porsi: "8.000 Porsi" },
        { name: "SPPG Makassar", lat: -5.1476, lng: 119.4327, porsi: "16.500 Porsi" },
        { name: "SPPG Kendari", lat: -3.9983, lng: 122.5127, porsi: "7.000 Porsi" },

        // Maluku & Papua
        { name: "SPPG Ambon", lat: -3.6958, lng: 128.1814, porsi: "8.500 Porsi" },
        { name: "SPPG Ternate", lat: 0.7932, lng: 127.3828, porsi: "6.500 Porsi" },
        { name: "SPPG Sorong", lat: -0.8761, lng: 131.2558, porsi: "7.000 Porsi" },
        { name: "SPPG Manokwari", lat: -0.8615, lng: 134.0620, porsi: "5.500 Porsi" },
        { name: "SPPG Jayapura", lat: -2.5337, lng: 140.7181, porsi: "9.000 Porsi" },
        { name: "SPPG Merauke", lat: -8.4984, lng: 140.4042, porsi: "6.000 Porsi" },
        { name: "SPPG Timika", lat: -4.5458, lng: 136.8833, porsi: "8.000 Porsi" }
    ];

    // Render Kitchen Markers
    kitchens.forEach(k => {
        L.marker([k.lat, k.lng], {icon: kitchenIcon}).addTo(map)
            .bindPopup(`<b class="text-bgn-primary">${k.name}</b><br>Kapasitas: ${k.porsi}<br><span class="badge bg-bgn-success mt-1">Beroperasi</span>`);
    });

    // Custom Marker for Live Delivery Truck
    const bgnIcon = L.divIcon({
        html: '<i class="fas fa-truck-moving fa-2x text-bgn-success" style="filter: drop-shadow(0px 2px 2px rgba(0,0,0,0.3));"></i>',
        className: 'custom-div-icon',
        iconSize: [30, 30],
        iconAnchor: [15, 15]
    });

    // We start the live driver tracker somewhere in Java as a placeholder before it polls
    let marker = L.marker([-7.7956, 110.3695], {icon: bgnIcon}).addTo(map)
        .bindPopup('<b>Driver Live (Mencari Sinyal...)</b>')
        .openPopup();

    // Live GPS Polling (Replaces Socket.io for environments without Node.js)
    setInterval(() => {
        fetch('/api/location')
            .then(res => res.json())
            .then(data => {
                if (data.lat && data.lng) {
                    const newPos = [data.lat, data.lng];
                    marker.setLatLng(newPos);
                    marker.setPopupContent('<b>' + data.driver + '</b><br>Status: Transit (LIVE)');
                    // map.panTo(newPos); // Optional: uncomment if you want the map to follow the truck automatically
                }
            })
            .catch(err => console.error('GPS Sync Error', err));
    }, 3000); // Poll every 3 seconds

    // Chart.js Budget Pie
    const ctx = document.getElementById('budgetChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Bahan Rp10k (67%)', 'Transport Rp2k (13%)', 'Tenaga Rp3k (20%)'],
            datasets: [{
                data: [10000, 2000, 3000],
                backgroundColor: ['#92d05d', '#d1b06c', '#b5e0ea'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endsection
