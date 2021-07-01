@extends('layouts.app', ['activePage' => 'pengajuan-lembur', 'titlePage' => __('Perintah Lembur')])

@section('content')
<div class="content">
  <div class="container-fluid">
    @if (Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ Session::get('success') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif
    <div class="row">
      <div class="col-md-12">
        @if ($cek != null && $cek->is_finish == 0)
        <div class="alert alert-info">Anda Memiliki Perintah Lembur!
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif
        <div class="card ">
          <div class="card-header card-header-primary">
            <h4 class="card-title">{{ __('Lembur') }}</h4>
            <p class="card-category">{{ __('List Pegawai Perintah Lembur') }}</p>
          </div>
          <div class="card-body">
            @if ($cek == null)
              <div class="alert alert-success">Anda Tidak Memiliki Perintah Lembur</div>
            @else
              <h5>Kode Perintah Lembur : <strong class="text-primary">{{ $cek->kode_pengajuan }}</strong></h5>
              <h5>Unit Kerja : <strong class="text-primary">{{ $pengajuan_lembur[0]->unit_kerja->nama_unit }}</strong></h5>
              <h5>Jenis Pekerjaan : <strong class="text-primary">{{ $cek->jenis_pekerjaan }}</strong></h5>
              <table id="pengajuan-lembur" class="table table-sm table-striped table-bordered" style="width:100%">
                <thead>
                  <tr>
                    <th>Nama Pegawai</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($pengajuan_lembur_detail as $item)
                    <tr>
                      <td>{{ $item->pegawai->nama_pegawai }}</td>
                      <td>{{ $item->jam_mulai }}</td>
                      <td>{{ $item->jam_selesai }}</td>
                    </tr>  
                  @endforeach
                </tbody>
              </table>
            @endif
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
  <link rel="stylesheet" href="{{ asset('material/css/bootstrap-material-datetimepicker.css') }}">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('js')
  <script src="{{ asset('material/js/bootstrap-material-datetimepicker.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.js" integrity="sha256-siqh9650JHbYFKyZeTEAhq+3jvkFCG8Iz+MHdr9eKrw=" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    });

    $(document).ready(function() {
      $('#pegawai_id').select2();

      $('#jam_mulai').bootstrapMaterialDatePicker({
        format: 'HH:mm:ss',
        time: true,
        date: false,
      });

      $('#jam_selesai').bootstrapMaterialDatePicker({
        format: 'HH:mm:ss',
        time: true,
        date: false,
      });
    });
  </script>
@endpush