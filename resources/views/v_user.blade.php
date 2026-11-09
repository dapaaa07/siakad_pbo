@extends('layout.v_template')

@section('title', 'User')
@section('page', 'Profil & Data Pengguna')

@section('content')
  <div class="card card-outline card-primary mb-3">
    <div class="card-header">
      <h2 class="card-title h5 mb-0 font-weight-bold">Akun yang Sedang Masuk</h2>
    </div>
    <div class="card-body">
      <dl class="row mb-0">
        <dt class="col-sm-3">Nama Lengkap</dt>
        <dd class="col-sm-9">{{ $currentUser->name }}</dd>

        <dt class="col-sm-3">Email</dt>
        <dd class="col-sm-9">{{ $currentUser->email }}</dd>

        <dt class="col-sm-3">Level Akses</dt>
        <dd class="col-sm-9">
          <span class="badge badge-info">Level {{ $currentUser->level }} ({{ $currentUser->levelLabel() }})</span>
        </dd>
      </dl>
    </div>
  </div>

  @if((int) $currentUser->level === 1)
    <div class="card">
      <div class="card-header">
        <h2 id="users-table-caption" class="card-title h5 mb-0 font-weight-bold">Daftar Pengguna Terdaftar</h2>
      </div>
      <div class="card-body">
        @if($users->isEmpty())
          <div class="text-center py-4">
            <i class="fas fa-users fa-2x text-muted mb-2" aria-hidden="true"></i>
            <h3 class="h6 font-weight-bold">Belum ada data pengguna lain</h3>
            <p class="text-muted mb-0">Tambahkan akun baru melalui halaman registrasi untuk melihat daftar pengguna di sini.</p>
          </div>
        @else
          <div class="siakad-responsive-table-wrap" role="region" tabindex="0" aria-labelledby="users-table-caption">
            <table class="table table-bordered table-striped siakad-responsive-table mb-0">
              <caption class="sr-only">Daftar seluruh akun pengguna pada tabel users</caption>
              <thead>
                <tr>
                  <th scope="col" style="width: 60px;">No</th>
                  <th scope="col">Nama</th>
                  <th scope="col">Email</th>
                  <th scope="col">Level</th>
                  <th scope="col">Tanggal Daftar</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $levelNames = [
                    1 => 'Admin',
                    2 => 'User',
                    3 => 'Mahasiswa',
                    4 => 'Dosen',
                  ];
                @endphp
                @foreach($users as $index => $row)
                  <tr>
                    <th scope="row" data-label="No" class="tabular-nums">{{ $index + 1 }}</th>
                    <td data-label="Nama">{{ $row->name }}</td>
                    <td data-label="Email">{{ $row->email }}</td>
                    <td data-label="Level">
                      <span class="badge badge-info">{{ $row->level }} ({{ $levelNames[(int) $row->level] ?? 'Lainnya' }})</span>
                    </td>
                    <td data-label="Tanggal Daftar" class="tabular-nums">
                      {{ $row->created_at ? \Carbon\Carbon::parse($row->created_at)->format('d M Y') : '-' }}
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
      </div>
    </div>
  @else
    <div class="alert alert-info mb-0" role="status">
      <i class="fas fa-info-circle mr-1" aria-hidden="true"></i>
      Anda masuk sebagai {{ $currentUser->levelLabel() }} (Level {{ $currentUser->level }}). Daftar lengkap seluruh pengguna hanya dapat diakses oleh Administrator (Level 1).
    </div>
  @endif
@endsection
