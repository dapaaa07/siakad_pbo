@extends('layout.v_template')

@section('title', 'About')
@section('page', 'Tentang SIAKAD')

@section('content')
  <div class="row">
    <div class="col-md-7 mb-3">
      <div class="card h-100 mb-0">
        <div class="card-header">
          <h2 class="card-title h5 mb-0 font-weight-bold">Politeknik Negeri Subang</h2>
        </div>
        <div class="card-body">
          <p class="mb-3">
            Aplikasi Sistem Informasi Akademik (SIAKAD) ini dikembangkan untuk memenuhi seluruh materi dan latihan soal Pertemuan 12 Pemrograman Berorientasi Objek menggunakan Laravel dan templat AdminLTE 3.
          </p>
          <dl class="row mb-0">
            <dt class="col-sm-4">Nama Kampus</dt>
            <dd class="col-sm-8">Politeknik Negeri Subang</dd>

            <dt class="col-sm-4">Alamat</dt>
            <dd class="col-sm-8">Jln. Brigjen Katamso No. 37, Dangdeur, Kec. Subang, Kab. Subang, Jawa Barat</dd>

            <dt class="col-sm-4">Konteks Modul</dt>
            <dd class="col-sm-8">Pertemuan 12 Part 1, Part 2, dan Part 3 (CRUD, Detail, Multiuser Auth, ID Otomatis, PDF, Chart, Invoice)</dd>
          </dl>
        </div>
      </div>
    </div>

    <div class="col-md-5 mb-3">
      <div class="card h-100 mb-0">
        <div class="card-header">
          <h2 class="card-title h5 mb-0 font-weight-bold">Struktur Hak Akses (4 Level)</h2>
        </div>
        <div class="card-body">
          <ul class="mb-0 pl-3">
            <li class="mb-2"><strong>Level 1 (Admin):</strong> Home, Kelola Data Dosen, Mahasiswa, User, About, Chart, dan Invoice.</li>
            <li class="mb-2"><strong>Level 2 (User):</strong> Home dan User.</li>
            <li class="mb-2"><strong>Level 3 (Mahasiswa):</strong> Home dan Mahasiswa.</li>
            <li><strong>Level 4 (Dosen):</strong> Home dan Kelola Data Dosen.</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
@endsection
