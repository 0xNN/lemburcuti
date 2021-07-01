@extends('layouts.app', ['activePage' => 'unit-kerja', 'titlePage' => __('Unit Kerja')])

@section('content')
@include('unit-kerja.modal')
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
            <h4 class="card-title">{{ __('Unit Kerja') }}</h4>
            <p class="card-category">{{ __('Daftar Unit Kerja') }}</p>
            <a href="javascript:void(0)" class="d-sm-inline-block btn btn-sm btn-secondary shadow-sm" id="tombol-utama">
              <i class="material-icons">add</i>
            </a>
          </div>
          <div class="card-body ">              
            <table id="dt-unit-kerja" class="table table-sm table-striped table-bordered dt-responsive nowrap" style="width:100%">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nama Unit</th>
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
      var table = $('#dt-unit-kerja').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('unit_kerja.index') }}",
        columns: [
          {data: 'id', name: 'id'},
          {data: 'nama_unit', name: 'nama_unit'},
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
                    url: "{{ route('unit_kerja.store') }}", //url simpan data
                    type: "POST", //karena simpan kita pakai method POST
                    dataType: 'json', //data tipe kita kirim berupa JSON
                    success: function (data) { //jika berhasil
                        $('#form-tambah-edit').trigger("reset"); //form reset
                        $('#addUtamaModal').modal('hide'); //modal hide
                        $('#tombol-simpan').html('Simpan'); //tombol simpan
                        var oTable = $('#dt-unit-kerja').dataTable(); //inialisasi datatable
                        oTable.fnDraw(false); //reset datatable
                        iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                            title: 'Data Berhasil Disimpan',
                            message: '{{ Session('success')}}',
                            position: 'bottomRight'
                        });
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
        $.get('unit_kerja/' + data_id + '/edit', function (data) {
          $('#modal-judul').html("Edit Post");
          $('#tombol-simpan').val("edit-post");
          $('#addUtamaModal').modal('show');
          //set value masing-masing id berdasarkan data yg diperoleh dari ajax get request diatas
          $('#id').val(data.id);
          $('#nama_unit').val(data.nama_unit);
        })
      });

      $(document).on('click', '.delete', function () {
        dataId = $(this).attr('id');
        $('#deleteUtamaModal').modal('show');
      });

      $('#tombol-utama-hapus').click(function () {
        var url = "{{ route('unit_kerja.destroy', ":dataId") }}";
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
              var oTable = $('#dt-user').dataTable();
              oTable.fnDraw(false); //reset datatable
            });
            iziToast.warning({ //tampilkan izitoast warning
              title: 'Data Berhasil Dihapus',
              message: '{{ Session('delete') }}',
              position: 'bottomRight'
            });
          }
        })
      });
    })
  </script>
@endpush