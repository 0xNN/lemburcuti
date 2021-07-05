@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      @if (auth()->user()->is_admin == 1 || auth()->user()->is_admin == 2)
        <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-header card-header-warning card-header-icon">
                <div class="card-icon">
                  <i class="material-icons">account_circle</i>
                </div>
                <p class="card-category">Total Pegawai</p>
                <h3 class="card-title">{{ $total_pegawai }}</h3>
              </div>
              <div class="card-footer">

              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                  <i class="material-icons">assignment</i>
                </div>
                <p class="card-category">Total Peng. Cuti</p>
                <h3 class="card-title">{{ $total_pengajuan_cuti }}</h3>
              </div>
              <div class="card-footer">

              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                  <i class="material-icons">info_outline</i>
                </div>
                <p class="card-category">Total Peng. Lembur</p>
                <h3 class="card-title">{{ $total_pengajuan_lembur }}</h3>
              </div>
              <div class="card-footer">

              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12 col-md-12">
            <div class="card">
              <div class="card-header card-header-success">
                <h4 class="card-title">Data Pegawai</h4>
                <p class="card-category">Tabel List Pegawai </p>
              </div>
              <div class="card-body table-responsive">
                <table id="dt-pegawai" class="table table-sm table-bordered table-hover dt-responsive nowrap" style="width:100%">
                  <thead class="text-danger">
                    <tr>
                      <th>ID</th>
                      <th>Nama</th>
                      <th>NIP</th>
                      <th>Divisi</th>
                      <th>Jabatan</th>
                      <th>No HP</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      @else
        <div class="jumbotron">
          <h1 class="display-4">Selamat Datang!</h1>
          <p class="lead">Hai, {{ auth()->user()->name }}</p>
          <hr class="my-4">
          <p>Aplikasi ini merupakan aplikasi pengajuan cuti dan perintah lembur.</p>
          <div class="alert alert-info alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $msg }}</strong>
          </div>
          <p class="lead">
            <a class="btn btn-primary" href="{{ route('pengajuan_cuti.index') }}" role="button">Ajukan Cuti</a>
            <a class="btn btn-success" href="{{ route('pengajuan_lembur.index') }}" role="button">Cek Perintah Lembur</a>
          </p>
        </div>
      @endif
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
    var table = $('#dt-pegawai').DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      ajax: "{{ route('home') }}",
      columns: [
        {data: 'id', name: 'id'},
        {data: 'nama_pegawai', name: 'nama_pegawai'},
        {data: 'nip', name: 'nip'},
        {data: 'unit_kerja_id', name: 'unit_kerja_id'},
        {data: 'jabatan_id', name: 'jabatan_id'},
        {data: 'no_hp', name: 'no_hp'},
        {data: 'status_pegawai_id', name: 'status_pegawai_id'},
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
<script>
  $(document).ready(function() {
    // Javascript method's body can be found in assets/js/demos.js
    md.initDashboardPageCharts();
  });
</script>
@endpush