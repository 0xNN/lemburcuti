@extends('layouts.app', ['activePage' => 'pengajuan-cuti', 'titlePage' => __('Pengajuan Cuti')])

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
    @if (Session::has('failed'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ Session::get('failed') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif
    @if ($pengajuan_cuti != null && $pengajuan_cuti->tgl_selesai_cuti > date('Y-m-d'))
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title">{{ __('Cuti') }}</h4>
        <p class="card-category">{{ __('Form Pengajuan Cuti') }}</p>
      </div>
      <div class="card-body">
        <div class="alert alert-danger">
          Anda memiliki pengajuan cuti <strong>{{ $pengajuan_cuti->kode_pengajuan }}</strong>, (Durasi cuti : {{ $pengajuan_cuti->tgl_mulai_cuti }} - {{ $pengajuan_cuti->tgl_selesai_cuti }}!
          <p></p>
        </div>
      </div>
    </div>
    @else
      @if ($sisa_cuti != null && $sisa_cuti->sisa_cuti == 0)
      <div class="card">
        <div class="card-header card-header-primary">
          <h4 class="card-title">{{ __('Cuti') }}</h4>
          <p class="card-category">{{ __('Form Pengajuan Cuti') }}</p>
          <p><small>Sisa Cuti : {{ ($sisa_cuti == null) ? $maksimum_cuti->total_maksimum : $sisa_cuti->sisa_cuti }}</small></p>
        </div>
        <div class="card-body">
          <div class="alert alert-danger">
            Kuota Cuti anda telah habis.
            <p></p>
          </div>
        </div>
      </div>
      @else
        @if ($pengajuan_cuti != null && $sisa_cuti->tgl_selesai_cuti > date('Y-m-d'))
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">{{ __('Cuti') }}</h4>
            <p class="card-category">{{ __('Form Pengajuan Cuti') }}</p>
          </div>
          <div class="card-body">
            <div class="alert alert-danger">
              Anda belum bisa mengajukan cuti!
              <p></p>
            </div>
          </div>
        </div>
        @else
        <form action="{{ route('pengajuan_cuti.store') }}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="card ">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">{{ __('Cuti') }}</h4>
                  <p class="card-category">{{ __('Form Pengajuan Cuti') }} </p>
                  <p><small>Sisa Cuti : {{ ($sisa_cuti == null) ? $maksimum_cuti->total_maksimum : $sisa_cuti->sisa_cuti }}</small></p>
                </div>
                <div class="card-body">
                  <input type="hidden" name="id" id="id">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <select name="rencana_cuti_id" id="rencana_cuti_id" class="form-control">
                          <option>-- PILIH RENCANA CUTI</option>
                          @foreach ($rencana_cuti as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_rencana }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-3">
                      <div class="form-group">
                        <input type="hidden" name="pegawai_id" id="pegawai_id" value="{{ $pegawai->id }}">
                        <input type="text" name="nama_pegawai" id="nama_pegawai" class="form-control" value="{{ $pegawai->nama_pegawai }}" readonly>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <input type="hidden" name="unit_kerja_id" id="unit_kerja_id" value="{{ $pegawai->unit_kerja->id }}">
                        <input type="text" name="nama_unit" id="nama_unit" class="form-control" value="{{ $pegawai->unit_kerja->nama_unit }}" readonly>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <div class="input-group date">
                          <input name="tgl_mulai_dinas" id="tgl_mulai_dinas" class="form-control" placeholder="Tgl Mulai Dinas">
                          <span class="input-group-addon">
                            <i class="material-icons">calendar_today</i>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <select name="bank_legacy_id" id="bank_legacy_id" class="form-control">
                          <option>-- PILIH BANK LEGACY --</option>
                          @foreach ($bank_legacies as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_bank_legacy }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-3">
                      <div class="form-group">
                        <select name="jenis_cuti_id" id="jenis_cuti_id" class="form-control">
                          <option>-- PILIH JENIS CUTI</option>
                          @foreach ($jenis_cutis as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_jenis }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <div class="input-group date">
                          <input name="tgl_mulai_cuti" id="tgl_mulai_cuti" class="form-control" placeholder="Tgl Mulai Cuti">
                          <span class="input-group-addon">
                            <i class="material-icons">calendar_today</i>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <div class="input-group date">
                          <input name="tgl_selesai_cuti" id="tgl_selesai_cuti" class="form-control" placeholder="Tgl Selesai Cuti">
                          <span class="input-group-addon">
                            <i class="material-icons">calendar_today</i>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <input type="text" name="no_hp_selama_cuti" id="no_hp_selama_cuti" class="form-control" placeholder="No HP Selama Cuti">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <textarea name="alamat_lengkap_selama_cuti" id="alamat_lengkap_selama_cuti" class="form-control" placeholder="Alamat Lengkap Selama Cuti"></textarea>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan"></textarea>
                      </div>
                    </div>
                  </div>
                  <small>Keterangan Extra</small>
                  <div class="row">
                    <div class="col-sm-3">
                      <div class="form-group">
                        <select name="jenis_cuti_extra_id" id="jenis_extra_cuti_id" class="form-control">
                          <option>-- PILIH JENIS CUTI EXTRA</option>
                          @foreach ($jenis_cuti_extras as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_jenis_extra }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <div class="input-group date">
                          <input name="tgl_mulai_extra_cuti" id="tgl_mulai_extra_cuti" class="form-control" placeholder="Tgl Mulai Extra Cuti">
                          <span class="input-group-addon">
                            <i class="material-icons">calendar_today</i>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <input type="text" name="no_hp_extra_selama_cuti" id="no_hp_extra_selama_cuti" class="form-control" placeholder="No HP Extra Selama Cuti">
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <div class="input-group date">
                          <input name="tgl_pengajuan" id="tgl_pengajuan" class="form-control" value="{{ date('Y-m-d') }}" readonly>
                          <span class="input-group-addon">
                            <i class="material-icons">calendar_today</i>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <textarea name="alamat_lengkap_extra_selama_cuti" id="alamat_lengkap_extra_selama_cuti" class="form-control" placeholder="Alamat Lengkap Extra Selama Cuti"></textarea>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <textarea name="keterangan_extra" id="keterangan_extra" class="form-control" placeholder="Keterangan Extra"></textarea>
                      </div>
                    </div>
                  </div>
                  <small>Pegawai yang menggantikan</small>
                  <div class="row">
                    <div class="col-sm-12">
                      <select class="form-control" name="pegawai_pengganti_id[]" id="pegawai_pengganti_id" multiple="multiple" style="width: 100%">
                        <option>-- Pegawai --</option>
                        @foreach ($pegawai_pengganti as $item)
                          <option value="{{ $item->id }}">{{ $item->nama_pegawai }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="card-footer ml-auto mr-auto">
                  <button type="submit" class="btn btn-block btn-primary">Simpan</button>
                </div>
              </div>
            </div>
          </div>
        </form>
        @endif
      @endif
    @endif
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
    $('#tgl_mulai_dinas').bootstrapMaterialDatePicker({
      format: 'YYYY-MM-DD',
      time: false,
    });

    $('#tgl_mulai_cuti').bootstrapMaterialDatePicker({
      format: 'YYYY-MM-DD',
      time: false,
      minDate: new Date(),
    });

    $('#tgl_selesai_cuti').bootstrapMaterialDatePicker({
      format: 'YYYY-MM-DD',
      time: false,
      minDate: new Date(),
    });

    $('#tgl_mulai_extra_cuti').bootstrapMaterialDatePicker({
      format: 'YYYY-MM-DD',
      time: false,
      minDate: new Date(),
    });

    $('#pegawai_pengganti_id').select2();
  });
</script>
@endpush