@extends('layout.v_template_tables')

@section('title', 'Dosen')
@section('page', 'Kelola Data Dosen')

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
      <h2 id="dosen-table-caption" class="card-title h5 mb-2 mb-sm-0 font-weight-bold">Daftar Data Dosen</h2>
      <div class="siakad-action-group">
        <a href="{{ route('dosen.print') }}" target="_blank" rel="noopener" class="btn btn-info">
          <i class="fas fa-file-pdf mr-1" aria-hidden="true"></i>Print PDF
        </a>
        <a href="{{ route('dosen.add') }}" class="btn btn-primary">
          <i class="fas fa-plus mr-1" aria-hidden="true"></i>Tambah Data
        </a>
      </div>
    </div>

    <div class="card-body">
      <div class="siakad-table-region" role="region" tabindex="0" aria-labelledby="dosen-table-caption">
        <table id="data-table-main" class="table table-bordered table-striped mb-0">
          <caption class="sr-only">Tabel data dosen SIAKAD Politeknik Negeri Subang</caption>
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">ID Dosen</th>
              <th scope="col">NIP</th>
              <th scope="col">Nama Dosen</th>
              <th scope="col">Mata Kuliah</th>
              <th scope="col" class="no-export">Foto</th>
              <th scope="col" class="no-export">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($dosen as $index => $row)
              <tr>
                <td class="tabular-nums">{{ $index + 1 }}</td>
                <th scope="row" class="tabular-nums">{{ $row->id_dosen }}</th>
                <td class="tabular-nums">{{ $row->nip }}</td>
                <td>{{ $row->nama_dosen }}</td>
                <td>{{ $row->mata_kuliah }}</td>
                <td>
                  <img
                    src="{{ asset('foto_dosen/'.$row->foto_dosen) }}"
                    alt="Foto {{ $row->nama_dosen }}"
                    class="siakad-avatar-thumb"
                    width="64"
                    height="64"
                  >
                </td>
                <td>
                  <div class="siakad-action-group">
                    <a
                      href="{{ route('dosen.detail', $row->id_dosen) }}"
                      class="btn btn-sm btn-success"
                      aria-label="Detail {{ $row->nama_dosen }}"
                    >
                      <i class="fas fa-eye mr-1" aria-hidden="true"></i>Detail
                    </a>
                    <a
                      href="{{ route('dosen.edit', $row->id_dosen) }}"
                      class="btn btn-sm btn-warning"
                      aria-label="Edit {{ $row->nama_dosen }}"
                    >
                      <i class="fas fa-edit mr-1" aria-hidden="true"></i>Edit
                    </a>
                    <button
                      type="button"
                      class="btn btn-sm btn-danger"
                      data-delete-trigger
                      data-delete-url="{{ route('dosen.delete', $row->id_dosen) }}"
                      data-delete-name="{{ $row->nama_dosen }} ({{ $row->id_dosen }})"
                      aria-label="Hapus {{ $row->nama_dosen }}"
                    >
                      <i class="fas fa-trash mr-1" aria-hidden="true"></i>Hapus
                    </button>
                  </div>
                </td>
              </tr>
            @empty
              <tr data-empty-row>
                <td colspan="7" class="text-center py-4">
                  <i class="fas fa-chalkboard-teacher fa-2x text-muted mb-2" aria-hidden="true"></i>
                  <h3 class="h6 font-weight-bold">Belum ada data dosen tersimpan</h3>
                  <p class="text-muted mb-3">Tambahkan data dosen baru untuk mengisi tabel dan laporan PDF.</p>
                  <a href="{{ route('dosen.add') }}" class="btn btn-primary btn-sm">Tambah Data Dosen</a>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
