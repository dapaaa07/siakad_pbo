@extends('layout.v_template')

@section('title', 'Detail Mahasiswa')
@section('page', 'Detail Data Mahasiswa')

@section('content')
  <div class="card card-outline card-primary">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
      <h2 class="card-title h5 mb-0 font-weight-bold">Biodata Mahasiswa: {{ $mahasiswa->nama }}</h2>
      <span class="badge badge-info tabular-nums">NIM: {{ $mahasiswa->nim }}</span>
    </div>

    <div class="card-body">
      <div class="row align-items-start">
        <div class="col-md-3 text-center text-md-left mb-3 mb-md-0">
          <img
            src="{{ asset('foto_mahasiswa/'.$mahasiswa->foto_mahasiswa) }}"
            alt="Foto {{ $mahasiswa->nama }}"
            class="siakad-avatar-detail"
            width="160"
            height="160"
          >
        </div>
        <div class="col-md-9">
          <dl class="row mb-0">
            <dt class="col-sm-4">NIM</dt>
            <dd class="col-sm-8 tabular-nums">{{ $mahasiswa->nim }}</dd>

            <dt class="col-sm-4">Nama Lengkap</dt>
            <dd class="col-sm-8">{{ $mahasiswa->nama }}</dd>

            <dt class="col-sm-4">Jurusan</dt>
            <dd class="col-sm-8">{{ $mahasiswa->jurusan }}</dd>

            <dt class="col-sm-4">Program Studi</dt>
            <dd class="col-sm-8">{{ $mahasiswa->prodi }}</dd>

            <dt class="col-sm-4">Tempat, Tanggal Lahir</dt>
            <dd class="col-sm-8">{{ $mahasiswa->ttl }}</dd>

            <dt class="col-sm-4">Alamat</dt>
            <dd class="col-sm-8">{{ $mahasiswa->alamat }}</dd>

            <dt class="col-sm-4">Agama</dt>
            <dd class="col-sm-8">{{ $mahasiswa->agama }}</dd>

            <dt class="col-sm-4">Tingkat</dt>
            <dd class="col-sm-8 tabular-nums">Tingkat {{ $mahasiswa->tingkat }}</dd>

            <dt class="col-sm-4">Semester</dt>
            <dd class="col-sm-8 tabular-nums">Semester {{ $mahasiswa->semester }}</dd>

            <dt class="col-sm-4">Nomor Handphone</dt>
            <dd class="col-sm-8 tabular-nums">{{ $mahasiswa->nomor_handphone }}</dd>

            <dt class="col-sm-4">Berkas Foto</dt>
            <dd class="col-sm-8"><code>{{ $mahasiswa->foto_mahasiswa }}</code></dd>
          </dl>
        </div>
      </div>
    </div>

    <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
      <a href="{{ route('mahasiswa') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left mr-1" aria-hidden="true"></i>Kembali ke Daftar Mahasiswa
      </a>
      <a href="{{ route('mahasiswa.edit', $mahasiswa->nim) }}" class="btn btn-warning">
        <i class="fas fa-edit mr-1" aria-hidden="true"></i>Edit Data Mahasiswa
      </a>
    </div>
  </div>
@endsection
