@extends('layouts.app')

@section('title', 'Login Sistem MBG')
@section('header', 'Otorisasi Keamanan BGN')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card border-0 shadow-sm rounded-1 h-100">
            <div class="card-header bg-bgn-primary text-white text-center py-4">
                <i class="fas fa-shield-alt fa-3x text-bgn-gold mb-3"></i>
                <h3 class="card-title mb-0 fs-4 fw-bold">Portal Autentikasi</h3>
                <p class="text-white-50 mb-0 small mt-1">Sistem Monitoring Nasional MBG</p>
            </div>
            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger rounded-1 border-0">
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold small text-uppercase text-muted">Email Institusi</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-envelope text-muted"></i></span>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@bgn.go.id">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label fw-bold small text-uppercase text-muted">Kata Sandi</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-lock text-muted"></i></span>
                            <input type="password" class="form-control" id="password" name="password" required placeholder="••••••••">
                        </div>
                    </div>
                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label small text-muted" for="remember">Ingat Saya</label>
                    </div>
                    <button type="submit" class="btn bg-bgn-primary text-white w-100 py-3 fw-bold rounded-1">
                        MASUK SISTEM <i class="fas fa-sign-in-alt ms-2"></i>
                    </button>
                </form>
            </div>
            <div class="card-footer bg-light text-center py-3">
                <small class="text-muted"><i class="fas fa-info-circle me-1"></i> Hubungi Pusat Bantuan BGN jika mengalami kendala login.</small>
            </div>
        </div>
    </div>
</div>
@endsection
