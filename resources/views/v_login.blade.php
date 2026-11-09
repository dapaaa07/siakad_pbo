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
  <title>Masuk | SIAKAD</title>
  <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/siakad-theme.css') }}">
</head>
<body class="hold-transition login-page">
  <header class="w-100 d-flex justify-content-end px-3 pt-3">
    <button type="button" id="theme-toggle-btn" class="btn btn-sm btn-outline-secondary" aria-pressed="false" aria-label="Ubah ke mode gelap">
      <i data-theme-icon class="fas fa-moon mr-1" aria-hidden="true"></i>
      <span data-theme-label>Mode Gelap</span>
    </button>
  </header>

  <main class="siakad-auth-box">
    <div class="text-center mb-3">
      <img src="{{ asset('img/siakad-logo.svg') }}" alt="Logo SIAKAD" width="56" height="56" class="mb-2">
      <h1 class="h3 font-weight-bold mb-1">SIAKAD Politeknik Negeri Subang</h1>
      <p class="text-muted mb-0">Masuk dengan email dan password akun akademik Anda.</p>
    </div>

    <div class="card card-outline card-primary">
      <div class="card-body login-card-body">
        @if(session('success'))
          <div class="alert alert-success" role="status">
            <i class="fas fa-check-circle mr-1" aria-hidden="true"></i>
            {{ session('success') }}
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger" role="alert">
            <i class="fas fa-exclamation-triangle mr-1" aria-hidden="true"></i>
            {{ session('error') }}
          </div>
        @endif

        @if($errors->any())
          <div class="alert alert-danger" role="alert">
            <i class="fas fa-exclamation-triangle mr-1" aria-hidden="true"></i>
            {{ $errors->first() }}
          </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" data-loading-submit novalidate>
          @csrf

          <div class="form-group">
            <label for="login-email">Email</label>
            <input
              id="login-email"
              type="email"
              name="email"
              value="{{ old('email') }}"
              class="form-control @error('email') is-invalid @enderror"
              placeholder="nama@siakad.test"
              autocomplete="email"
              autocorrect="off"
              autocapitalize="off"
              spellcheck="false"
              required
              @error('email') aria-invalid="true" aria-describedby="login-email-error" @enderror
            >
            @error('email')
              <div id="login-email-error" class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="login-password">Password</label>
            <div class="input-group">
              <input
                id="login-password"
                type="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="Masukkan password"
                autocomplete="current-password"
                required
                @error('password') aria-invalid="true" aria-describedby="login-password-error" @enderror
              >
              <div class="input-group-append">
                <button
                  type="button"
                  class="btn btn-outline-secondary"
                  data-toggle-password="login-password"
                  aria-pressed="false"
                  aria-label="Tampilkan password"
                  aria-describedby="login-pwd-warn"
                >
                  <i class="fas fa-eye" aria-hidden="true"></i>
                </button>
              </div>
              @error('password')
                <div id="login-password-error" class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <span id="login-pwd-warn" class="sr-only">Peringatan: tindakan ini menampilkan karakter password pada layar.</span>
          </div>

          <button type="submit" class="btn btn-primary btn-block mt-3" data-loading-text="Memeriksa akun...">
            Masuk ke SIAKAD
          </button>
        </form>

        <hr>

        <div class="d-flex justify-content-between align-items-center flex-wrap">
          <span class="small text-muted">Belum memiliki akun?</span>
          <a href="{{ route('register') }}" class="font-weight-semibold">Daftar akun baru</a>
        </div>

        <details class="mt-3">
          <summary class="small font-weight-semibold" style="cursor: pointer;">Daftar Akun Bawaan (Seeder)</summary>
          <div class="mt-2 small">
            <p class="mb-1">Password semua akun seeder: <code>password</code></p>
            <ul class="pl-3 mb-0">
              <li>Level 1 (Admin): <code>admin@siakad.test</code></li>
              <li>Level 2 (User): <code>user@siakad.test</code></li>
              <li>Level 3 (Mahasiswa): <code>mahasiswa@siakad.test</code></li>
              <li>Level 4 (Dosen): <code>dosen@siakad.test</code></li>
            </ul>
          </div>
        </details>
      </div>
    </div>
  </main>

  <script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>
  <script src="{{ asset('js/siakad-ui.js') }}"></script>
</body>
</html>
