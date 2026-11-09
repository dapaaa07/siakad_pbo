<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="color-scheme" content="light dark">
  <script>
    (function () {
      try {
        var stored = localStorage.getItem('color-scheme');
        if (stored === 'dark' || stored === 'light') {
          document.querySelector('meta[name="color-scheme"]').content = stored;
        }
      } catch (e) {}
    })();
  </script>
  <title>@yield('title', 'Beranda') | SIAKAD</title>
  <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free/css/all.min.css') }}">
  @stack('styles')
  <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/siakad-theme.css') }}">
</head>
<body class="hold-transition sidebar-mini">
  <a href="#main-content" class="skip-link">Lewati ke konten utama</a>

  <div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light no-print" aria-label="Navigasi Atas">
      <ul class="navbar-nav">
        <li class="nav-item">
          <button type="button" class="nav-link btn btn-link d-flex align-items-center" data-widget="pushmenu" aria-label="Buka atau tutup menu samping">
            <i class="fas fa-bars" aria-hidden="true"></i>
            <span class="ml-2 d-inline d-md-none font-weight-bold">Menu</span>
          </button>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="{{ route('home') }}" class="nav-link">Home</a>
        </li>
        @if(auth()->check() && (int) auth()->user()->level === 1)
          <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('about') }}" class="nav-link">About</a>
          </li>
        @endif
      </ul>

      <ul class="navbar-nav ml-auto align-items-center">
        <li class="nav-item mr-2">
          <button type="button" id="theme-toggle-btn" class="btn btn-sm btn-outline-secondary" aria-pressed="false" aria-label="Ubah ke mode gelap">
            <i data-theme-icon class="fas fa-moon mr-1" aria-hidden="true"></i>
            <span data-theme-label>Mode Gelap</span>
          </button>
        </li>
        @if(auth()->check())
          <li class="nav-item d-none d-lg-inline-block mr-2">
            <span class="navbar-text small">
              {{ auth()->user()->name }} ({{ auth()->user()->levelLabel() }})
            </span>
          </li>
          <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
              @csrf
              <button type="submit" class="btn btn-sm btn-outline-danger">
                <i class="fas fa-sign-out-alt mr-1" aria-hidden="true"></i>Keluar
              </button>
            </form>
          </li>
        @endif
      </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4 no-print">
      <a href="{{ route('home') }}" class="brand-link">
        <img src="{{ asset('img/siakad-logo.svg') }}" alt="" class="brand-image img-circle" width="33" height="33">
        <span class="brand-text font-weight-semibold">SIAKAD</span>
      </a>

      <div class="sidebar">
        <div class="d-flex justify-content-end d-md-none pt-2">
          <button type="button" id="mobile-sidebar-close" class="btn btn-sm btn-outline-light" data-widget="pushmenu" aria-label="Tutup menu samping">
            <i class="fas fa-times mr-1" aria-hidden="true"></i>Tutup
          </button>
        </div>
        @if(auth()->check())
          <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <div class="image">
              <span class="siakad-sidebar-avatar" aria-hidden="true">{{ auth()->user()->initials() }}</span>
            </div>
            <div class="info">
              <a href="{{ auth()->user()->level <= 2 ? route('user') : route('home') }}" class="d-block">{{ auth()->user()->name }}</a>
              <span class="text-light small">Level: {{ auth()->user()->levelLabel() }}</span>
            </div>
          </div>
        @endif

        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <label for="sidebar-search-input" class="sr-only">Cari menu</label>
            <input id="sidebar-search-input" class="form-control form-control-sidebar" type="search" placeholder="Cari menu" aria-label="Cari menu">
            <div class="input-group-append">
              <button class="btn btn-sidebar" type="button" aria-label="Cari di sidebar">
                <i class="fas fa-search fa-fw" aria-hidden="true"></i>
              </button>
            </div>
          </div>
        </div>

        @include('layout.v_nav')
      </div>
    </aside>

    <main id="main-content" class="content-wrapper" tabindex="-1">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
              <h1>@yield('page', 'Halaman')</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">@yield('page', 'Halaman')</li>
              </ol>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">
          @if(session('login_success'))
            <div class="alert alert-success alert-dismissible fade show" role="status">
              <i class="fas fa-check-circle mr-1" aria-hidden="true"></i>
              {{ session('login_success') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Tutup notifikasi">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif

          @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="fas fa-exclamation-triangle mr-1" aria-hidden="true"></i>
              {{ session('error') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Tutup notifikasi">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif

          @yield('content')
        </div>
      </section>
    </main>

    <footer class="main-footer no-print">
      <div class="float-right d-none d-sm-inline">
        Pertemuan 12
      </div>
      <strong>SIAKAD Politeknik Negeri Subang.</strong> Sistem Informasi Akademik.
    </footer>
  </div>

  <dialog id="confirm-delete-dialog" class="siakad-dialog" aria-labelledby="delete-dialog-title" closedby="any">
    <div class="siakad-dialog-header">
      <h2 id="delete-dialog-title" class="h5 mb-0">Konfirmasi Hapus Data</h2>
      <form method="dialog">
        <button type="submit" value="cancel" class="btn btn-sm btn-link text-white p-1" aria-label="Tutup dialog">
          <i class="fas fa-times" aria-hidden="true"></i>
        </button>
      </form>
    </div>
    <div class="siakad-dialog-body">
      <p class="mb-0">Apakah Anda yakin ingin menghapus data <strong id="delete-target-name">ini</strong>? Tindakan ini tidak dapat dibatalkan.</p>
    </div>
    <div class="siakad-dialog-footer">
      <button type="button" id="delete-cancel-btn" class="btn btn-outline-secondary" autofocus>Batal</button>
      <form id="delete-target-form" method="POST" action="{{ route('home') }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
      </form>
    </div>
  </dialog>

  <script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>
  <script src="{{ asset('js/siakad-ui.js') }}"></script>
  @stack('scripts')
</body>
</html>
