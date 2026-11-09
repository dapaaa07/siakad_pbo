@extends('layout.v_template')

@section('title', 'Invoice')
@section('page', 'Invoice Pembayaran UKT')

@section('content')
  @if($invoices->isEmpty() || ! $invoice)
    <div class="card">
      <div class="card-body text-center py-5">
        <i class="fas fa-file-invoice fa-2x text-muted mb-2" aria-hidden="true"></i>
        <h2 class="h5 font-weight-bold">Belum ada data invoice UKT</h2>
        <p class="text-muted mb-3">Data invoice terhubung ke tabel mahasiswa. Pastikan data mahasiswa dan tagihan tersedia di database.</p>
        <a href="{{ route('mahasiswa') }}" class="btn btn-primary">Lihat Data Mahasiswa</a>
      </div>
    </div>
  @else
    @php
      $totalTagihan = (int) $invoice->nominal_ukt + (int) $invoice->biaya_praktikum;
      $isPaid = strtolower((string) $invoice->status_pembayaran) === 'lunas';
    @endphp

    <div class="card no-print mb-3">
      <div class="card-body d-flex justify-content-between align-items-end flex-wrap">
        <form action="{{ route('invoice') }}" method="GET" class="form-inline mb-2 mb-md-0">
          <div class="form-group mr-2 mb-2 mb-sm-0">
            <label for="invoice-select" class="mr-2 font-weight-semibold">Pilih Nomor Invoice:</label>
            <select id="invoice-select" name="no" class="custom-select">
              @foreach($invoices as $item)
                <option value="{{ $item->no_invoice }}" {{ $item->no_invoice === $invoice->no_invoice ? 'selected' : '' }}>
                  {{ $item->no_invoice }} ({{ $item->nama }} - {{ $item->status_pembayaran }})
                </option>
              @endforeach
            </select>
          </div>
          <button type="submit" class="btn btn-outline-primary">
            Tampilkan Invoice
          </button>
        </form>

        <button type="button" id="print-invoice-btn" class="btn btn-primary">
          <i class="fas fa-print mr-1" aria-hidden="true"></i>Cetak Invoice
        </button>
      </div>
    </div>

    <div class="invoice p-4 mb-3 border rounded">
      <div class="row mb-3">
        <div class="col-sm-8">
          <div class="d-flex align-items-center mb-2">
            <img src="{{ asset('img/siakad-logo.svg') }}" alt="" width="40" height="40" class="mr-2">
            <div>
              <h2 class="h4 mb-0 font-weight-bold">SIAKAD Politeknik Negeri Subang</h2>
              <p class="mb-0 small text-muted">Jln. Brigjen Katamso No. 37, Dangdeur, Kec. Subang, Kab. Subang</p>
            </div>
          </div>
        </div>
        <div class="col-sm-4 text-sm-right">
          <span class="badge badge-warning mb-2">SIMULASI TAGIHAN UKT</span>
          <p class="mb-0 small text-muted">Tanggal Terbit: {{ \Carbon\Carbon::parse($invoice->tanggal_terbit)->format('d M Y') }}</p>
        </div>
      </div>

      <div class="row invoice-info mb-4">
        <div class="col-sm-6 invoice-col mb-3 mb-sm-0">
          <h3 class="h6 font-weight-bold text-uppercase">Data Mahasiswa</h3>
          <address class="mb-0">
            <strong>{{ $invoice->nama }}</strong><br>
            NIM: <span class="tabular-nums">{{ $invoice->nim }}</span><br>
            Jurusan: {{ $invoice->jurusan }}<br>
            Program Studi: {{ $invoice->prodi }}<br>
            Alamat: {{ $invoice->alamat }}<br>
            No. HP: <span class="tabular-nums">{{ $invoice->nomor_handphone }}</span>
          </address>
        </div>

        <div class="col-sm-6 invoice-col">
          <h3 class="h6 font-weight-bold text-uppercase">Detail Tagihan</h3>
          <p class="mb-1"><strong>No. Invoice:</strong> <span class="tabular-nums">{{ $invoice->no_invoice }}</span></p>
          <p class="mb-1"><strong>Semester Akademik:</strong> {{ $invoice->semester_akademik }}</p>
          <p class="mb-1"><strong>Jatuh Tempo:</strong> {{ \Carbon\Carbon::parse($invoice->jatuh_tempo)->format('d M Y') }}</p>
          <p class="mb-0">
            <strong>Status Pembayaran:</strong>
            <span class="badge {{ $isPaid ? 'badge-success' : 'badge-warning' }}">
              <i class="fas {{ $isPaid ? 'fa-check' : 'fa-clock' }} mr-1" aria-hidden="true"></i>
              {{ $invoice->status_pembayaran }}
            </span>
          </p>
        </div>
      </div>

      <div class="siakad-responsive-table-wrap mb-4" role="region" tabindex="0" aria-label="Rincian biaya tagihan UKT">
        <table class="table table-bordered table-striped siakad-responsive-table mb-0">
          <thead>
            <tr>
              <th scope="col" style="width: 60px;">No</th>
              <th scope="col">Komponen Tagihan</th>
              <th scope="col">Keterangan</th>
              <th scope="col" class="text-right">Nominal (IDR)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row" data-label="No" class="tabular-nums">1</th>
              <td data-label="Komponen Tagihan">Uang Kuliah Tunggal (UKT)</td>
              <td data-label="Keterangan">{{ $invoice->semester_akademik }}</td>
              <td data-label="Nominal" class="text-right tabular-nums">Rp {{ number_format((int) $invoice->nominal_ukt, 0, ',', '.') }}</td>
            </tr>
            <tr>
              <th scope="row" data-label="No" class="tabular-nums">2</th>
              <td data-label="Komponen Tagihan">Biaya Praktikum &amp; Laboratorium</td>
              <td data-label="Keterangan">{{ $invoice->prodi }}</td>
              <td data-label="Nominal" class="text-right tabular-nums">Rp {{ number_format((int) $invoice->biaya_praktikum, 0, ',', '.') }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3 mb-md-0">
          <h3 class="h6 font-weight-bold">Kanal &amp; Catatan Pembayaran</h3>
          <p class="mb-1"><strong>Metode:</strong> {{ $invoice->metode_pembayaran }}</p>
          <p class="small text-muted mb-0">{{ $invoice->catatan }}</p>
        </div>
        <div class="col-md-6">
          <table class="table table-sm mb-0">
            <tbody>
              <tr>
                <th scope="row">Subtotal UKT</th>
                <td class="text-right tabular-nums">Rp {{ number_format((int) $invoice->nominal_ukt, 0, ',', '.') }}</td>
              </tr>
              <tr>
                <th scope="row">Biaya Praktikum</th>
                <td class="text-right tabular-nums">Rp {{ number_format((int) $invoice->biaya_praktikum, 0, ',', '.') }}</td>
              </tr>
              <tr>
                <th scope="row" class="h5 font-weight-bold">Total Tagihan</th>
                <td class="text-right h5 font-weight-bold tabular-nums">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  @endif
@endsection

@push('scripts')
  <script>
    (function () {
      var printBtn = document.getElementById('print-invoice-btn');
      if (printBtn) {
        printBtn.addEventListener('click', function () {
          window.print();
        });
      }
    })();
  </script>
@endpush
