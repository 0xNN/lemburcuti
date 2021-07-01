@extends('layouts.app', ['activePage' => 'laporan', 'titlePage' => __('Laporan')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header card-header-primary">
          <h4 class="card-title">{{ __('Cuti') }}</h4>
        </div>
        <div class="card-body">
          <small>cetak laporan pengajuan cuti</small>
          <div class="row">
            <div class="col-sm-6 col-md-6">
              <div class="form-group">
                <select name="jenis_cuti_id" id="jenis_cuti_id" class="form-control">
                  <option>-- PER JENIS CUTI --</option>
                  @foreach ($jenis_cuti as $item)
                    <option value="{{ $item->id }}">{{ $item->nama_jenis }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-sm-6 col-md-6">
              <div class="form-group">
                <div class="input-group date">
                  <input name="tgl_pengajuan" id="tgl_pengajuan" class="form-control" placeholder="Tgl Pengajuan">
                  <span class="input-group-addon">
                    <i class="material-icons">calendar_today</i>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <button id="button-cuti" name="button-cuti" class="btn btn-sm btn-primary">Cetak</button>
            </div>
          </div>
        </div>
      </div>
      <hr>
      <div class="card">
        <div class="card-header card-header-primary">
          <h4 class="card-title">{{ __('Lembur') }}</h4>
        </div>
        <div class="card-body">
          <small>cetak laporan perintah lembur</small>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <select name="unit_kerja_id" id="unit_kerja_id" class="form-control">
                  <option>-- PER UNIT --</option>
                  @foreach ($unit_kerja as $item)
                    <option value="{{ $item->id }}">{{ $item->nama_unit }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <div class="input-group date">
                  <input name="tgl_pengajuan_lembur" id="tgl_pengajuan_lembur" class="form-control" placeholder="Tgl Pengajuan">
                  <span class="input-group-addon">
                    <i class="material-icons">calendar_today</i>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <button id="button-lembur" name="button-lembur" class="btn btn-sm btn-primary">Cetak</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('material/css/bootstrap-material-datetimepicker.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('js')
<script src="{{ asset('material/js/bootstrap-material-datetimepicker.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  });

  $(document).ready(function() {
    $('#pegawai_id').select2({
      placeholder: "PEGAWAI"
    });

    $('#unit_kerja_id').select2();
    $('#jenis_cuti_id').select2();

    $('#tgl_pengajuan').bootstrapMaterialDatePicker({
      format: 'YYYY-MM-DD',
      time: false,
    });

    $('#tgl_pengajuan_lembur').bootstrapMaterialDatePicker({
      format: 'YYYY-MM-DD',
      time: false,
    });

    $('#button-cuti').click(function() {
      var jenis_cuti_id = $('#jenis_cuti_id').val();
      var tgl_pengajuan = $('#tgl_pengajuan').val();
      
      if(jenis_cuti_id == '-- PER JENIS CUTI --') {
        jenis_cuti_id = "";
      }

      $(this).attr('disabled', true);
      $.ajax({
        type: 'GET',
        url: '{{ url('/')  }}'+'/laporan/cuti/print/'+jenis_cuti_id+'/'+tgl_pengajuan,
        xhrFields: {
          responseType: 'blob'
        },
        success: function(response){
          $('#button-cuti').removeAttr('disabled');
        },
        error: function(blob){
          console.log(blob);
        }
      });
    });

    $('#button-lembur').click(function() {
      var unit_kerja_id = $('#unit_kerja_id').val();
      var tgl_pengajuan = $('#tgl_pengajuan').val();

      if(unit_kerja_id == '-- PER UNIT --') {
        unit_kerja_id = "";
      }

      $(this).attr('disabled', true);
      $.ajax({
        type: 'GET',
        url: '{{ url('/')  }}'+'/laporan/lembur/print/'+unit_kerja_id+'/'+tgl_pengajuan,
        xhrFields: {
          responseType: 'blob'
        },
        success: function(response){
          $('#button-lembur').removeAttr('disabled');
        },
        error: function(blob){
          console.log(blob);
        }
      });
    });
  });
</script>
@endpush