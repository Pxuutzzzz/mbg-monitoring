@extends('admin.layouts.app')

@section('title', 'Manajemen Pengguna')
@section('header', 'Daftar Pengguna Sistem')

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
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-ban"></i> Gagal!</h5>
                {{ session('error') }}
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
                <h3 class="card-title"><i class="fas fa-users mr-2"></i> Database Akun</h3>
                <button class="btn btn-sm btn-outline-light ml-auto" data-toggle="modal" data-target="#modal-add-user"><i class="fas fa-user-plus mr-1"></i> Tambah Pengguna</button>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Hak Akses (Role)</th>
                            <th>Tanggal Terdaftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td class="font-weight-bold">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="badge badge-primary"><i class="fas fa-shield-alt mr-1"></i> Administrator</span>
                                @elseif($user->role === 'driver')
                                    <span class="badge badge-success"><i class="fas fa-truck mr-1"></i> Kurir (Driver)</span>
                                @else
                                    <span class="badge badge-secondary">Publik</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <button class="btn btn-xs btn-info" title="Edit" data-toggle="modal" data-target="#modal-edit-user-{{ $user->id }}"><i class="fas fa-edit"></i></button>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit User -->
                        <div class="modal fade" id="modal-edit-user-{{ $user->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-bgn-primary text-white">
                                        <h4 class="modal-title">Edit Pengguna</h4>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Nama Lengkap</label>
                                                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Peran (Role)</label>
                                                <select name="role" class="form-control" required>
                                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrator</option>
                                                    <option value="driver" {{ $user->role === 'driver' ? 'selected' : '' }}>Kurir (Driver)</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Kata Sandi Baru</label>
                                                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
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
                            <td colspan="6" class="text-center text-muted">Belum ada data pengguna.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <span class="text-muted small">Menampilkan total {{ $users->count() }} pengguna terdaftar.</span>
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="modal-add-user">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-bgn-primary text-white">
                <h4 class="modal-title">Tambah Pengguna Baru</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Peran (Role)</label>
                        <select name="role" class="form-control" required>
                            <option value="driver">Kurir (Driver)</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kata Sandi</label>
                        <input type="password" name="password" class="form-control" required minlength="8">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn bg-bgn-primary text-white">Tambah Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.Modal Tambah -->

@endsection
