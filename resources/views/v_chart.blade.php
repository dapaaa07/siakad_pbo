@extends('layout.v_template')

@section('title', 'Chart')
@section('page', 'Grafik Statistik SIAKAD')

@push('styles')
  <link rel="stylesheet" href="{{ asset('template/plugins/chart.js/Chart.min.css') }}">
@endpush

@section('content')
  <div class="row">
    <div class="col-12 mb-3">
      <div class="card card-outline card-primary mb-0">
        <div class="card-header">
          <h2 class="card-title h5 mb-0 font-weight-bold">Berapa jumlah pengguna yang terdaftar pada setiap tahun?</h2>
        </div>
        <div class="card-body">
          @if(empty($yearlyLabels))
            <div class="text-center py-4">
              <i class="fas fa-chart-line fa-2x text-muted mb-2" aria-hidden="true"></i>
              <h3 class="h6 font-weight-bold">Belum ada data pendaftaran pengguna</h3>
              <p class="text-muted mb-0">Grafik akan tampil otomatis setelah akun pengguna tersimpan di database.</p>
            </div>
          @else
            <figure class="mb-3">
              <div class="siakad-chart-canvas-wrap">
                <canvas id="users-yearly-chart" role="img" aria-label="Grafik garis jumlah pendaftar pengguna per tahun"></canvas>
              </div>
              <figcaption class="small text-muted mt-2">
                Sumber: kolom <code>created_at</code> pada tabel <code>users</code>.
              </figcaption>
            </figure>

            <details>
              <summary class="small font-weight-semibold" style="cursor: pointer;">Lihat tabel data pendaftar per tahun</summary>
              <div class="siakad-responsive-table-wrap mt-2" role="region" tabindex="0" aria-label="Data jumlah pendaftar per tahun">
                <table class="table table-sm table-bordered siakad-responsive-table mb-0">
                  <thead>
                    <tr>
                      <th scope="col">Tahun</th>
                      <th scope="col" class="text-right">Jumlah Pengguna</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($yearlyLabels as $idx => $year)
                      <tr>
                        <th scope="row" data-label="Tahun" class="tabular-nums">{{ $year }}</th>
                        <td data-label="Jumlah Pengguna" class="text-right tabular-nums">{{ $yearlyCounts[$idx] ?? 0 }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </details>
          @endif
        </div>
      </div>
    </div>

    <div class="col-lg-6 mb-3">
      <div class="card h-100 mb-0">
        <div class="card-header">
          <h2 class="card-title h5 mb-0 font-weight-bold">Berapa jumlah pengguna pada setiap level akses?</h2>
        </div>
        <div class="card-body">
          @if(array_sum($levelCounts) === 0)
            <div class="text-center py-4">
              <i class="fas fa-chart-bar fa-2x text-muted mb-2" aria-hidden="true"></i>
              <h3 class="h6 font-weight-bold">Belum ada akun berdasarkan level</h3>
              <p class="text-muted mb-0">Tambahkan akun Admin, User, Mahasiswa, atau Dosen melalui halaman registrasi.</p>
            </div>
          @else
            <figure class="mb-3">
              <div class="siakad-chart-canvas-wrap">
                <canvas id="users-level-chart" role="img" aria-label="Grafik batang horizontal distribusi level pengguna"></canvas>
              </div>
              <figcaption class="small text-muted mt-2">
                Sumber: distribusi kolom <code>level</code> pada tabel <code>users</code>.
              </figcaption>
            </figure>

            <details>
              <summary class="small font-weight-semibold" style="cursor: pointer;">Lihat tabel data level pengguna</summary>
              <div class="siakad-responsive-table-wrap mt-2" role="region" tabindex="0" aria-label="Data pengguna per level akses">
                <table class="table table-sm table-bordered siakad-responsive-table mb-0">
                  <thead>
                    <tr>
                      <th scope="col">Level Akses</th>
                      <th scope="col" class="text-right">Jumlah Akun</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($levelLabels as $idx => $lvlLabel)
                      <tr>
                        <th scope="row" data-label="Level Akses">{{ $lvlLabel }}</th>
                        <td data-label="Jumlah Akun" class="text-right tabular-nums">{{ $levelCounts[$idx] ?? 0 }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </details>
          @endif
        </div>
      </div>
    </div>

    <div class="col-lg-6 mb-3">
      <div class="card h-100 mb-0">
        <div class="card-header">
          <h2 class="card-title h5 mb-0 font-weight-bold">Bagaimana sebaran mahasiswa per program studi?</h2>
        </div>
        <div class="card-body">
          @if(empty($prodiLabels))
            <div class="text-center py-4">
              <i class="fas fa-user-graduate fa-2x text-muted mb-2" aria-hidden="true"></i>
              <h3 class="h6 font-weight-bold">Belum ada data mahasiswa</h3>
              <p class="text-muted mb-2">Tambahkan mahasiswa terlebih dahulu agar sebaran program studi dapat dihitung.</p>
              <a href="{{ route('mahasiswa.add') }}" class="btn btn-sm btn-primary">Tambah Mahasiswa</a>
            </div>
          @else
            <figure class="mb-3">
              <div class="siakad-chart-canvas-wrap">
                <canvas id="mahasiswa-prodi-chart" role="img" aria-label="Grafik batang horizontal sebaran mahasiswa per program studi"></canvas>
              </div>
              <figcaption class="small text-muted mt-2">
                Sumber: agregasi kolom <code>prodi</code> pada tabel <code>tb_mahasiswa</code>.
              </figcaption>
            </figure>

            <details>
              <summary class="small font-weight-semibold" style="cursor: pointer;">Lihat tabel data mahasiswa per prodi</summary>
              <div class="siakad-responsive-table-wrap mt-2" role="region" tabindex="0" aria-label="Data jumlah mahasiswa per program studi">
                <table class="table table-sm table-bordered siakad-responsive-table mb-0">
                  <thead>
                    <tr>
                      <th scope="col">Program Studi</th>
                      <th scope="col" class="text-right">Jumlah Mahasiswa</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($prodiLabels as $idx => $prodiName)
                      <tr>
                        <th scope="row" data-label="Program Studi">{{ $prodiName }}</th>
                        <td data-label="Jumlah Mahasiswa" class="text-right tabular-nums">{{ $prodiCounts[$idx] ?? 0 }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </details>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('template/plugins/chart.js/Chart.min.js') }}"></script>
  <script>
    (function () {
      var yearlyLabels = @json($yearlyLabels);
      var yearlyCounts = @json($yearlyCounts);
      var levelLabels = @json($levelLabels);
      var levelCounts = @json($levelCounts);
      var prodiLabels = @json($prodiLabels);
      var prodiCounts = @json($prodiCounts);

      var charts = [];

      function getPalette() {
        var isDark = document.body.classList.contains('dark-mode');
        return {
          text: isDark ? '#e9ecef' : '#212529',
          grid: isDark ? 'rgba(233, 236, 239, 0.16)' : 'rgba(33, 37, 41, 0.12)',
          primary: isDark ? '#7cc4ff' : '#0056b3',
          primaryFill: isDark ? 'rgba(124, 196, 255, 0.2)' : 'rgba(0, 86, 179, 0.15)',
          success: isDark ? '#3dd68c' : '#146c43',
          accent: isDark ? '#ffca2c' : '#0e5a6f'
        };
      }

      function renderCharts() {
        while (charts.length) {
          charts.pop().destroy();
        }

        var palette = getPalette();
        var commonScales = {
          xAxes: [{
            ticks: { fontColor: palette.text, beginAtZero: true, precision: 0 },
            gridLines: { color: palette.grid }
          }],
          yAxes: [{
            ticks: { fontColor: palette.text, beginAtZero: true, precision: 0 },
            gridLines: { color: palette.grid }
          }]
        };

        var yearlyEl = document.getElementById('users-yearly-chart');
        if (yearlyEl && yearlyLabels.length) {
          charts.push(new Chart(yearlyEl.getContext('2d'), {
            type: 'line',
            data: {
              labels: yearlyLabels,
              datasets: [{
                label: 'Pengguna Terdaftar',
                data: yearlyCounts,
                borderColor: palette.primary,
                backgroundColor: palette.primaryFill,
                borderWidth: 2,
                pointRadius: 4,
                fill: true
              }]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              legend: { labels: { fontColor: palette.text } },
              scales: commonScales
            }
          }));
        }

        var levelEl = document.getElementById('users-level-chart');
        if (levelEl && levelLabels.length) {
          charts.push(new Chart(levelEl.getContext('2d'), {
            type: 'horizontalBar',
            data: {
              labels: levelLabels,
              datasets: [{
                label: 'Jumlah Akun',
                data: levelCounts,
                backgroundColor: palette.success
              }]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              legend: { labels: { fontColor: palette.text } },
              scales: commonScales
            }
          }));
        }

        var prodiEl = document.getElementById('mahasiswa-prodi-chart');
        if (prodiEl && prodiLabels.length) {
          charts.push(new Chart(prodiEl.getContext('2d'), {
            type: 'horizontalBar',
            data: {
              labels: prodiLabels,
              datasets: [{
                label: 'Jumlah Mahasiswa',
                data: prodiCounts,
                backgroundColor: palette.accent
              }]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              legend: { labels: { fontColor: palette.text } },
              scales: commonScales
            }
          }));
        }
      }

      document.addEventListener('DOMContentLoaded', renderCharts);
      window.addEventListener('siakad:theme-change', renderCharts);
    })();
  </script>
@endpush
