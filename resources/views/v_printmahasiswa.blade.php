<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Laporan Data Mahasiswa | SIAKAD</title>
  <style>
    body {
      font-family: DejaVu Sans, Arial, sans-serif;
      font-size: 10.5px;
      color: #212529;
      margin: 20px;
    }
    .report-header {
      border-bottom: 2px solid #0056b3;
      padding-bottom: 8px;
      margin-bottom: 14px;
    }
    .report-header h1 {
      font-size: 16px;
      margin: 0 0 4px 0;
      color: #0056b3;
    }
    .report-header p {
      margin: 0;
      color: #495057;
      font-size: 10px;
    }
    .meta {
      margin-bottom: 10px;
      font-size: 10px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      border: 1px solid #adb5bd;
      padding: 5px 6px;
      text-align: left;
      vertical-align: top;
    }
    th {
      background-color: #e9ecef;
      font-weight: 700;
    }
    tr:nth-child(even) td {
      background-color: #f8f9fa;
    }
  </style>
</head>
<body>
  <div class="report-header">
    <h1>Laporan Data Mahasiswa SIAKAD</h1>
    <p>Politeknik Negeri Subang, Jln. Brigjen Katamso No. 37, Dangdeur, Subang</p>
  </div>

  <p class="meta">Tanggal Cetak: {{ $printedAt }}</p>

  <table>
    <thead>
      <tr>
        <th style="width: 28px;">No</th>
        <th style="width: 72px;">NIM</th>
        <th>Nama</th>
        <th>Jurusan</th>
        <th>Program Studi</th>
        <th>TTL</th>
        <th>Alamat</th>
        <th style="width: 68px;">Agama</th>
        <th style="width: 62px;">Tkt / Sem</th>
        <th style="width: 85px;">No. HP</th>
      </tr>
    </thead>
    <tbody>
      @forelse($mahasiswa as $index => $row)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $row->nim }}</td>
          <td>{{ $row->nama }}</td>
          <td>{{ $row->jurusan }}</td>
          <td>{{ $row->prodi }}</td>
          <td>{{ $row->ttl }}</td>
          <td>{{ $row->alamat }}</td>
          <td>{{ $row->agama }}</td>
          <td>{{ $row->tingkat }} / {{ $row->semester }}</td>
          <td>{{ $row->nomor_handphone }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="10" style="text-align: center;">Belum ada data mahasiswa yang tersedia.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</body>
</html>
