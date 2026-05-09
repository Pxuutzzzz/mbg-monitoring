@extends('layouts.app')

@section('title', 'Katalog Menu Gizi Harian')
@section('header', 'Katalog Menu Gizi Nasional')

@section('content')

<!-- Bilah Pencarian Mitra -->
<div class="row mb-4">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm border-0 bg-light">
            <div class="card-body p-3">
                <form action="{{ route('nutrition') }}" method="GET" class="d-flex align-items-center">
                    <input type="hidden" name="tab" value="{{ $activeTab }}">
                    <label class="fw-bold me-3 mb-0 text-bgn-primary text-nowrap"><i class="fas fa-search me-1"></i> Cari Mitra/Dapur:</label>
                    <select name="sppg_id" class="form-select border-primary me-2">
                        <option value="">-- Tampilkan Seluruh Rekapitulasi Nasional --</option>
                        @foreach($allSppgs as $sppg)
                            <option value="{{ $sppg->id }}" {{ $sppgId == $sppg->id ? 'selected' : '' }}>
                                {{ $sppg->name }} ({{ $sppg->location }})
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn bg-bgn-primary text-white text-nowrap"><i class="fas fa-filter me-1"></i> Terapkan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Navigasi Target Demografi -->
<div class="row mb-4">
    <div class="col-12">
        @php
            $tabGroups = [
                '🟡 Porsi Kecil'    => ['PAUD/TK', 'SD Kelas 1-3', 'Balita'],
                '🟢 Porsi Besar'    => ['SD Kelas 4-6', 'SMP', 'SMA/SMK'],
                '🕌 Pesantren'      => [
                    'Pesantren - RA/TK',
                    'Pesantren - MI Kelas 1-3',
                    'Pesantren - MI Kelas 4-6',
                    'Pesantren - MTs',
                    'Pesantren - MA/MAK',
                    'Pesantren - Santri',
                ],
                '🔵 Penerima Khusus'=> ['Ibu Hamil', 'Ibu Menyusui', 'Guru/Pendidik'],
            ];
            $tabLabels = [
                'PAUD/TK'               => 'PAUD / TK',
                'SD Kelas 1-3'          => 'SD Kls 1–3',
                'Balita'                => 'Balita',
                'SD Kelas 4-6'          => 'SD Kls 4–6',
                'SMP'                   => 'SMP',
                'SMA/SMK'               => 'SMA/SMK',
                'Pesantren - RA/TK'     => 'RA / TK',
                'Pesantren - MI Kelas 1-3' => 'MI Kls 1–3',
                'Pesantren - MI Kelas 4-6' => 'MI Kls 4–6',
                'Pesantren - MTs'       => 'MTs',
                'Pesantren - MA/MAK'    => 'MA / MAK',
                'Pesantren - Santri'    => 'Santri Boarding',
                'Ibu Hamil'             => 'Ibu Hamil',
                'Ibu Menyusui'          => 'Ibu Menyusui',
                'Guru/Pendidik'         => 'Guru / Pendidik',
            ];
        @endphp
        <div class="card border-0 shadow-sm">
            <div class="card-body p-2">
                @foreach($tabGroups as $groupLabel => $groupTabs)
                <div class="mb-2">
                    <div class="px-2 py-1 mb-1">
                        <small class="text-muted fw-bold text-uppercase" style="font-size:0.7rem;letter-spacing:1px;">{{ $groupLabel }}</small>
                    </div>
                    <div class="d-flex flex-wrap gap-1 ps-2 pb-1">
                        @foreach($groupTabs as $tab)
                            @if(in_array($tab, $validTabs))
                            <a href="{{ route('nutrition', ['tab' => $tab, 'sppg_id' => $sppgId]) }}"
                               class="btn btn-sm fw-bold {{ $activeTab === $tab ? 'btn-bgn-primary text-white' : 'btn-outline-secondary' }}"
                               style="{{ $activeTab === $tab ? 'background:#071e49;border-color:#071e49;' : '' }}">
                               {{ $tabLabels[$tab] ?? $tab }}
                            </a>
                            @endif
                        @endforeach
                    </div>
                </div>
                @if(!$loop->last)<hr class="my-1">@endif
                @endforeach
            </div>
        </div>
    </div>
</div>

@if($sppgId)
    <!-- SKENARIO A: MITRA SPESIFIK DIPILIH -->
    <div class="alert alert-info border-0 shadow-sm mb-4">
        <i class="fas fa-info-circle me-2"></i> Menampilkan rancangan menu gizi yang secara spesifik dimasak oleh: <strong>{{ $selectedSppg->name ?? 'Mitra Terpilih' }}</strong>
    </div>

    <!-- Tampilan Menu Hari Ini vs Besok -->
    <div class="row mb-5">
        <!-- Menu Hari Ini -->
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="card h-100 shadow border-0" style="border-top: 4px solid #28a745 !important;">
                <div class="card-header bg-white text-center py-3">
                    <h4 class="mb-0 fw-bold text-success"><i class="fas fa-calendar-day me-2"></i> MENU HARI INI</h4>
                    <p class="text-muted small mb-0">{{ \Carbon\Carbon::today()->format('d F Y') }}</p>
                </div>
                <div class="card-body">
                    @if($menuToday)
                        <div class="text-center mb-4">
                            <div class="display-6 fw-bold text-dark mb-2">{{ $menuToday->food_name }}</div>
                            <span class="badge bg-light text-dark border"><i class="fas fa-building me-1"></i> Dimasak oleh: {{ $menuToday->sppg->name ?? 'Dapur Pusat' }}</span>
                        </div>

                        <h6 class="fw-bold text-muted text-uppercase mb-3 border-bottom pb-2">Rincian Gizi Makro</h6>
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="p-3 bg-light rounded shadow-sm">
                                    <h3 class="fw-bold text-warning mb-0">{{ $menuToday->calories }}</h3>
                                    <small class="text-muted text-uppercase fw-bold">Kalori (Kkal)</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="p-3 bg-light rounded shadow-sm">
                                    <h3 class="fw-bold text-info mb-0">{{ $menuToday->protein_g }}g</h3>
                                    <small class="text-muted text-uppercase fw-bold">Protein</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-light rounded shadow-sm">
                                    <h3 class="fw-bold text-success mb-0">{{ $menuToday->karbo_g }}g</h3>
                                    <small class="text-muted text-uppercase fw-bold">Karbohidrat</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-light rounded shadow-sm">
                                    <h3 class="fw-bold text-danger mb-0">{{ $menuToday->fat_g }}g</h3>
                                    <small class="text-muted text-uppercase fw-bold">Lemak</small>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="d-flex flex-column justify-content-center align-items-center h-100 py-5 text-muted">
                            <i class="fas fa-utensils fa-3x mb-3 opacity-25"></i>
                            <h5>Menu Belum Diinput</h5>
                            <p class="text-center">Mitra Gizi ini belum memasukkan data menu untuk hari ini pada kelompok {{ $activeTab }}.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Menu Besok -->
        <div class="col-md-6">
            <div class="card h-100 shadow border-0" style="border-top: 4px solid #17a2b8 !important;">
                <div class="card-header bg-white text-center py-3">
                    <h4 class="mb-0 fw-bold text-info"><i class="fas fa-calendar-alt me-2"></i> RENCANA MENU BESOK</h4>
                    <p class="text-muted small mb-0">{{ \Carbon\Carbon::tomorrow()->format('d F Y') }}</p>
                </div>
                <div class="card-body">
                    @if($menuTomorrow)
                        <div class="text-center mb-4">
                            <div class="display-6 fw-bold text-dark mb-2">{{ $menuTomorrow->food_name }}</div>
                            <span class="badge bg-light text-dark border"><i class="fas fa-building me-1"></i> Disiapkan oleh: {{ $menuTomorrow->sppg->name ?? 'Dapur Pusat' }}</span>
                        </div>

                        <h6 class="fw-bold text-muted text-uppercase mb-3 border-bottom pb-2">Rincian Gizi Makro</h6>
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="p-3 bg-light rounded shadow-sm">
                                    <h3 class="fw-bold text-warning mb-0">{{ $menuTomorrow->calories }}</h3>
                                    <small class="text-muted text-uppercase fw-bold">Kalori (Kkal)</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="p-3 bg-light rounded shadow-sm">
                                    <h3 class="fw-bold text-info mb-0">{{ $menuTomorrow->protein_g }}g</h3>
                                    <small class="text-muted text-uppercase fw-bold">Protein</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-light rounded shadow-sm">
                                    <h3 class="fw-bold text-success mb-0">{{ $menuTomorrow->karbo_g }}g</h3>
                                    <small class="text-muted text-uppercase fw-bold">Karbohidrat</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-light rounded shadow-sm">
                                    <h3 class="fw-bold text-danger mb-0">{{ $menuTomorrow->fat_g }}g</h3>
                                    <small class="text-muted text-uppercase fw-bold">Lemak</small>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="d-flex flex-column justify-content-center align-items-center h-100 py-5 text-muted">
                            <i class="fas fa-clipboard-list fa-3x mb-3 opacity-25"></i>
                            <h5>Rencana Belum Dibuat</h5>
                            <p class="text-center">Mitra Gizi ini sedang menyusun rencana masakan esok hari untuk {{ $activeTab }}.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@else
    <!-- SKENARIO B: REKAPITULASI NASIONAL (TIDAK ADA MITRA YANG DIPILIH) -->
    <div class="row mb-5">
        <div class="col-12">
            <h4 class="mb-4 fw-bold text-bgn-primary"><i class="fas fa-globe-asia me-2 text-bgn-gold"></i> Rekapitulasi Menu Nasional - Kategori {{ $activeTab }}</h4>
            
            @if($recapMenus->isEmpty())
                <div class="alert alert-warning">Belum ada mitra yang menginput menu untuk kategori ini hari ini/besok.</div>
            @else
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @foreach($recapMenus as $menu)
                        <div class="col">
                            <div class="card h-100 shadow-sm border-0 border-start border-4 {{ $menu->serve_date == date('Y-m-d') ? 'border-success' : 'border-info' }}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="badge {{ $menu->serve_date == date('Y-m-d') ? 'bg-success' : 'bg-info' }}">
                                            {{ $menu->serve_date == date('Y-m-d') ? 'HARI INI' : 'BESOK' }}
                                        </span>
                                        <small class="text-muted fw-bold">{{ $menu->calories }} Kkal</small>
                                    </div>
                                    <h5 class="card-title fw-bold text-dark">{{ $menu->food_name }}</h5>
                                    <p class="card-text text-muted small mb-3">
                                        <i class="fas fa-building me-1"></i> {{ $menu->sppg->name ?? 'Dapur Pusat' }}<br>
                                        <i class="fas fa-map-marker-alt me-1 text-danger"></i> {{ $menu->sppg->location ?? '-' }}
                                    </p>
                                    
                                    <div class="d-flex justify-content-between text-center mt-auto pt-3 border-top">
                                        <div><small class="d-block text-muted">Pro</small><strong class="text-info">{{ $menu->protein_g }}g</strong></div>
                                        <div><small class="d-block text-muted">Karbo</small><strong class="text-success">{{ $menu->karbo_g }}g</strong></div>
                                        <div><small class="d-block text-muted">Lemak</small><strong class="text-danger">{{ $menu->fat_g }}g</strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endif

<!-- Riwayat Audit Distribusi -->
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0 rounded-1 h-100">
            <div class="card-header bg-bgn-primary text-white d-flex justify-content-between align-items-center py-3">
                <h3 class="card-title mb-0 fs-5"><i class="fas fa-clipboard-check me-2 text-bgn-gold"></i> Riwayat Audit Pemenuhan Gizi Lapangan</h3>
                <a href="{{ route('nutrition.export') }}" class="btn btn-sm btn-outline-light fw-bold"><i class="fas fa-download me-1"></i> UNDUH PDF</a>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table id="nutritionTable" class="table table-bordered table-striped table-hover align-middle mb-0" style="font-size: 0.9rem; width: 100%;">
                        <thead class="bg-light text-uppercase" style="font-size: 0.8rem; letter-spacing: 0.5px;">
                            <tr>
                                <th>Tanggal Distribusi</th>
                                <th>Jenjang</th>
                                <th>Total Kalori Diterima</th>
                                <th>Total Protein Diterima</th>
                                <th class="text-center">Status Audit BGN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nutritions as $nutrition)
                            <tr>
                                <td class="fw-bold">{{ $nutrition->created_at->format('d M Y') }}</td>
                                <td><span class="badge bg-light text-dark border">SD / Sederajat</span></td>
                                <td>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="fw-medium">{{ $nutrition->calories }} Kkal</span>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-success" style="width: 100%"></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="fw-medium">{{ $nutrition->protein_g }} Gram</span>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-info" style="width: 100%"></div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-bgn-success px-3 py-2 rounded-1 fw-bold"><i class="fas fa-check-circle me-1"></i> SESUAI STANDAR MENU</span>
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
