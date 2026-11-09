@extends('layout.v_template')

@section('title', 'Edit Dosen')
@section('page', 'Ubah Data Dosen')

@section('content')
  <div class="card card-outline card-warning">
    <div class="card-header">
      <h2 class="card-title h5 mb-0 font-weight-bold">Formulir Ubah Data Dosen ({{ $dosen->id_dosen }})</h2>
    </div>

    <form action="{{ route('dosen.update', $dosen->id_dosen) }}" method="POST" enctype="multipart/form-data" data-loading-submit novalidate>
      @csrf
      <div class="card-body">
        @if($errors->any())
          <div class="alert alert-danger" role="alert">
            <i class="fas fa-exclamation-triangle mr-1" aria-hidden="true"></i>
            Periksa kembali kolom yang ditandai sebelum menyimpan perubahan.
          </div>
        @endif

        <div class="row">
          <div class="col-md-8">
            <div class="form-group">
              <label for="edit-dosen-id">ID Dosen</label>
              <input
                id="edit-dosen-id"
                type="text"
                name="id_dosen"
                value="{{ $dosen->id_dosen }}"
                class="form-control tabular-nums"
                readonly
              >
            </div>

            <div class="form-group">
              <label for="edit-dosen-nip">NIP</label>
              <div id="edit-dosen-nip-hint" class="small text-muted mb-1">Masukkan 17 sampai 18 digit angka NIP tanpa spasi.</div>
              <input
                id="edit-dosen-nip"
                type="text"
                name="nip"
                value="{{ old('nip', $dosen->nip) }}"
                class="form-control tabular-nums @error('nip') is-invalid @enderror"
                inputmode="numeric"
                minlength="17"
                maxlength="18"
                autocorrect="off"
                autocapitalize="off"
                spellcheck="false"
                required
                aria-describedby="edit-dosen-nip-hint @error('nip') edit-dosen-nip-error @enderror"
                @error('nip') aria-invalid="true" @enderror
              >
              @error('nip')
                <div id="edit-dosen-nip-error" class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="edit-dosen-nama">Nama Dosen</label>
              <input
                id="edit-dosen-nama"
                type="text"
                name="nama_dosen"
                value="{{ old('nama_dosen', $dosen->nama_dosen) }}"
                class="form-control @error('nama_dosen') is-invalid @enderror"
                maxlength="200"
                required
                @error('nama_dosen') aria-invalid="true" aria-describedby="edit-dosen-nama-error" @enderror
              >
              @error('nama_dosen')
                <div id="edit-dosen-nama-error" class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="edit-dosen-mk">Mata Kuliah</label>
              <input
                id="edit-dosen-mk"
                type="text"
                name="mata_kuliah"
                value="{{ old('mata_kuliah', $dosen->mata_kuliah) }}"
                class="form-control @error('mata_kuliah') is-invalid @enderror"
                maxlength="200"
                required
                @error('mata_kuliah') aria-invalid="true" aria-describedby="edit-dosen-mk-error" @enderror
              >
              @error('mata_kuliah')
                <div id="edit-dosen-mk-error" class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group mb-0">
              <label for="edit-dosen-foto">Ganti Foto Dosen (Opsional)</label>
              <div id="edit-dosen-foto-hint" class="small text-muted mb-1">Biarkan kosong jika tidak ingin mengganti foto saat ini. Maksimal 1 MB.</div>
              <div class="custom-file">
                <input
                  id="edit-dosen-foto"
                  type="file"
                  name="foto_dosen"
                  class="custom-file-input @error('foto_dosen') is-invalid @enderror"
                  accept=".jpg,.jpeg,.png,.bmp,.webp,image/*"
                  data-preview-target="edit-dosen-photo-preview"
                  aria-describedby="edit-dosen-foto-hint @error('foto_dosen') edit-dosen-foto-error @enderror"
                  @error('foto_dosen') aria-invalid="true" @enderror
                >
                <label class="custom-file-label" for="edit-dosen-foto">Pilih foto baru...</label>
                @error('foto_dosen')
                  <div id="edit-dosen-foto-error" class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="col-md-4 mt-3 mt-md-0 text-center">
            <p class="font-weight-semibold mb-2">Foto Saat Ini</p>
            <img
              id="edit-dosen-photo-preview"
              src="{{ asset('foto_dosen/'.$dosen->foto_dosen) }}"
              alt="Foto saat ini milik {{ $dosen->nama_dosen }}"
              class="siakad-avatar-detail"
              width="160"
              height="160"
            >
          </div>
        </div>
      </div>

      <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
        <a href="{{ route('dosen') }}" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary" data-loading-text="Memperbarui data...">
          <i class="fas fa-save mr-1" aria-hidden="true"></i>Perbarui Data Dosen
        </button>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
@endpush
