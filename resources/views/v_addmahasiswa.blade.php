@extends('layout.v_template')

@section('title', 'Tambah Mahasiswa')
@section('page', 'Tambah Data Mahasiswa')

@section('content')
  <div class="card card-outline card-primary">
    <div class="card-header">
      <h2 class="card-title h5 mb-0 font-weight-bold">Formulir Tambah Data Mahasiswa</h2>
    </div>

    <form action="{{ route('mahasiswa.insert') }}" method="POST" enctype="multipart/form-data" data-loading-submit novalidate>
      @csrf
      <div class="card-body">
        @if($errors->any())
          <div class="alert alert-danger" role="alert">
            <i class="fas fa-exclamation-triangle mr-1" aria-hidden="true"></i>
            Periksa kembali kolom yang ditandai sebelum menyimpan data mahasiswa.
          </div>
        @endif

        <div class="row">
          <div class="col-lg-8">
            <div class="form-group">
              <label for="mhs-nim">NIM</label>
              <div id="mhs-nim-hint" class="small text-muted mb-1">
                Masukkan NIM tanpa spasi. Saran NIM berikutnya: <code class="tabular-nums">{{ $suggestedNim }}</code>
              </div>
              <div class="input-group">
                <input
                  id="mhs-nim"
                  type="text"
                  name="nim"
                  value="{{ old('nim') }}"
                  class="form-control tabular-nums @error('nim') is-invalid @enderror"
                  placeholder="Contoh: {{ $suggestedNim }}"
                  inputmode="numeric"
                  maxlength="20"
                  autocorrect="off"
                  autocapitalize="off"
                  spellcheck="false"
                  required
                  aria-describedby="mhs-nim-hint @error('nim') mhs-nim-error @enderror"
                  @error('nim') aria-invalid="true" @enderror
                >
                <div class="input-group-append">
                  <button
                    type="button"
                    id="use-suggested-nim-btn"
                    class="btn btn-outline-primary"
                    data-suggested-nim="{{ $suggestedNim }}"
                  >
                    Pakai Saran
                  </button>
                </div>
                @error('nim')
                  <div id="mhs-nim-error" class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="form-group">
              <label for="mhs-nama">Nama Mahasiswa</label>
              <input
                id="mhs-nama"
                type="text"
                name="nama"
                value="{{ old('nama') }}"
                class="form-control @error('nama') is-invalid @enderror"
                placeholder="Masukkan nama lengkap mahasiswa"
                autocomplete="name"
                maxlength="100"
                required
                @error('nama') aria-invalid="true" aria-describedby="mhs-nama-error" @enderror
              >
              @error('nama')
                <div id="mhs-nama-error" class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="mhs-jurusan">Jurusan</label>
                  <input
                    id="mhs-jurusan"
                    type="text"
                    name="jurusan"
                    value="{{ old('jurusan') }}"
                    class="form-control @error('jurusan') is-invalid @enderror"
                    placeholder="Contoh: Teknologi Informasi dan Komputer"
                    maxlength="100"
                    required
                    @error('jurusan') aria-invalid="true" aria-describedby="mhs-jurusan-error" @enderror
                  >
                  @error('jurusan')
                    <div id="mhs-jurusan-error" class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="mhs-prodi">Program Studi</label>
                  <input
                    id="mhs-prodi"
                    type="text"
                    name="prodi"
                    value="{{ old('prodi') }}"
                    class="form-control @error('prodi') is-invalid @enderror"
                    placeholder="Contoh: D4 Teknologi Rekayasa Perangkat Lunak"
                    maxlength="100"
                    required
                    @error('prodi') aria-invalid="true" aria-describedby="mhs-prodi-error" @enderror
                  >
                  @error('prodi')
                    <div id="mhs-prodi-error" class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="mhs-ttl">Tempat, Tanggal Lahir</label>
                  <input
                    id="mhs-ttl"
                    type="text"
                    name="ttl"
                    value="{{ old('ttl') }}"
                    class="form-control @error('ttl') is-invalid @enderror"
                    placeholder="Contoh: Subang, 12 Juni 2005"
                    maxlength="100"
                    required
                    @error('ttl') aria-invalid="true" aria-describedby="mhs-ttl-error" @enderror
                  >
                  @error('ttl')
                    <div id="mhs-ttl-error" class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="mhs-agama">Agama</label>
                  @php
                    $agamaOptions = ['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
                  @endphp
                  <select
                    id="mhs-agama"
                    name="agama"
                    class="custom-select @error('agama') is-invalid @enderror"
                    required
                    @error('agama') aria-invalid="true" aria-describedby="mhs-agama-error" @enderror
                  >
                    <option value="">-- Pilih Agama --</option>
                    @foreach($agamaOptions as $opt)
                      <option value="{{ $opt }}" {{ old('agama') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                    @endforeach
                  </select>
                  @error('agama')
                    <div id="mhs-agama-error" class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="mhs-alamat">Alamat</label>
              <textarea
                id="mhs-alamat"
                name="alamat"
                rows="3"
                class="form-control @error('alamat') is-invalid @enderror"
                placeholder="Masukkan alamat tempat tinggal"
                autocomplete="street-address"
                required
                @error('alamat') aria-invalid="true" aria-describedby="mhs-alamat-error" @enderror
              >{{ old('alamat') }}</textarea>
              @error('alamat')
                <div id="mhs-alamat-error" class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="mhs-tingkat">Tingkat</label>
                  <input
                    id="mhs-tingkat"
                    type="text"
                    name="tingkat"
                    value="{{ old('tingkat', '1') }}"
                    class="form-control tabular-nums @error('tingkat') is-invalid @enderror"
                    inputmode="numeric"
                    placeholder="1 sampai 6"
                    required
                    @error('tingkat') aria-invalid="true" aria-describedby="mhs-tingkat-error" @enderror
                  >
                  @error('tingkat')
                    <div id="mhs-tingkat-error" class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-sm-4">
                <div class="form-group">
                  <label for="mhs-semester">Semester</label>
                  <input
                    id="mhs-semester"
                    type="text"
                    name="semester"
                    value="{{ old('semester', '1') }}"
                    class="form-control tabular-nums @error('semester') is-invalid @enderror"
                    inputmode="numeric"
                    placeholder="1 sampai 14"
                    required
                    @error('semester') aria-invalid="true" aria-describedby="mhs-semester-error" @enderror
                  >
                  @error('semester')
                    <div id="mhs-semester-error" class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-sm-4">
                <div class="form-group">
                  <label for="mhs-hp">Nomor Handphone</label>
                  <input
                    id="mhs-hp"
                    type="text"
                    name="nomor_handphone"
                    value="{{ old('nomor_handphone') }}"
                    class="form-control tabular-nums @error('nomor_handphone') is-invalid @enderror"
                    inputmode="tel"
                    autocomplete="tel"
                    placeholder="0812xxxxxxxx"
                    maxlength="20"
                    required
                    @error('nomor_handphone') aria-invalid="true" aria-describedby="mhs-hp-error" @enderror
                  >
                  @error('nomor_handphone')
                    <div id="mhs-hp-error" class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="form-group mb-0">
              <label for="mhs-foto">Foto Mahasiswa</label>
              <div id="mhs-foto-hint" class="small text-muted mb-1">Format jpg, jpeg, png, bmp, atau webp. Ukuran maksimal 1 MB.</div>
              <div class="custom-file">
                <input
                  id="mhs-foto"
                  type="file"
                  name="foto_mahasiswa"
                  class="custom-file-input @error('foto_mahasiswa') is-invalid @enderror"
                  accept=".jpg,.jpeg,.png,.bmp,.webp,image/*"
                  data-preview-target="mhs-photo-preview"
                  required
                  aria-describedby="mhs-foto-hint @error('foto_mahasiswa') mhs-foto-error @enderror"
                  @error('foto_mahasiswa') aria-invalid="true" @enderror
                >
                <label class="custom-file-label" for="mhs-foto">Pilih berkas foto...</label>
                @error('foto_mahasiswa')
                  <div id="mhs-foto-error" class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="col-lg-4 mt-3 mt-lg-0 text-center">
            <p class="font-weight-semibold mb-2">Pratinjau Foto</p>
            <img
              id="mhs-photo-preview"
              src="{{ asset('img/siakad-logo.svg') }}"
              alt="Pratinjau foto mahasiswa"
              class="siakad-avatar-detail"
              width="160"
              height="160"
              hidden
            >
          </div>
        </div>
      </div>

      <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
        <a href="{{ route('mahasiswa') }}" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary" data-loading-text="Menyimpan data...">
          <i class="fas fa-save mr-1" aria-hidden="true"></i>Simpan Data Mahasiswa
        </button>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
  <script>
    (function () {
      var suggestBtn = document.getElementById('use-suggested-nim-btn');
      var nimInput = document.getElementById('mhs-nim');
      if (suggestBtn && nimInput) {
        suggestBtn.addEventListener('click', function () {
          nimInput.value = suggestBtn.getAttribute('data-suggested-nim') || '';
          nimInput.focus();
        });
      }
    })();
  </script>
@endpush
