<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Laporan Data Dosen | SIAKAD</title>
  <style>
    body {
      font-family: DejaVu Sans, Arial, sans-serif;
      font-size: 12px;
      color: #212529;
      margin: 24px;
    }
    .report-header {
      border-bottom: 2px solid #0056b3;
      padding-bottom: 10px;
      margin-bottom: 16px;
    }
    .report-header h1 {
      font-size: 18px;
      margin: 0 0 4px 0;
      color: #0056b3;
    }
    .report-header p {
      margin: 0;
      color: #495057;
      font-size: 11px;
    }
    .meta {
      margin-bottom: 12px;
      font-size: 11px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      border: 1px solid #adb5bd;
      padding: 7px 8px;
      text-align: left;
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
    <h1>Laporan Data Dosen SIAKAD</h1>
    <p>Politeknik Negeri Subang, Jln. Brigjen Katamso No. 37, Dangdeur, Subang</p>
  </div>

  <p class="meta">Tanggal Cetak: {{ $printedAt }}</p>

  <table>
    <thead>
      <tr>
        <th style="width: 36px;">No</th>
        <th style="width: 90px;">ID Dosen</th>
        <th style="width: 145px;">NIP</th>
        <th>Nama Dosen</th>
        <th>Mata Kuliah</th>
      </tr>
    </thead>
    <tbody>
      @forelse($dosen as $index => $row)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $row->id_dosen }}</td>
          <td>{{ $row->nip }}</td>
          <td>{{ $row->nama_dosen }}</td>
          <td>{{ $row->mata_kuliah }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="5" style="text-align: center;">Belum ada data dosen yang tersedia.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</body>
</html>
