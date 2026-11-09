@extends('layout.v_template')

@push('styles')
  <link rel="stylesheet" href="{{ asset('template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush

@push('scripts')
  <script src="{{ asset('template/plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('template/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('template/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('template/plugins/jszip/jszip.min.js') }}"></script>
  <script src="{{ asset('template/plugins/pdfmake/pdfmake.min.js') }}"></script>
  <script src="{{ asset('template/plugins/pdfmake/vfs_fonts.js') }}"></script>
  <script src="{{ asset('template/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('template/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
  <script src="{{ asset('template/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
  <script>
    $(function () {
      var tableEl = $('#data-table-main');
      if (!tableEl.length || tableEl.find('tbody tr[data-empty-row]').length) {
        return;
      }

      var table = tableEl.DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        language: {
          search: 'Cari:',
          zeroRecords: 'Tidak ada data yang cocok dengan pencarian.',
          info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
          infoEmpty: 'Menampilkan 0 data',
          infoFiltered: '(disaring dari _MAX_ total data)',
          paginate: {
            first: 'Awal',
            last: 'Akhir',
            next: 'Berikutnya',
            previous: 'Sebelumnya'
          }
        },
        buttons: [
          { extend: 'copy', exportOptions: { columns: ':not(.no-export)' } },
          { extend: 'csv', exportOptions: { columns: ':not(.no-export)' } },
          { extend: 'excel', exportOptions: { columns: ':not(.no-export)' } },
          { extend: 'pdf', exportOptions: { columns: ':not(.no-export)' } },
          { extend: 'print', exportOptions: { columns: ':not(.no-export)' } },
          'colvis'
        ]
      });

      table.buttons().container().appendTo('#data-table-main_wrapper .col-md-6:eq(0)');
    });
  </script>
@endpush
