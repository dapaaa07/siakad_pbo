@extends('layout.v_template_tables')

@section('title', 'Mahasiswa')
@section('page', 'Kelola Data Mahasiswa')

@section('content')
  @if(session('pesan'))
    <div class="alert alert-success alert-dismissible fade show" role="status">
      <i class="fas fa-check-circle mr-1" aria-hidden="true"></i>
      {{ session('pesan') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Tutup notifikasi">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
      <h2 id="mahasiswa-table-caption" class="card-title h5 mb-2 mb-sm-0 font-weight-bold">Daftar Data Mahasiswa</h2>
      <div class="siakad-action-group">
        <a href="{{ route('mahasiswa.print') }}" target="_blank" rel="noopener" class="btn btn-info">
          <i class="fas fa-file-pdf mr-1" aria-hidden="true"></i>Print PDF
        </a>
        <a href="{{ route('mahasiswa.add') }}" class="btn btn-primary">
          <i class="fas fa-plus mr-1" aria-hidden="true"></i>Tambah Data
        </a>
      </div>
    </div>

    <div class="card-body">
      <div class="siakad-table-region" role="region" tabindex="0" aria-labelledby="mahasiswa-table-caption">
        <table id="data-table-main" class="table table-bordered table-striped mb-0">
          <caption class="sr-only">Tabel data mahasiswa SIAKAD Politeknik Negeri Subang</caption>
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">NIM</th>
              <th scope="col">Nama</th>
              <th scope="col">Jurusan</th>
              <th scope="col">Prodi</th>
              <th scope="col">Tingkat / Sem.</th>
              <th scope="col">No. Handphone</th>
              <th scope="col" class="no-export">Foto</th>
              <th scope="col" class="no-export">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($mahasiswa as $index => $row)
              <tr>
                <td class="tabular-nums">{{ $index + 1 }}</td>
                <th scope="row" class="tabular-nums">{{ $row->nim }}</th>
                <td>{{ $row->nama }}</td>
                <td>{{ $row->jurusan }}</td>
                <td>{{ $row->prodi }}</td>
                <td class="tabular-nums">Tingkat {{ $row->tingkat }} / Sem. {{ $row->semester }}</td>
                <td class="tabular-nums">{{ $row->nomor_handphone }}</td>
                <td>
                  <img
                    src="{{ asset('foto_mahasiswa/'.$row->foto_mahasiswa) }}"
                    alt="Foto {{ $row->nama }}"
                    class="siakad-avatar-thumb"
                    width="64"
                    height="64"
                  >
                </td>
                <td>
                  <div class="siakad-action-group">
                    <a
                      href="{{ route('mahasiswa.detail', $row->nim) }}"
                      class="btn btn-sm btn-success"
                      aria-label="Detail {{ $row->nama }}"
                    >
                      <i class="fas fa-eye mr-1" aria-hidden="true"></i>Detail
                    </a>
                    <a
                      href="{{ route('mahasiswa.edit', $row->nim) }}"
                      class="btn btn-sm btn-warning"
                      aria-label="Edit {{ $row->nama }}"
                    >
                      <i class="fas fa-edit mr-1" aria-hidden="true"></i>Edit
                    </a>
                    <button
                      type="button"
                      class="btn btn-sm btn-danger"
                      data-delete-trigger
                      data-delete-url="{{ route('mahasiswa.delete', $row->nim) }}"
                      data-delete-name="{{ $row->nama }} ({{ $row->nim }})"
                      aria-label="Hapus {{ $row->nama }}"
                    >
                      <i class="fas fa-trash mr-1" aria-hidden="true"></i>Hapus
                    </button>
                  </div>
                </td>
              </tr>
            @empty
              <tr data-empty-row>
                <td colspan="9" class="text-center py-4">
                  <i class="fas fa-user-graduate fa-2x text-muted mb-2" aria-hidden="true"></i>
                  <h3 class="h6 font-weight-bold">Belum ada data mahasiswa tersimpan</h3>
                  <p class="text-muted mb-3">Tambahkan data mahasiswa baru untuk mengisi daftar akademik dan laporan PDF.</p>
                  <a href="{{ route('mahasiswa.add') }}" class="btn btn-primary btn-sm">Tambah Data Mahasiswa</a>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
