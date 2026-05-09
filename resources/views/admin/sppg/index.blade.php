@extends('admin.layouts.app')

@section('title', 'Manajemen SPPG')
@section('header', 'Daftar Satuan Pelayanan (SPPG)')

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
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-ban"></i> Error Input!</h5>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-header bg-bgn-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="card-title"><i class="fas fa-building mr-2 text-bgn-gold"></i> Database Dapur Umum</h3>
                <button class="btn btn-sm btn-outline-light ml-auto" data-toggle="modal" data-target="#modal-add-sppg"><i class="fas fa-plus-circle mr-1"></i> Daftarkan SPPG Baru</button>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap align-middle">
                    <thead>
                        <tr>
                            <th>ID Registrasi</th>
                            <th>Nama Satuan Pelayanan</th>
                            <th>Lokasi Wilayah</th>
                            <th>Tanggal Pendirian</th>
                            <th>Status Operasional</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sppgs as $sppg)
                        <tr>
                            <td>#SPPG-{{ str_pad($sppg->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td class="font-weight-bold text-bgn-primary">{{ $sppg->name }}</td>
                            <td><i class="fas fa-map-marker-alt text-danger mr-1"></i> {{ $sppg->location }}</td>
                            <td>{{ $sppg->created_at->format('d/m/Y') }}</td>
                            <td><span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i> Aktif</span></td>
                            <td>
                                <button class="btn btn-xs btn-warning text-dark" title="Edit" data-toggle="modal" data-target="#modal-edit-sppg-{{ $sppg->id }}"><i class="fas fa-edit"></i></button>
                                <form action="{{ route('admin.sppg.destroy', $sppg->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Menghapus SPPG ini mungkin akan memutus data riwayat keuangan dan nutrisi yang terkait. Yakin hapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit SPPG -->
                        <div class="modal fade" id="modal-edit-sppg-{{ $sppg->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-bgn-primary text-white">
                                        <h4 class="modal-title">Edit Satuan Pelayanan</h4>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('admin.sppg.update', $sppg->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Nama SPPG</label>
                                                <input type="text" name="name" class="form-control" value="{{ $sppg->name }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Lokasi Wilayah</label>
                                                <input type="text" name="location" class="form-control" value="{{ $sppg->location }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn bg-bgn-primary text-white">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.Modal Edit -->

                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data Satuan Pelayanan yang didaftarkan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>

<!-- Modal Tambah SPPG -->
<div class="modal fade" id="modal-add-sppg">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-bgn-primary text-white">
                <h4 class="modal-title">Pendaftaran SPPG Baru</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.sppg.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama SPPG</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Dapur Umum SPPG Jakarta Pusat" required>
                    </div>
                    <div class="form-group">
                        <label>Lokasi Wilayah</label>
                        <input type="text" name="location" class="form-control" placeholder="Contoh: DKI Jakarta" required>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn bg-bgn-primary text-white">Daftarkan SPPG</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.Modal Tambah -->

@endsection
