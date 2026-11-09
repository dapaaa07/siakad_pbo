@extends('layout.v_template')

@section('title', 'Detail Dosen')
@section('page', 'Detail Data Dosen')

@section('content')
  <div class="card card-outline card-primary">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
      <h2 class="card-title h5 mb-0 font-weight-bold">Informasi Lengkap Dosen: {{ $dosen->nama_dosen }}</h2>
      <span class="badge badge-info tabular-nums">{{ $dosen->id_dosen }}</span>
    </div>

    <div class="card-body">
      <div class="row align-items-start">
        <div class="col-md-3 text-center text-md-left mb-3 mb-md-0">
          <img
            src="{{ asset('foto_dosen/'.$dosen->foto_dosen) }}"
            alt="Foto {{ $dosen->nama_dosen }}"
            class="siakad-avatar-detail"
            width="160"
            height="160"
          >
        </div>
        <div class="col-md-9">
          <dl class="row mb-0">
            <dt class="col-sm-3">ID Dosen</dt>
            <dd class="col-sm-9 tabular-nums">{{ $dosen->id_dosen }}</dd>

            <dt class="col-sm-3">NIP</dt>
            <dd class="col-sm-9 tabular-nums">{{ $dosen->nip }}</dd>

            <dt class="col-sm-3">Nama Dosen</dt>
            <dd class="col-sm-9">{{ $dosen->nama_dosen }}</dd>

            <dt class="col-sm-3">Mata Kuliah</dt>
            <dd class="col-sm-9">{{ $dosen->mata_kuliah }}</dd>

            <dt class="col-sm-3">Nama Berkas Foto</dt>
            <dd class="col-sm-9"><code>{{ $dosen->foto_dosen }}</code></dd>
          </dl>
        </div>
      </div>
    </div>

    <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
      <a href="{{ route('dosen') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left mr-1" aria-hidden="true"></i>Kembali ke Daftar Dosen
      </a>
      <a href="{{ route('dosen.edit', $dosen->id_dosen) }}" class="btn btn-warning">
        <i class="fas fa-edit mr-1" aria-hidden="true"></i>Edit Data Dosen
      </a>
    </div>
  </div>
@endsection
