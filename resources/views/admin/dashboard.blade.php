@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('header', 'Pusat Kendali BGN')

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>10</h3>
                <p>Total SPPG Aktif</p>
            </div>
            <div class="icon">
                <i class="fas fa-building"></i>
            </div>
            <a href="#" class="small-box-footer">Info detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>12.500<sup style="font-size: 20px"></sup></h3>
                <p>Target Porsi Harian</p>
            </div>
            <div class="icon">
                <i class="fas fa-utensils"></i>
            </div>
            <a href="#" class="small-box-footer">Info detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>98.5<sup style="font-size: 20px">%</sup></h3>
                <p>Ketepatan Distribusi</p>
            </div>
            <div class="icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <a href="#" class="small-box-footer">Info detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>Rp 120M</h3>
                <p>Serapan Anggaran</p>
            </div>
            <div class="icon">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
            <a href="#" class="small-box-footer">Info detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>

<div class="row">
    <section class="col-lg-7 connectedSortable">
        <div class="card">
            <div class="card-header border-transparent bg-bgn-primary text-white">
                <h3 class="card-title">Aktivitas Terbaru</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                        <tr>
                            <th>ID Transaksi</th>
                            <th>Aktivitas</th>
                            <th>Status</th>
                            <th>Waktu</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><a href="#">TRX-88291</a></td>
                            <td>Distribusi SPPG Malioboro selesai</td>
                            <td><span class="badge badge-success">Success</span></td>
                            <td>10:05 WIB</td>
                        </tr>
                        <tr>
                            <td><a href="#">TRX-88290</a></td>
                            <td>Kurir standby di SPPG Sleman</td>
                            <td><span class="badge badge-warning">Pending</span></td>
                            <td>09:30 WIB</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer clearfix">
                <a href="#" class="btn btn-sm btn-info float-left">Buat Laporan Baru</a>
                <a href="#" class="btn btn-sm btn-secondary float-right">Lihat Semua Log</a>
            </div>
        </div>
    </section>

    <section class="col-lg-5 connectedSortable">
        <div class="card bg-gradient-success">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="far fa-calendar-alt"></i>
                    Kalender Operasional
                </h3>
            </div>
            <div class="card-body pt-0">
                <p class="text-center mt-3">Sistem beroperasi normal. Tidak ada insiden hari ini.</p>
            </div>
        </div>
    </section>
</div>
@endsection
