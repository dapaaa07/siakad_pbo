@extends('layout.v_template')

@section('title', 'Tambah Dosen')
@section('page', 'Tambah Data Dosen')

@section('content')
  <div class="card card-outline card-primary">
    <div class="card-header">
      <h2 class="card-title h5 mb-0 font-weight-bold">Formulir Tambah Data Dosen</h2>
    </div>

    <form action="{{ route('dosen.insert') }}" method="POST" enctype="multipart/form-data" data-loading-submit novalidate>
      @csrf
      <div class="card-body">
        @if($errors->any())
          <div class="alert alert-danger" role="alert">
            <i class="fas fa-exclamation-triangle mr-1" aria-hidden="true"></i>
            Periksa kembali kolom yang ditandai sebelum menyimpan data.
          </div>
        @endif

        <div class="row">
          <div class="col-md-8">
            <div class="form-group">
              <label for="dosen-id">ID Dosen (Otomatis)</label>
              <div id="dosen-id-hint" class="small text-muted mb-1">Dibuat otomatis berurutan dengan format PEGxxxx.</div>
              <input
                id="dosen-id"
                type="text"
                name="id_dosen"
                value="{{ $nextId }}"
                class="form-control tabular-nums"
                readonly
                aria-describedby="dosen-id-hint"
              >
            </div>

            <div class="form-group">
              <label for="dosen-nip">NIP</label>
              <div id="dosen-nip-hint" class="small text-muted mb-1">Masukkan 17 sampai 18 digit angka NIP tanpa spasi.</div>
              <input
                id="dosen-nip"
                type="text"
                name="nip"
                value="{{ old('nip') }}"
                class="form-control tabular-nums @error('nip') is-invalid @enderror"
                placeholder="Contoh: 199001262019031026"
                inputmode="numeric"
                minlength="17"
                maxlength="18"
                autocorrect="off"
                autocapitalize="off"
                spellcheck="false"
                required
                aria-describedby="dosen-nip-hint @error('nip') dosen-nip-error @enderror"
                @error('nip') aria-invalid="true" @enderror
              >
              @error('nip')
                <div id="dosen-nip-error" class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="dosen-nama">Nama Dosen</label>
              <input
                id="dosen-nama"
                type="text"
                name="nama_dosen"
                value="{{ old('nama_dosen') }}"
                class="form-control @error('nama_dosen') is-invalid @enderror"
                placeholder="Masukkan nama lengkap dan gelar"
                maxlength="200"
                required
                @error('nama_dosen') aria-invalid="true" aria-describedby="dosen-nama-error" @enderror
              >
              @error('nama_dosen')
                <div id="dosen-nama-error" class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="dosen-mk">Mata Kuliah</label>
              <input
                id="dosen-mk"
                type="text"
                name="mata_kuliah"
                value="{{ old('mata_kuliah') }}"
                class="form-control @error('mata_kuliah') is-invalid @enderror"
                placeholder="Masukkan mata kuliah yang diampu"
                maxlength="200"
                required
                @error('mata_kuliah') aria-invalid="true" aria-describedby="dosen-mk-error" @enderror
              >
              @error('mata_kuliah')
                <div id="dosen-mk-error" class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group mb-0">
              <label for="dosen-foto">Foto Dosen</label>
              <div id="dosen-foto-hint" class="small text-muted mb-1">Format jpg, jpeg, png, bmp, atau webp. Ukuran maksimal 1 MB.</div>
              <div class="custom-file">
                <input
                  id="dosen-foto"
                  type="file"
                  name="foto_dosen"
                  class="custom-file-input @error('foto_dosen') is-invalid @enderror"
                  accept=".jpg,.jpeg,.png,.bmp,.webp,image/*"
                  data-preview-target="dosen-photo-preview"
                  required
                  aria-describedby="dosen-foto-hint @error('foto_dosen') dosen-foto-error @enderror"
                  @error('foto_dosen') aria-invalid="true" @enderror
                >
                <label class="custom-file-label" for="dosen-foto">Pilih berkas foto...</label>
                @error('foto_dosen')
                  <div id="dosen-foto-error" class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="col-md-4 mt-3 mt-md-0 text-center">
            <p class="font-weight-semibold mb-2">Pratinjau Foto</p>
            <img
              id="dosen-photo-preview"
              src="{{ asset('img/siakad-logo.svg') }}"
              alt="Pratinjau foto dosen yang akan diunggah"
              class="siakad-avatar-detail"
              width="160"
              height="160"
              hidden
            >
          </div>
        </div>
      </div>

      <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
        <a href="{{ route('dosen') }}" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary" data-loading-text="Menyimpan data...">
          <i class="fas fa-save mr-1" aria-hidden="true"></i>Simpan Data Dosen
        </button>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
@endpush
