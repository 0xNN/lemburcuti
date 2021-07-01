@extends('layouts.app', ['activePage' => 'riwayat-lembur', 'titlePage' => __('Riwayat Perintah Lembur')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card ">
          <div class="card-header card-header-primary">
            <h4 class="card-title">{{ __('Riwayat Cuti') }}</h4>
            <p class="card-category">{{ __('Daftar Riwayat Pengajuan Cuti') }}</p>
          </div>
          <div class="card-body ">              
            <table id="dt-riwayat-lembur" class="table table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Kode Pengajuan</th>
                  <th>Tgl Pengajuan</th>
                  <th>Divisi</th>
                  <th>Jam Mulai/Selesai</th>
                  <th>Pegawai</th>
                  <th>Jenis</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
          <div class="card-footer ml-auto mr-auto">

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
@endpush

@push('js')
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script>
  $(document).ready(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  });

  $(document).ready(function() {
    var table = $('#dt-riwayat-lembur').DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      ajax: "{{ route('riwayat_lembur.index') }}",
      columns: [
        {data: 'id', name: 'id'},
        {data: 'kode_pengajuan', name: 'kode_pengajuan'},
        {data: 'tgl_pengajuan', name: 'tgl_pengajuan'},
        {data: 'unit_kerja_id', name: 'unit_kerja_id'},
        {data: 'jam_mulai_selesai', name: 'jam_mulai_selesai'},
        {data: 'pegawai', name: 'pegawai'},
        {data: 'jenis_pekerjaan', name: 'jenis_pekerjaan'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
      ],
      columnDefs: [ {
          className: 'dtr-control',
          orderable: false,
          targets:   0
      } ],
      order: [ 1, 'asc' ]
    });
  })
</script>
@endpush