@extends('layout.v_template')

@section('title', 'Edit Mahasiswa')
@section('page', 'Ubah Data Mahasiswa')

@section('content')
  <div class="card card-outline card-warning">
    <div class="card-header">
      <h2 class="card-title h5 mb-0 font-weight-bold">Formulir Ubah Data Mahasiswa ({{ $mahasiswa->nim }})</h2>
    </div>

    <form action="{{ route('mahasiswa.update', $mahasiswa->nim) }}" method="POST" enctype="multipart/form-data" data-loading-submit novalidate>
      @csrf
      <div class="card-body">
        @if($errors->any())
          <div class="alert alert-danger" role="alert">
            <i class="fas fa-exclamation-triangle mr-1" aria-hidden="true"></i>
            Periksa kembali kolom yang ditandai sebelum menyimpan perubahan.
          </div>
        @endif

        <div class="row">
          <div class="col-lg-8">
            <div class="form-group">
              <label for="edit-mhs-nim">NIM</label>
              <input
                id="edit-mhs-nim"
                type="text"
                name="nim"
                value="{{ $mahasiswa->nim }}"
                class="form-control tabular-nums"
                readonly
              >
            </div>

            <div class="form-group">
              <label for="edit-mhs-nama">Nama Mahasiswa</label>
              <input
                id="edit-mhs-nama"
                type="text"
                name="nama"
                value="{{ old('nama', $mahasiswa->nama) }}"
                class="form-control @error('nama') is-invalid @enderror"
                autocomplete="name"
                maxlength="100"
                required
                @error('nama') aria-invalid="true" aria-describedby="edit-mhs-nama-error" @enderror
              >
              @error('nama')
                <div id="edit-mhs-nama-error" class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="edit-mhs-jurusan">Jurusan</label>
                  <input
                    id="edit-mhs-jurusan"
                    type="text"
                    name="jurusan"
                    value="{{ old('jurusan', $mahasiswa->jurusan) }}"
                    class="form-control @error('jurusan') is-invalid @enderror"
                    maxlength="100"
                    required
                    @error('jurusan') aria-invalid="true" aria-describedby="edit-mhs-jurusan-error" @enderror
                  >
                  @error('jurusan')
                    <div id="edit-mhs-jurusan-error" class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="edit-mhs-prodi">Program Studi</label>
                  <input
                    id="edit-mhs-prodi"
                    type="text"
                    name="prodi"
                    value="{{ old('prodi', $mahasiswa->prodi) }}"
                    class="form-control @error('prodi') is-invalid @enderror"
                    maxlength="100"
                    required
                    @error('prodi') aria-invalid="true" aria-describedby="edit-mhs-prodi-error" @enderror
                  >
                  @error('prodi')
                    <div id="edit-mhs-prodi-error" class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="edit-mhs-ttl">Tempat, Tanggal Lahir</label>
                  <input
                    id="edit-mhs-ttl"
                    type="text"
                    name="ttl"
                    value="{{ old('ttl', $mahasiswa->ttl) }}"
                    class="form-control @error('ttl') is-invalid @enderror"
                    maxlength="100"
                    required
                    @error('ttl') aria-invalid="true" aria-describedby="edit-mhs-ttl-error" @enderror
                  >
                  @error('ttl')
                    <div id="edit-mhs-ttl-error" class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="edit-mhs-agama">Agama</label>
                  @php
                    $agamaOptions = ['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
                    $currentAgama = old('agama', $mahasiswa->agama);
                  @endphp
                  <select
                    id="edit-mhs-agama"
                    name="agama"
                    class="custom-select @error('agama') is-invalid @enderror"
                    required
                    @error('agama') aria-invalid="true" aria-describedby="edit-mhs-agama-error" @enderror
                  >
                    <option value="">-- Pilih Agama --</option>
                    @foreach($agamaOptions as $opt)
                      <option value="{{ $opt }}" {{ $currentAgama === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                    @endforeach
                  </select>
                  @error('agama')
                    <div id="edit-mhs-agama-error" class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="edit-mhs-alamat">Alamat</label>
              <textarea
                id="edit-mhs-alamat"
                name="alamat"
                rows="3"
                class="form-control @error('alamat') is-invalid @enderror"
                autocomplete="street-address"
                required
                @error('alamat') aria-invalid="true" aria-describedby="edit-mhs-alamat-error" @enderror
              >{{ old('alamat', $mahasiswa->alamat) }}</textarea>
              @error('alamat')
                <div id="edit-mhs-alamat-error" class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="edit-mhs-tingkat">Tingkat</label>
                  <input
                    id="edit-mhs-tingkat"
                    type="text"
                    name="tingkat"
                    value="{{ old('tingkat', $mahasiswa->tingkat) }}"
                    class="form-control tabular-nums @error('tingkat') is-invalid @enderror"
                    inputmode="numeric"
                    required
                    @error('tingkat') aria-invalid="true" aria-describedby="edit-mhs-tingkat-error" @enderror
                  >
                  @error('tingkat')
                    <div id="edit-mhs-tingkat-error" class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-sm-4">
                <div class="form-group">
                  <label for="edit-mhs-semester">Semester</label>
                  <input
                    id="edit-mhs-semester"
                    type="text"
                    name="semester"
                    value="{{ old('semester', $mahasiswa->semester) }}"
                    class="form-control tabular-nums @error('semester') is-invalid @enderror"
                    inputmode="numeric"
                    required
                    @error('semester') aria-invalid="true" aria-describedby="edit-mhs-semester-error" @enderror
                  >
                  @error('semester')
                    <div id="edit-mhs-semester-error" class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="col-sm-4">
                <div class="form-group">
                  <label for="edit-mhs-hp">Nomor Handphone</label>
                  <input
                    id="edit-mhs-hp"
                    type="text"
                    name="nomor_handphone"
                    value="{{ old('nomor_handphone', $mahasiswa->nomor_handphone) }}"
                    class="form-control tabular-nums @error('nomor_handphone') is-invalid @enderror"
                    inputmode="tel"
                    autocomplete="tel"
                    maxlength="20"
                    required
                    @error('nomor_handphone') aria-invalid="true" aria-describedby="edit-mhs-hp-error" @enderror
                  >
                  @error('nomor_handphone')
                    <div id="edit-mhs-hp-error" class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="form-group mb-0">
              <label for="edit-mhs-foto">Ganti Foto Mahasiswa (Opsional)</label>
              <div id="edit-mhs-foto-hint" class="small text-muted mb-1">Biarkan kosong jika tidak ingin mengganti foto saat ini. Maksimal 1 MB.</div>
              <div class="custom-file">
                <input
                  id="edit-mhs-foto"
                  type="file"
                  name="foto_mahasiswa"
                  class="custom-file-input @error('foto_mahasiswa') is-invalid @enderror"
                  accept=".jpg,.jpeg,.png,.bmp,.webp,image/*"
                  data-preview-target="edit-mhs-photo-preview"
                  aria-describedby="edit-mhs-foto-hint @error('foto_mahasiswa') edit-mhs-foto-error @enderror"
                  @error('foto_mahasiswa') aria-invalid="true" @enderror
                >
                <label class="custom-file-label" for="edit-mhs-foto">Pilih foto baru...</label>
                @error('foto_mahasiswa')
                  <div id="edit-mhs-foto-error" class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="col-lg-4 mt-3 mt-lg-0 text-center">
            <p class="font-weight-semibold mb-2">Foto Saat Ini</p>
            <img
              id="edit-mhs-photo-preview"
              src="{{ asset('foto_mahasiswa/'.$mahasiswa->foto_mahasiswa) }}"
              alt="Foto saat ini milik {{ $mahasiswa->nama }}"
              class="siakad-avatar-detail"
              width="160"
              height="160"
            >
          </div>
        </div>
      </div>

      <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
        <a href="{{ route('mahasiswa') }}" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary" data-loading-text="Memperbarui data...">
          <i class="fas fa-save mr-1" aria-hidden="true"></i>Perbarui Data Mahasiswa
        </button>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('template/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
@endpush
