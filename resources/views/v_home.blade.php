@extends('layout.v_template')

@section('title', 'Home')
@section('page', 'Beranda SIAKAD')

@section('content')
  @php
    $user = auth()->user();
    $level = $user ? (int) $user->level : 0;

    $primaryAction = match ($level) {
      1 => ['route' => route('dosen'), 'label' => 'Buka Kelola Data Dosen'],
      2 => ['route' => route('user'), 'label' => 'Lihat Profil Pengguna'],
      3 => ['route' => route('mahasiswa'), 'label' => 'Buka Data Mahasiswa'],
      4 => ['route' => route('dosen'), 'label' => 'Buka Kelola Data Dosen'],
      default => ['route' => route('home'), 'label' => 'Beranda'],
    };
  @endphp

  <div class="row">
    <div class="col-lg-7 mb-3">
      <div class="card card-outline card-primary h-100 mb-0">
        <div class="card-body d-flex flex-column justify-content-between">
          <div>
            <p class="text-muted small mb-1">Politeknik Negeri Subang</p>
            <h2 class="h4 font-weight-bold mb-2">Selamat datang, {{ $user?->name ?? 'Pengguna' }}</h2>
            <p class="mb-3">
              Anda masuk menggunakan peran <strong>{{ $user?->levelLabel() ?? 'Tamu' }} (Level {{ $level }})</strong>.
              Menu di bilah samping disaring otomatis sesuai hak akses akun Anda.
            </p>
          </div>
          <div>
            <a href="{{ $primaryAction['route'] }}" class="btn btn-primary">
              <i class="fas fa-folder-open mr-1" aria-hidden="true"></i>{{ $primaryAction['label'] }}
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-5 mb-3">
      <div class="card h-100 mb-0">
        <div class="card-header">
          <h2 class="card-title h6 mb-0 font-weight-bold">Ringkasan Basis Data SIAKAD</h2>
        </div>
        <div class="card-body p-0">
          <table class="table table-sm mb-0">
            <caption class="sr-only">Jumlah baris aktual pada basis data SIAKAD</caption>
            <tbody>
              <tr>
                <th scope="row" class="pl-3">Data Dosen (<code>tb_dosen</code>)</th>
                <td class="text-right pr-3 font-weight-bold tabular-nums">{{ $totalDosen }}</td>
              </tr>
              <tr>
                <th scope="row" class="pl-3">Data Mahasiswa (<code>tb_mahasiswa</code>)</th>
                <td class="text-right pr-3 font-weight-bold tabular-nums">{{ $totalMahasiswa }}</td>
              </tr>
              <tr>
                <th scope="row" class="pl-3">Pengguna Terdaftar (<code>users</code>)</th>
                <td class="text-right pr-3 font-weight-bold tabular-nums">{{ $totalUsers }}</td>
              </tr>
              <tr>
                <th scope="row" class="pl-3">Simulasi Tagihan UKT (<code>tb_invoice</code>)</th>
                <td class="text-right pr-3 font-weight-bold tabular-nums">{{ $totalInvoice }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="card-footer small text-muted">
          Dihitung langsung dari tabel database saat halaman dimuat.
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <h2 class="card-title h6 mb-0 font-weight-bold">Modul yang Tersedia untuk Akun Anda</h2>
    </div>
    <div class="card-body">
      <ul class="list-group list-group-flush">
        @if($level === 1 || $level === 4)
          <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
            <div class="pr-2">
              <strong>Kelola Data Dosen</strong>
              <p class="mb-0 small text-muted">Tambah data dengan ID otomatis <code>PEGxxxx</code>, ubah, detail, hapus, ekspor DataTables, dan cetak laporan PDF.</p>
            </div>
            <a href="{{ route('dosen') }}" class="btn btn-sm btn-outline-primary mt-2 mt-sm-0">Kelola Dosen</a>
          </li>
        @endif

        @if($level === 1 || $level === 3)
          <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
            <div class="pr-2">
              <strong>Data Mahasiswa</strong>
              <p class="mb-0 small text-muted">CRUD 11 atribut lengkap mahasiswa, detail biodata, foto profil, dan cetak laporan PDF.</p>
            </div>
            <a href="{{ route('mahasiswa') }}" class="btn btn-sm btn-outline-primary mt-2 mt-sm-0">Kelola Mahasiswa</a>
          </li>
        @endif

        @if($level === 1 || $level === 2)
          <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
            <div class="pr-2">
              <strong>Data Pengguna</strong>
              <p class="mb-0 small text-muted">Informasi profil akun aktif{{ $level === 1 ? ' dan daftar seluruh akun pengguna sistem' : '' }}.</p>
            </div>
            <a href="{{ route('user') }}" class="btn btn-sm btn-outline-primary mt-2 mt-sm-0">Lihat User</a>
          </li>
        @endif

        @if($level === 1)
          <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
            <div class="pr-2">
              <strong>Grafik Akademik &amp; Pengguna</strong>
              <p class="mb-0 small text-muted">Visualisasi pertumbuhan pengguna per tahun, level akses, dan sebaran prodi mahasiswa.</p>
            </div>
            <a href="{{ route('chart') }}" class="btn btn-sm btn-outline-primary mt-2 mt-sm-0">Buka Chart</a>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
            <div class="pr-2">
              <strong>Invoice Tagihan UKT (Simulasi)</strong>
              <p class="mb-0 small text-muted">Pratinjau dokumen tagihan berbasis data mahasiswa dan cetak halaman via browser.</p>
            </div>
            <a href="{{ route('invoice') }}" class="btn btn-sm btn-outline-primary mt-2 mt-sm-0">Buka Invoice</a>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap px-0">
            <div class="pr-2">
              <strong>Tentang Kampus &amp; Sistem</strong>
              <p class="mb-0 small text-muted">Alamat Politeknik Negeri Subang dan cakupan fitur Pertemuan 12.</p>
            </div>
            <a href="{{ route('about') }}" class="btn btn-sm btn-outline-primary mt-2 mt-sm-0">Buka About</a>
          </li>
        @endif
      </ul>
    </div>
  </div>
@endsection
