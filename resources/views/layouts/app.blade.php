<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MBG Monitoring') | Badan Gizi Nasional</title>

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&family=Pacifico&family=Inter:wght@300;400;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 & AdminLTE -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/bgn-custom.css?v=1.2">

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    @yield('styles')

    <!-- PWA -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#071e49">
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <!-- Header -->
        <!-- Header -->
        <nav class="main-header navbar navbar-expand-md navbar-dark border-bottom-0 navbar-inner bg-bgn-primary"
            style="box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <div class="container">


                <button class="navbar-toggler order-1" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a href="/" class="nav-link {{ Request::is('/') ? 'active' : '' }}">DASHBOARD</a>
                        </li>
                        <li class="nav-item">
                            <a href="/finance"
                                class="nav-link {{ Request::is('finance*') ? 'active' : '' }}">KEUANGAN</a>
                        </li>
                        <li class="nav-item">
                            <a href="/nutrition"
                                class="nav-link {{ Request::is('nutrition*') ? 'active' : '' }}">NUTRISI</a>
                        </li>
                        @guest
                            <li class="nav-item ms-lg-4">
                                <a href="{{ route('login') }}" class="btn btn-gold-outline rounded-pill px-4">LOGIN</a>
                            </li>
                        @else
                            <li class="nav-item dropdown ms-lg-4">
                                <a id="navbarDropdown"
                                    class="nav-link dropdown-toggle btn btn-gold-outline rounded-pill px-4 text-white"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" v-pre>
                                    <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name ?? 'Admin' }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end shadow-sm border-0"
                                    aria-labelledby="navbarDropdown">
                                    @if(Auth::user()->role === 'admin')
                                        <a class="dropdown-item" href="/admin">
                                            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-muted"></i> Panel Admin
                                        </a>
                                        <div class="dropdown-divider"></div>
                                    @endif
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-danger"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Content -->
        <div class="content-wrapper">
            @hasSection('header')
                @if(trim($__env->yieldContent('header')))
                    <div class="content-header">
                        <div class="@yield('container-type', 'container')">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1 class="m-0"> @yield('header') </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            <div class="content {{ Request::is('/') ? 'p-0' : '' }}">
                <div class="@yield('container-type', 'container')">
                    @yield('content')
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer-bgn">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <h4 class="fw-bold mb-4">BGN MBG</h4>
                        <p class="text-white-50">Sistem Transparansi Monitoring Makan Bergizi Gratis Nasional.
                            Mewujudkan Generasi Emas Indonesia 2045 melalui pemenuhan gizi yang optimal.</p>
                        <div class="d-flex gap-3 mt-4">
                            <a href="#" class="btn btn-outline-light btn-sm rounded-circle"><i
                                    class="fab fa-facebook-f"></i></a>
                            <a href="#" class="btn btn-outline-light btn-sm rounded-circle"><i
                                    class="fab fa-instagram"></i></a>
                            <a href="#" class="btn btn-outline-light btn-sm rounded-circle"><i
                                    class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                        <h5>Navigasi</h5>
                        <a href="/" class="footer-link">Dashboard</a>
                        <a href="/driver" class="footer-link">Distribusi</a>
                        <a href="/finance" class="footer-link">Keuangan</a>
                        <a href="/nutrition" class="footer-link">Nutrisi</a>
                    </div>
                    <div class="col-lg-3 col-md-4 mb-4 mb-md-0">
                        <h5>Program Utama</h5>
                        <a href="#" class="footer-link">Generasi Emas 2045</a>
                        <a href="#" class="footer-link">Standar Gizi BGN</a>
                        <a href="#" class="footer-link">Transparansi Anggaran</a>
                        <a href="#" class="footer-link">Mitra Distribusi</a>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <h5>Kontak Kami</h5>
                        <p class="text-white-50"><i class="fas fa-map-marker-alt me-2 text-bgn-gold"></i> Jakarta,
                            Indonesia</p>
                        <p class="text-white-50"><i class="fas fa-envelope me-2 text-bgn-gold"></i> info@bgn.go.id</p>
                        <p class="text-white-50"><i class="fas fa-phone me-2 text-bgn-gold"></i> (021) 1234567</p>
                    </div>
                </div>
                <div class="footer-bottom text-center">
                    <p class="mb-0">© 2026 Badan Gizi Nasional</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>

    @yield('scripts')

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js');
            });
        }
    </script>
</body>

</html>