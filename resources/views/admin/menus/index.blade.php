@extends('admin.layouts.app')

@section('title', 'Input Menu Gizi')
@section('header', 'Input Rencana Menu Gizi Harian')

@section('content')
<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i> Sukses!</h5>
                {{ session('success') }}
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-bgn-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="card-title"><i class="fas fa-utensils mr-2 text-bgn-gold"></i> Database Menu Gizi</h3>
                <button class="btn btn-sm btn-outline-light ml-auto" data-toggle="modal" data-target="#modal-add-menu"><i class="fas fa-plus-circle mr-1"></i> Input Menu Baru</button>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap align-middle">
                    <thead>
                        <tr>
                            <th>Tanggal Sajian</th>
                            <th>Target Penerima</th>
                            <th>Nama Hidangan</th>
                            <th>Total Kalori</th>
                            <th>SPPG Penyedia</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($menus as $menu)
                        <tr>
                            <td class="font-weight-bold {{ $menu->serve_date == date('Y-m-d') ? 'text-success' : 'text-primary' }}">
                                {{ \Carbon\Carbon::parse($menu->serve_date)->format('d M Y') }}
                                @if($menu->serve_date == date('Y-m-d')) <span class="badge badge-success ml-1">Hari Ini</span> @endif
                            </td>
                            <td><span class="badge badge-secondary">{{ $menu->target_group }}</span></td>
                            <td class="font-weight-bold">{{ $menu->food_name }}</td>
                            <td>{{ $menu->calories }} Kkal</td>
                            <td>{{ $menu->sppg->name ?? 'N/A' }}</td>
                            <td>
                                <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin menghapus jadwal menu ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada jadwal menu yang diinputkan oleh mitra.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Menu -->
<div class="modal fade" id="modal-add-menu">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-bgn-primary text-white">
                <h4 class="modal-title">Input Rencana Menu Besok</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.menus.store') }}" method="POST">
                @csrf
                <div class="modal-body row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>SPPG Mitra Penyedia</label>
                            <select name="sppg_id" class="form-control" required>
                                @foreach($sppgs as $sppg)
                                    <option value="{{ $sppg->id }}">{{ $sppg->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Target Demografi Penerima (Sesuai Juklak MBG 2026)</label>
                            <select name="target_group" class="form-control" required>
                                <optgroup label="🟡 Porsi Kecil (~400-500 Kkal)">
                                    <option value="PAUD/TK">PAUD / Taman Kanak-Kanak</option>
                                    <option value="SD Kelas 1-3">SD Kelas 1–3</option>
                                    <option value="Balita">Balita (6–59 bulan)</option>
                                </optgroup>
                                <optgroup label="🟢 Porsi Besar (~600-700 Kkal)">
                                    <option value="SD Kelas 4-6">SD Kelas 4–6</option>
                                    <option value="SMP">SMP / Sederajat</option>
                                    <option value="SMA/SMK">SMA / SMK / Sederajat</option>
                                </optgroup>
                                <optgroup label="🕌 Pesantren (Sub-Jenjang Formal)">
                                    <option value="Pesantren - RA/TK">RA / Raudhatul Athfal (setara TK) — Porsi Kecil</option>
                                    <option value="Pesantren - MI Kelas 1-3">MI Kelas 1–3 / Madrasah Ibtidaiyah — Porsi Kecil</option>
                                    <option value="Pesantren - MI Kelas 4-6">MI Kelas 4–6 / Madrasah Ibtidaiyah — Porsi Besar</option>
                                    <option value="Pesantren - MTs">MTs / Madrasah Tsanawiyah (setara SMP) — Porsi Besar</option>
                                    <option value="Pesantren - MA/MAK">MA / MAK / Madrasah Aliyah (setara SMA) — Porsi Besar</option>
                                    <option value="Pesantren - Santri">Santri Boarding (Umum) — Porsi Besar</option>
                                </optgroup>
                                <optgroup label="🔵 Penerima Khusus">
                                    <option value="Ibu Hamil">Ibu Hamil</option>
                                    <option value="Ibu Menyusui">Ibu Menyusui</option>
                                    <option value="Guru/Pendidik">Guru / Tenaga Pendidik</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Disajikan</label>
                            <input type="date" name="serve_date" class="form-control" value="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Nama Hidangan Lengkap</label>
                            <input type="text" name="food_name" class="form-control" placeholder="Contoh: Nasi Tim + Opor Ayam + Sayur Bayam" required>
                        </div>
                    </div>
                    <div class="col-md-6 border-left">
                        <h5 class="text-bgn-primary font-weight-bold mb-3"><i class="fas fa-microscope mr-2"></i>Kandungan Gizi</h5>
                        <div class="form-group">
                            <label>Total Kalori (Kkal)</label>
                            <input type="number" name="calories" class="form-control" placeholder="Contoh: 600" required>
                        </div>
                        <div class="form-group">
                            <label>Protein (Gram)</label>
                            <input type="number" step="0.1" name="protein_g" class="form-control" placeholder="Contoh: 25.5" required>
                        </div>
                        <div class="form-group">
                            <label>Karbohidrat (Gram)</label>
                            <input type="number" step="0.1" name="karbo_g" class="form-control" placeholder="Contoh: 70.0" required>
                        </div>
                        <div class="form-group">
                            <label>Lemak (Gram)</label>
                            <input type="number" step="0.1" name="fat_g" class="form-control" placeholder="Contoh: 15.0" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn bg-bgn-primary text-white"><i class="fas fa-save mr-1"></i> Simpan Ke Database Nasional</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
