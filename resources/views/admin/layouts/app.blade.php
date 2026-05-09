<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin BGN | @yield('title', 'Dashboard')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Custom CSS -->
    <style>
        .bg-bgn-primary { background-color: #071e49 !important; color: white; }
        .text-bgn-gold { color: #d1b06c !important; }
        .sidebar-dark-bgn { background-color: #071e49; }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/" class="nav-link">Lihat Portal Publik</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-bgn elevation-4">
        <!-- Brand Logo -->
        <a href="/admin" class="brand-link bg-bgn-primary text-center">
            <span class="brand-text font-weight-bold text-bgn-gold">BGN<span class="text-white">Admin</span></span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <div class="bg-light rounded-circle d-flex justify-content-center align-items-center" style="width: 34px; height: 34px;">
                        <i class="fas fa-user text-bgn-primary"></i>
                    </div>
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ Auth::user()->name ?? 'Administrator' }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-header">MANAJEMEN DATA</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.sppg') }}" class="nav-link {{ Request::routeIs('admin.sppg') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-building"></i>
                            <p>Satuan Pelayanan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.users') }}" class="nav-link {{ Request::routeIs('admin.users') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Manajemen Pengguna</p>
                        </a>
                    </li>
                    <li class="nav-header">PORTAL MITRA</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.menus') }}" class="nav-link {{ Request::routeIs('admin.menus') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-utensils"></i>
                            <p>Input Menu Gizi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.finance') }}" class="nav-link {{ Request::routeIs('admin.finance') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-invoice-dollar"></i>
                            <p>Manajemen Keuangan</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('header')</h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2026 <a href="https://bgn.go.id">Badan Gizi Nasional</a>.</strong>
        All rights reserved.
    </footer>

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
@yield('scripts')
</body>
</html>
