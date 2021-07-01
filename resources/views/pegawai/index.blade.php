@extends('layouts.app', ['activePage' => 'pegawai', 'titlePage' => __('Pegawai')])

@section('content')
  @include('pegawai.modal')
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
          <div class="card ">
            <div class="card-header card-header-primary">
              <h4 class="card-title">{{ __('Pegawai') }}</h4>
              @if (auth()->user()->is_admin == 1)
              <p class="card-category">{{ __('Daftar Pegawai') }}</p>
              <a href="javascript:void(0)" class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm" id="tombol-utama">
                <i class="material-icons">add</i>
              </a>
              @endif
            </div>
            <div class="card-body ">
              @if (auth()->user()->is_admin == 1)                
              <table id="dt-pegawai" class="table table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No Hp</th>
                    <th>Unit Kerja</th>
                    <th>Pendidikan</th>
                    <th>Jabatan</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
              @else
              @include('pegawai.form')
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
@endpush
@push('js')
  <script src="{{ asset('material/js/bootstrap-material-datetimepicker.js') }}"></script>
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
      $('#tgl_lahir').bootstrapMaterialDatePicker({
        format: 'YYYY-MM-DD',
        time: false,
      });

      var is_admin = "{{ auth()->user()->is_admin }}";
      console.log(is_admin);

      var table = $('#dt-pegawai').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('pegawai.index') }}",
        columns: [
          {data: 'id', name: 'id'},
          {data: 'nip', name: 'nip'},
          {data: 'nama_pegawai', name: 'nama_pegawai'},
          {data: 'alamat', name: 'alamat'},
          {data: 'no_hp', name: 'no_hp'},
          {data: 'unit_kerja_id', name: 'unit_kerja_id'},
          {data: 'pendidikan_id', name: 'pendidikan_id'},
          {data: 'jabatan_id', name: 'jabatan_id'},
          {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs: [ {
            className: 'dtr-control',
            orderable: false,
            targets:   0
        } ],
        order: [ 1, 'asc' ]
      });

      $('#tombol-utama').click(function () {
        $.ajax({
            url: '{{ route("pegawai.populate_user")}}',
            type: 'get',
            success:function(response){

                var len = response.length;

                $("select#user_id").empty();
                $("select#user_id").append("<option>-- USER --</option>");
                for(var i=0; i<len; i++) {
                  $("select#user_id").append("<option value='"+response[i].id+"'>"+response[i].name+"</option>");
                }

            }
        });
        $('#button-simpan').val("create-post"); //valuenya menjadi create-post
        $('#id').val(''); //valuenya menjadi kosong
        $('#form-tambah-edit').trigger("reset"); //mereset semua input dll didalamnya
        $('#modal-judul').html("Tambah Pegawai Baru"); //valuenya tambah pegawai baru
        $('#addUtamaModal').modal('show'); //modal tampil

      });

      if ($("#form-tambah-edit").length > 0) {
        $("#form-tambah-edit").validate({
            submitHandler: function (form) {
                var actionType = $('#tombol-simpan').val();
                $('#tombol-simpan').html('Sending..');
                $.ajax({
                    data: $('#form-tambah-edit')
                        .serialize(), //function yang dipakai agar value pada form-control seperti input, textarea, select dll dapat digunakan pada URL query string ketika melakukan ajax request
                    url: "{{ route('pegawai.store') }}", //url simpan data
                    type: "POST", //karena simpan kita pakai method POST
                    dataType: 'json', //data tipe kita kirim berupa JSON
                    success: function (data) { //jika berhasil
                        $('#form-tambah-edit').trigger("reset"); //form reset
                        $('#addUtamaModal').modal('hide'); //modal hide
                        $('#tombol-simpan').html('Simpan'); //tombol simpan
                        var oTable = $('#dt-pegawai').dataTable(); //inialisasi datatable
                        oTable.fnDraw(false); //reset datatable
                        iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                            title: 'Data Berhasil Disimpan',
                            message: 'Successfully',
                            position: 'bottomRight'
                        });
                        location.reload(true);
                    },
                    error: function (data) { //jika error tampilkan error pada console
                        console.log('Error:', data);
                        $('#tombol-simpan').html('Simpan');
                    }
                });
            }
        })
      }

      $('body').on('click', '.edit-post', function () {
        var data_id = $(this).data('id');
        $.get('pegawai/' + data_id + '/edit', function (data) {
          $('#modal-judul').html("Edit Post");
          $('#tombol-simpan').val("edit-post");
          $('#addUtamaModal').modal('show');
          //set value masing-masing id berdasarkan data yg diperoleh dari ajax get request diatas
          $('#id').val(data.id);
          $('#nik').val(data.nik);
          $('#nip').val(data.nip);
          $('#nama_pegawai').val(data.nama_pegawai);
          $('#tmp_lahir').val(data.tmp_lahir);
          $('#tgl_lahir').val(data.tgl_lahir);
          $('#alamat').text(data.alamat);
          $('#no_hp').val(data.no_hp);
          $(`select#unit_kerja_id option[value='${data.unit_kerja_id}']`).attr('selected','selected');
          $(`select#pendidikan_id option[value='${data.pendidikan_id}']`).attr('selected','selected');
          $(`select#jabatan_id option[value='${data.jabatan_id}']`).attr('selected','selected');
          $(`select#jurusan_id option[value='${data.jurusan_id}']`).attr('selected','selected');
          $(`select#penempatan_id option[value='${data.penempatan_id}']`).attr('selected','selected');
          $('select#user_id').append(`<option value="${data.user_id}" selected>${data.name}</option>`);
        })
      });

      $(document).on('click', '.delete', function () {
        dataId = $(this).attr('id');
        $('#deleteUtamaModal').modal('show');
      });

      $('#tombol-utama-hapus').click(function () {
        var url = "{{ route('pegawai.destroy', ":dataId") }}";
        url = url.replace(':dataId', dataId);
        $.ajax({
          url: url, //eksekusi ajax ke url ini
          type: 'delete',
          beforeSend: function () {
            $('#tombol-utama-hapus').text('Hapus Data'); //set text untuk tombol hapus
          },
          success: function (data) { //jika sukses
            setTimeout(function () {
              $('#deleteUtamaModal').modal('hide'); //sembunyikan konfirmasi modal
              var oTable = $('#utama').dataTable();
              oTable.fnDraw(false); //reset datatable
            });
            iziToast.warning({ //tampilkan izitoast warning
              title: 'Data Berhasil Dihapus',
              message: '{{ Session('
              delete ')}}',
              position: 'bottomRight'
            });
          }
        })
      });
    })
  </script>
@endpush