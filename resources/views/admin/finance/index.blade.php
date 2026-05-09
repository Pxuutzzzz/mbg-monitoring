@extends('admin.layouts.app')

@section('title', 'Manajemen Keuangan SPPG')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="fw-bold"><i class="fas fa-file-invoice-dollar text-primary me-2"></i> Manajemen Keuangan SPPG</h1>
            </div>
            <div class="col-sm-6 text-end">
                <a href="{{ route('finance') }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-external-link-alt me-1"></i> Lihat Halaman Publik
                </a>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Standar BGN Info --}}
        <div class="alert alert-info border-0 shadow-sm mb-4">
            <strong><i class="fas fa-info-circle me-2"></i> Pedoman Anggaran MBG BGN 2026:</strong>
            Bahan baku <strong>Rp 8.000 – Rp 10.000/porsi</strong> &bull;
            Dana operasional <strong>Rp 3.000/porsi</strong> &bull;
            Maks. produksi per SPPG: <strong>2.500 porsi/hari</strong> (2.000 anak sekolah + 500 ibu/balita)
        </div>

        <div class="row">
            {{-- Form Tambah Catatan Keuangan --}}
            <div class="col-md-4 mb-4">
                <div class="card card-primary card-outline h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-plus-circle me-2"></i> Tambah Catatan Keuangan
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.finance.store') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="fw-bold">Mitra SPPG</label>
                                <select name="sppg_id" class="form-control" required>
                                    <option value="">-- Pilih Dapur SPPG --</option>
                                    @foreach($sppgs as $sppg)
                                        <option value="{{ $sppg->id }}">{{ $sppg->name }} ({{ $sppg->location }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="fw-bold">Tanggal Transaksi</label>
                                <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="fw-bold">Biaya Bahan Baku (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="bahan_cost" class="form-control" placeholder="Cth: 5500000" min="0" step="1000" required>
                                </div>
                                <small class="text-muted">Standar BGN: Rp 8.000–10.000 × jumlah porsi</small>
                            </div>
                            <div class="form-group mb-3">
                                <label class="fw-bold">Dana Operasional (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="transport_cost" class="form-control" placeholder="Cth: 1500000" min="0" step="1000" required>
                                </div>
                                <small class="text-muted">Standar BGN: Rp 3.000 × jumlah porsi</small>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 fw-bold">
                                <i class="fas fa-save me-2"></i> Simpan Catatan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Form Upload Invoice --}}
            <div class="col-md-4 mb-4">
                <div class="card card-success card-outline h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-upload me-2"></i> Unggah Bukti Invoice / SPJ
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.finance.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="fw-bold">Mitra SPPG</label>
                                <select name="sppg_id" class="form-control">
                                    <option value="">-- Pilih Dapur SPPG --</option>
                                    @foreach($sppgs as $sppg)
                                        <option value="{{ $sppg->id }}">{{ $sppg->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="fw-bold">Lampiran Invoice / SPJ (PDF/JPG)</label>
                                <input type="file" name="invoice" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                                <small class="text-muted">Maksimal 5MB. Pastikan stempel basah terlihat jelas.</small>
                            </div>
                            <div class="form-group mb-3">
                                <label class="fw-bold">Total Porsi Terdistribusi</label>
                                <div class="input-group">
                                    <input type="number" name="portions" class="form-control" value="500" min="1" max="2500" required>
                                    <span class="input-group-text">Porsi</span>
                                </div>
                                <small class="text-muted">Maks. 2.500 porsi per hari per SPPG sesuai Juklak BGN.</small>
                            </div>
                            <button type="submit" class="btn btn-success w-100 fw-bold">
                                <i class="fas fa-shield-alt me-2"></i> Otorisasi & Unggah
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Ringkasan Statistik --}}
            <div class="col-md-4 mb-4">
                <div class="card bg-primary text-white h-100">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                        <i class="fas fa-chart-line fa-4x mb-3 opacity-50"></i>
                        <h5 class="fw-bold text-uppercase">Total Catatan Tersimpan</h5>
                        <h1 class="display-4 fw-bold mb-1">{{ $records->count() }}</h1>
                        <p class="mb-2 opacity-75">Transaksi di seluruh SPPG</p>
                        <hr class="w-100 border-light opacity-50">
                        <h5 class="fw-bold text-uppercase mt-2">Total Anggaran Terserap</h5>
                        <h4 class="fw-bold mb-0">Rp {{ number_format($records->sum('total'), 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Catatan Keuangan --}}
        <div class="card card-outline card-primary shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="fas fa-table me-2"></i> Riwayat Catatan Keuangan SPPG
                </h5>
                <a href="{{ route('finance.export') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-print me-1"></i> Cetak PDF
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase" style="font-size:0.8rem;letter-spacing:0.4px;">
                            <tr>
                                <th>Tanggal</th>
                                <th>Mitra SPPG</th>
                                <th class="text-end">Bahan Baku</th>
                                <th class="text-end">Operasional</th>
                                <th class="text-end text-primary fw-bold">Total</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($records as $record)
                            <tr>
                                <td class="fw-medium">{{ \Carbon\Carbon::parse($record->date)->format('d M Y') }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border fw-bold">{{ $record->sppg->name ?? '—' }}</span><br>
                                    <small class="text-muted">{{ $record->sppg->location ?? '' }}</small>
                                </td>
                                <td class="text-end text-muted">Rp {{ number_format($record->bahan_cost, 0, ',', '.') }}</td>
                                <td class="text-end text-muted">Rp {{ number_format($record->transport_cost, 0, ',', '.') }}</td>
                                <td class="text-end fw-bold text-primary">Rp {{ number_format($record->total, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @php $perPortionEst = $record->total > 0 ? ($record->total / 500) : 0; @endphp
                                    @if($perPortionEst <= 13000 && $perPortionEst > 0)
                                        <span class="badge bg-success">✓ Sesuai Standar</span>
                                    @elseif($perPortionEst > 13000)
                                        <span class="badge bg-danger">⚠ Perlu Verifikasi</span>
                                    @else
                                        <span class="badge bg-secondary">Menunggu</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.finance.destroy', $record->id) }}" method="POST" onsubmit="return confirm('Hapus catatan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                                    Belum ada catatan keuangan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
