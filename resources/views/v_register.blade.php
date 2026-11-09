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
  <title>Registrasi Akun | SIAKAD</title>
  <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/siakad-theme.css') }}">
</head>
<body class="hold-transition register-page">
  <header class="w-100 d-flex justify-content-end px-3 pt-3">
    <button type="button" id="theme-toggle-btn" class="btn btn-sm btn-outline-secondary" aria-pressed="false" aria-label="Ubah ke mode gelap">
      <i data-theme-icon class="fas fa-moon mr-1" aria-hidden="true"></i>
      <span data-theme-label>Mode Gelap</span>
    </button>
  </header>

  <main class="siakad-auth-box">
    <div class="text-center mb-3">
      <img src="{{ asset('img/siakad-logo.svg') }}" alt="Logo SIAKAD" width="56" height="56" class="mb-2">
      <h1 class="h3 font-weight-bold mb-1">Registrasi Akun SIAKAD</h1>
      <p class="text-muted mb-0">Lengkapi data akun dan pilih level peran akses Anda.</p>
    </div>

    <div class="card card-outline card-primary">
      <div class="card-body register-card-body">
        @if($errors->any())
          <div class="alert alert-danger" role="alert">
            <i class="fas fa-exclamation-triangle mr-1" aria-hidden="true"></i>
            Periksa kembali data yang Anda masukkan pada formulir di bawah ini.
          </div>
        @endif

        <form action="{{ route('register.proses') }}" method="POST" data-loading-submit novalidate>
          @csrf

          <div class="form-group">
            <label for="reg-name">Nama Lengkap</label>
            <input
              id="reg-name"
              type="text"
              name="name"
              value="{{ old('name') }}"
              class="form-control @error('name') is-invalid @enderror"
              placeholder="Masukkan nama lengkap"
              autocomplete="name"
              maxlength="255"
              required
              @error('name') aria-invalid="true" aria-describedby="reg-name-error" @enderror
            >
            @error('name')
              <div id="reg-name-error" class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="reg-email">Email</label>
            <input
              id="reg-email"
              type="email"
              name="email"
              value="{{ old('email') }}"
              class="form-control @error('email') is-invalid @enderror"
              placeholder="nama@siakad.test"
              autocomplete="email"
              autocorrect="off"
              autocapitalize="off"
              spellcheck="false"
              maxlength="255"
              required
              @error('email') aria-invalid="true" aria-describedby="reg-email-error" @enderror
            >
            @error('email')
              <div id="reg-email-error" class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="reg-password">Password</label>
            <div id="reg-password-hint" class="small text-muted mb-1">Minimal 6 karakter.</div>
            <div class="input-group">
              <input
                id="reg-password"
                type="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="Buat password"
                autocomplete="new-password"
                minlength="6"
                required
                aria-describedby="reg-password-hint @error('password') reg-password-error @enderror"
                @error('password') aria-invalid="true" @enderror
              >
              <div class="input-group-append">
                <button
                  type="button"
                  class="btn btn-outline-secondary"
                  data-toggle-password="reg-password"
                  aria-pressed="false"
                  aria-label="Tampilkan password"
                >
                  <i class="fas fa-eye" aria-hidden="true"></i>
                </button>
              </div>
              @error('password')
                <div id="reg-password-error" class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="form-group">
            <label for="reg-password-confirm">Konfirmasi Password</label>
            <div class="input-group">
              <input
                id="reg-password-confirm"
                type="password"
                name="password_confirmation"
                class="form-control"
                placeholder="Ulangi password"
                autocomplete="new-password"
                minlength="6"
                required
              >
              <div class="input-group-append">
                <button
                  type="button"
                  class="btn btn-outline-secondary"
                  data-toggle-password="reg-password-confirm"
                  aria-pressed="false"
                  aria-label="Tampilkan konfirmasi password"
                >
                  <i class="fas fa-eye" aria-hidden="true"></i>
                </button>
              </div>
            </div>
          </div>

          <fieldset class="form-group mb-3">
            <legend class="col-form-label font-weight-bold pt-0">Level Akses Akun</legend>
            @php
              $selectedLevel = (string) old('level', '2');
              $levels = [
                '1' => 'Level 1: Admin (Akses seluruh modul)',
                '2' => 'Level 2: User / Staf Akademik',
                '3' => 'Level 3: Mahasiswa (Data Mahasiswa)',
                '4' => 'Level 4: Dosen (Kelola Data Dosen)',
              ];
            @endphp
            @foreach($levels as $value => $label)
              <div class="form-check mb-1">
                <input
                  class="form-check-input @error('level') is-invalid @enderror"
                  type="radio"
                  name="level"
                  id="reg-level-{{ $value }}"
                  value="{{ $value }}"
                  {{ $selectedLevel === $value ? 'checked' : '' }}
                  required
                >
                <label class="form-check-label" for="reg-level-{{ $value }}">
                  {{ $label }}
                </label>
              </div>
            @endforeach
            @error('level')
              <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
          </fieldset>

          <button type="submit" class="btn btn-primary btn-block" data-loading-text="Mendaftarkan akun...">
            Daftar Akun
          </button>
        </form>

        <hr>

        <div class="text-center">
          <a href="{{ route('login') }}">Sudah mempunyai akun? Masuk di sini</a>
        </div>
      </div>
    </div>
  </main>

  <script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>
  <script src="{{ asset('js/siakad-ui.js') }}"></script>
</body>
</html>
