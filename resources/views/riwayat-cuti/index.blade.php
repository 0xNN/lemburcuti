@extends('layouts.app', ['activePage' => 'riwayat-cuti', 'titlePage' => __('Riwayat Pengajuan Cuti')])

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
            <table id="dt-riwayat-cuti" class="table table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Kode Pengajuan</th>
                  <th>Pegawai</th>
                  <th>Divisi</th>
                  <th>BL</th>
                  <th>Jenis</th>
                  <th>Tgl Mulai/Selesai</th>
                  <th>Tgl Pengajuan</th>
                  <th>Status</th>
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
    var table = $('#dt-riwayat-cuti').DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      ajax: "{{ route('riwayat_cuti.index') }}",
      columns: [
        {data: 'id', name: 'id'},
        {data: 'kode_pengajuan', name: 'kode_pengajuan'},
        {data: 'pegawai_id', name: 'pegawai_id'},
        {data: 'unit_kerja_id', name: 'unit_kerja_id'},
        {data: 'bank_legacy_id', name: 'bank_legacy_id'},
        {data: 'jenis_cuti_id', name: 'jenis_cuti_id'},
        {data: 'tgl_mulai_selesai_cuti', name: 'tgl_mulai_selesai_cuti'},
        {data: 'tgl_pengajuan', name: 'tgl_pengajuan'},
        {data: 'status_perubahan', name: 'status_perubahan'},
        {data: 'user_modify', name: 'user_modify'}
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