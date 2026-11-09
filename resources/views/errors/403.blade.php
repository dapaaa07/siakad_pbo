@extends('layout.v_template')

@section('title', 'Akses Ditolak')
@section('page', 'Akses Ditolak (403)')

@section('content')
  <div class="card card-outline card-danger">
    <div class="card-body">
      <div class="d-flex align-items-start">
        <i class="fas fa-ban fa-2x text-danger mr-3 mt-1" aria-hidden="true"></i>
        <div>
          <h2 class="h4">Anda tidak memiliki izin mengakses halaman ini</h2>
          <p class="mb-3">
            Halaman ini hanya tersedia untuk peran <strong>{{ $requiredRole ?? 'tertentu' }}</strong>.
            Akun Anda saat ini masuk sebagai <strong>{{ auth()->user()?->levelLabel() ?? 'Tamu' }}</strong>.
          </p>
          <a href="{{ route('home') }}" class="btn btn-primary">
            <i class="fas fa-home mr-1" aria-hidden="true"></i>Kembali ke Beranda
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection
