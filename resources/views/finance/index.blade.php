@extends('layouts.app')

@section('title', 'Laporan Keuangan')
@section('header', 'Monitoring Keuangan SPPG')

@section('content')

<!-- Bilah Pencarian Mitra -->
<div class="row mb-4">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm border-0 bg-light">
            <div class="card-body p-3">
                <form action="{{ route('finance') }}" method="GET" class="d-flex align-items-center">
                    <label class="fw-bold me-3 mb-0 text-bgn-primary text-nowrap"><i class="fas fa-search me-1"></i> Telusuri Dapur Umum:</label>
                    <select name="sppg_id" class="form-select border-primary me-2">
                        <option value="">-- Tampilkan Agregat Nasional --</option>
                        @foreach($allSppgs as $sppg)
                            <option value="{{ $sppg->id }}" {{ $sppgId == $sppg->id ? 'selected' : '' }}>
                                {{ $sppg->name }} ({{ $sppg->location }})
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn bg-bgn-primary text-white text-nowrap"><i class="fas fa-filter me-1"></i> Bedah Keuangan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@if($sppgId)
<!-- Kartu Rincian Unit Cost Mitra -->
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-info border-0 shadow-sm mb-4">
            <i class="fas fa-chart-pie me-2"></i> Rincian Efisiensi Anggaran Khusus Untuk Mitra: <strong>{{ $selectedSppg->name ?? 'Mitra Terpilih' }}</strong>
        </div>
        <div class="d-flex gap-2 flex-wrap mt-2">
            <span class="badge bg-success fs-6 px-3 py-2"><i class="fas fa-check me-1"></i> Standar BGN 2026: Bahan Baku Rp 8.000–10.000/porsi</span>
            <span class="badge bg-info fs-6 px-3 py-2"><i class="fas fa-info-circle me-1"></i> Dana Operasional: Rp 3.000/porsi</span>
            <span class="badge bg-warning text-dark fs-6 px-3 py-2"><i class="fas fa-boxes me-1"></i> Maks. 2.500 porsi/hari per SPPG</span>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card bg-bgn-primary text-white h-100 shadow border-0 rounded-1">
            <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                <i class="fas fa-wallet fa-3x mb-3 text-bgn-gold"></i>
                <h5 class="fw-bold text-uppercase">Total Anggaran Keluar</h5>
                <h2 class="display-6 fw-bold mb-0">Rp {{ number_format($totalBudget, 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card bg-success text-white h-100 shadow border-0 rounded-1">
            <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                <i class="fas fa-user-graduate fa-2x mb-2 text-white-50"></i>
                <small class="fw-bold text-uppercase opacity-75">Porsi Besar</small>
                <h3 class="fw-bold mb-0">{{ number_format($totalPortions, 0, ',', '.') }}</h3>
                <small class="opacity-75">SD–SMA & Pesantren</small>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card bg-teal text-white h-100 shadow border-0 rounded-1" style="background-color:#20c997!important;">
            <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                <i class="fas fa-baby fa-2x mb-2 text-white-50"></i>
                <small class="fw-bold text-uppercase opacity-75">Porsi Kecil</small>
                <h3 class="fw-bold mb-0">{{ number_format($records->first()?->delivery?->portions_kecil ?? 0, 0, ',', '.') }}</h3>
                <small class="opacity-75">TK, Balita & Ibu Hamil</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card bg-warning text-dark h-100 shadow border-0 rounded-1">
            <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                <i class="fas fa-tags fa-3x mb-3 text-dark opacity-50"></i>
                <h5 class="fw-bold text-uppercase">Biaya / Harga Per Porsi</h5>
                <div class="d-flex gap-3 mt-1">
                    <div class="text-center">
                        <div class="fw-bold fs-5">Rp {{ number_format($costPerPortion, 0, ',', '.') }}</div>
                        <small class="text-muted fw-bold">Rata-rata</small>
                    </div>
                </div>
                @if($costPerPortion > 0 && $costPerPortion <= 17000)
                    <span class="badge bg-success mt-2"><i class="fas fa-check-circle"></i> Efisien</span>
                @elseif($costPerPortion > 17000)
                    <span class="badge bg-danger mt-2"><i class="fas fa-exclamation-triangle"></i> Melebihi Pagu</span>
                @else
                    <span class="badge bg-secondary mt-2">Menunggu Data</span>
                @endif
            </div>
        </div>
    </div>
    <!-- Rincian Harga Per Komponen Menu (Dua Porsi) -->
    @if($records->count() > 0 && $records->first()->breakdown)
    @php
        $firstRecord  = $records->first();
        $latestBreakdown = $firstRecord->breakdown;
        $delivery = $firstRecord->delivery;
        $portionsBesar = $delivery?->portions_besar ?? 0;
        $portionsKecil = $delivery?->portions_kecil ?? 0;
        // Detect new format (array with besar/kecil) vs legacy (single int)
        $isNewFormat = is_array(array_values($latestBreakdown)[0] ?? null);
    @endphp
    <div class="col-12 mb-4">
        <div class="card shadow-sm border-0 rounded-1">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <h5 class="mb-1 fw-bold text-dark">
                            <i class="fas fa-receipt text-bgn-primary me-2"></i>
                            Rincian Harga Satuan Per Komponen Menu
                        </h5>
                        <small class="text-muted">
                            Tanggal: {{ \Carbon\Carbon::parse($firstRecord->date)->format('d F Y') }}
                            &mdash; <span class="text-success fw-bold">{{ number_format($portionsBesar, 0) }} Porsi Besar</span>
                            &mdash; <span class="text-info fw-bold">{{ number_format($portionsKecil, 0) }} Porsi Kecil</span>
                        </small>
                    </div>
                    @if($isNewFormat)
                    <div class="text-end">
                        <span class="badge bg-success fs-6 px-3 py-2 d-block mb-1">
                            Besar: Rp {{ number_format(array_sum(array_column($latestBreakdown, 'besar')), 0, ',', '.') }} / porsi
                        </span>
                        <span class="badge bg-info fs-6 px-3 py-2 d-block">
                            Kecil: Rp {{ number_format(array_sum(array_column($latestBreakdown, 'kecil')), 0, ',', '.') }} / porsi
                        </span>
                    </div>
                    @endif
                </div>
            </div>
            <div class="card-body p-0">
                @php
                    $colors   = ['text-danger', 'text-success', 'text-warning', 'text-info', 'text-primary', 'text-secondary'];
                    $bgPills  = ['bg-danger', 'bg-success', 'bg-warning', 'bg-info', 'bg-primary', 'bg-secondary'];
                    $i = 0;
                    $totalBesarUnit = 0;
                    $totalKecilUnit = 0;
                @endphp
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-uppercase" style="font-size:0.78rem;letter-spacing:0.4px;">
                        <tr>
                            <th>#</th>
                            <th>Komponen Menu</th>
                            <th class="text-end text-success">Harga / Porsi Besar<br><small class="fw-normal text-muted">(SD–SMA, Pesantren)</small></th>
                            <th class="text-end text-info">Harga / Porsi Kecil<br><small class="fw-normal text-muted">(TK, Balita, Ibu Hamil)</small></th>
                            <th class="text-center">Proporsi (Porsi Besar)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($isNewFormat)
                            @php $totalBesarUnit = array_sum(array_column($latestBreakdown, 'besar')); @endphp
                            @foreach($latestBreakdown as $component => $prices)
                                @php
                                    $priceBesar = $prices['besar'] ?? 0;
                                    $priceKecil = $prices['kecil'] ?? 0;
                                    $pct = $totalBesarUnit > 0 ? round(($priceBesar / $totalBesarUnit) * 100) : 0;
                                    $colorIdx = $i % count($colors);
                                    $i++;
                                @endphp
                                <tr>
                                    <td><span class="badge {{ $bgPills[$colorIdx] }} rounded-circle p-2">{{ $i }}</span></td>
                                    <td class="fw-bold">{{ $component }}</td>
                                    <td class="text-end fw-bold text-success fs-6">Rp {{ number_format($priceBesar, 0, ',', '.') }}</td>
                                    <td class="text-end fw-bold text-info fs-6">Rp {{ number_format($priceKecil, 0, ',', '.') }}</td>
                                    <td class="text-center" style="min-width:140px;">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="progress flex-grow-1" style="height:8px;">
                                                <div class="progress-bar {{ $bgPills[$colorIdx] }}" style="width:{{ $pct }}%"></div>
                                            </div>
                                            <small class="text-muted fw-bold" style="min-width:32px;">{{ $pct }}%</small>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            {{-- Legacy format (single price) --}}
                            @foreach($latestBreakdown as $component => $unitPrice)
                                @php $colorIdx = $i % count($colors); $i++; @endphp
                                <tr>
                                    <td><span class="badge {{ $bgPills[$colorIdx] }} rounded-circle p-2">{{ $i }}</span></td>
                                    <td class="fw-bold">{{ $component }}</td>
                                    <td class="text-end fw-bold text-success">Rp {{ number_format($unitPrice, 0, ',', '.') }}</td>
                                    <td class="text-end text-muted">—</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot class="table-secondary fw-bold">
                        <tr>
                            <td colspan="2" class="text-end text-uppercase text-bgn-primary">TOTAL / PORSI</td>
                            <td class="text-end text-success fs-5">
                                Rp {{ $isNewFormat ? number_format(array_sum(array_column($latestBreakdown, 'besar')), 0, ',', '.') : '—' }}
                            </td>
                            <td class="text-end text-info fs-5">
                                Rp {{ $isNewFormat ? number_format(array_sum(array_column($latestBreakdown, 'kecil')), 0, ',', '.') : '—' }}
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endif

<div class="row">
    <!-- Tabel Laporan Keuangan -->
    <div class="col-12 mb-4">
        <div class="card shadow-sm border-0 rounded-1 h-100">
            <div class="card-header bg-bgn-primary text-white d-flex justify-content-between align-items-center py-3">
                <h3 class="card-title mb-0 fs-5"><i class="fas fa-file-invoice-dollar me-2 text-bgn-gold"></i> {{ $sppgId ? 'Rincian Bukti Transaksi Mitra' : 'Rekapitulasi Anggaran Nasional' }}</h3>
                <a href="{{ route('finance.export') }}" class="btn btn-sm btn-outline-light fw-bold"><i class="fas fa-print me-1"></i> CETAK PDF</a>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table id="financeTable" class="table table-bordered table-striped table-hover align-middle mb-0" style="font-size: 0.9rem; width: 100%;">
                        <thead class="bg-light text-uppercase" style="font-size: 0.8rem; letter-spacing: 0.5px;">
                            <tr>
                                <th>Tanggal</th>
                                <th>Satuan Pelayanan</th>
                                <th class="text-end">Bahan Baku</th>
                                <th class="text-end">Transport</th>
                                <th class="text-end">Operasional</th>
                                <th class="text-end text-bgn-primary">Total SPPG</th>
                                <th class="text-center">Validasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($records as $record)
                            <tr>
                                <td class="fw-medium">{{ \Carbon\Carbon::parse($record->date)->format('d/m/Y') }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $record->sppg->name }}</span></td>
                                <td class="text-end text-muted">Rp {{ number_format($record->bahan_cost) }}</td>
                                <td class="text-end text-muted">Rp {{ number_format($record->transport_cost) }}</td>
                                <td class="text-end text-muted">Rp {{ number_format($record->total - $record->bahan_cost - $record->transport_cost) }}</td>
                                <td class="text-end fw-bold text-bgn-primary">Rp {{ number_format($record->total) }}</td>
                                <td class="text-center">
                                    <span class="text-success small fw-bold"><i class="fas fa-check-circle"></i> Valid</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#financeTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            }
        });
    });
</script>
@endsection
