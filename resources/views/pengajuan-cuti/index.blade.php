@extends('layouts.app', ['activePage' => 'pengajuan-cuti', 'titlePage' => __('Pengajuan Cuti')])

@section('content')
  @include('pengajuan-cuti.modal')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card ">
            <div class="card-header card-header-primary">
              <h4 class="card-title">{{ __('Cuti') }}</h4>
              <p class="card-category">{{ __('Daftar Pengajuan Cuti') }}</p>
            </div>
            <div class="card-body ">              
              <table id="dt-pengajuan-lembur" class="table table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Kode Cuti</th>
                    <th>Tgl Pengajuan</th>
                    <th>Pegawai</th>
                    <th>Unit Kerja</th>
                    <th>Bank Legacy</th>
                    <th>Tgl Mulai</th>
                    <th>Tgl Selesai</th>
                    <th>Jenis Cuti</th>
                    <th>Jenis Extra</th>
                    <th>Pegawai Pengganti</th>
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
<link rel="stylesheet" href="{{ asset('material') }}/css/style.css">
@endpush

@push('js')
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.js" integrity="sha256-siqh9650JHbYFKyZeTEAhq+3jvkFCG8Iz+MHdr9eKrw=" crossorigin="anonymous"></script>
<script src="{{ asset('material') }}/js/index.var.js"></script>
<script>
  $(document).ready(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  });

  $(document).ready(function () {
    var table = $('#dt-pengajuan-lembur').DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      ajax: "{{ route('pengajuan_cuti.index') }}",
      columns: [
        {data: 'id', name: 'id'},
        {data: 'kode_pengajuan', name: 'kode_pengajuan'},
        {data: 'tgl_pengajuan', name: 'tgl_pengajuan'},
        {data: 'pegawai_id', name: 'pegawai_id'},
        {data: 'unit_kerja_id', name: 'unit_kerja_id'},
        {data: 'bank_legacy_id', name: 'bank_legacy_id'},
        {data: 'tgl_mulai_cuti', name: 'tgl_mulai_cuti'},
        {data: 'tgl_selesai_cuti', name: 'tgl_selesai_cuti'},
        {data: 'jenis_cuti_id', name: 'jenis_cuti_id'},
        {data: 'jenis_cuti_extra_id', name: 'jenis_cuti_extra_id'},
        {data: 'pegawai_pengganti_id', name: 'pegawai_oengganti_id'},
        {data: 'status_pengajuan', name: 'status_pengajuan'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
      ],
      columnDefs: [ {
          className: 'dtr-control',
          orderable: false,
          targets:   0
      } ],
      order: [ 1, 'asc' ]
    });
  });

  function update(id, val, alasan_tolak=null)
  {
      var id = id;
      var value = val;
      var url = "{{ route('pengajuan_cuti.update', ":id") }}";
      url = url.replace(':id', id);
      console.log(url);
      $.ajax({
        url: url, //eksekusi ajax ke url ini
        data: {
          value: value,
          id: id,
          alasan_tolak: alasan_tolak,
          _token:'{{ csrf_token() }}',
        },
        dataType: "json",
        type: 'PUT',
        error: function (data) {
          console.log(data);
        },
        success: function (data) { //jika sukses
          var oTable = $('#dt-pengajuan-cuti').dataTable(); //inialisasi datatable
          oTable.fnDraw(false); //reset datatable
          new AWN().success('Cuti disetujui', {durations: {success: 1000}});
          setTimeout(function() {
            location.reload();
          }, 1500);
        }
      })
  }

  $(document).ready( function () {
    $(document).on('click', '#setuju', function() {
      var id = $(this).data('id');
      var value = $(this).val();
      let onOk = () => update(id, value, null);
      let notifier = new AWN();
      notifier.confirm(
        'Yakin ingin menyetujui?', 
        onOk,
        null,
        {
          labels: {
            confirm: 'Setuju?'
          }
        }
      );
    });

    $(document).on('click', '#tolak', function () {
      id = $(this).data('id');
      value = $(this).val();
      console.log(id);
      console.log(value);
      $('#tolakModal').modal('show');
    });

    $(document).on('click', '#tombol-tolak', function() {
      var alasan_tolak = $('#alasan_tolak').val();
      $('#tolakModal').modal('hide');
      update(id, value, alasan_tolak);
    });
  });
</script>
@endpush