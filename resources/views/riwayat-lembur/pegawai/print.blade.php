<!DOCTYPE html>
<html>
<head>
	<title>PERINTAH LEMBUR</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <style type="text/css" media="print">
    @print{
        @page :footer {color: #fff }
        @page :header {color: #fff}
    }
  </style>
</head>
<body onload="window.print()">
    <h4 class="text-center">FORMULIR PERINTAH LEMBUR</h4>
    <div class="row">
      <div class="col-sm-3">
        <p>Departement / Bagian </p>
      </div>
      <div class="col-sm-9">
        <p>: {{ $pengajuan_lembur->unit_kerja->nama_unit }}</p>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-3">
        <p>Hari / Tanggal </p>
      </div>
      <div class="col-sm-9">
        <p>: {{ $hari }}, {{ $tanggal }}</p>
      </div>
    </div>
    <table class="table table-sm table-bordered">
      <thead>
        <tr>
          <th class="text-center align-middle" rowspan="2">NO</th>
          <th class="text-center align-middle" rowspan="2">Nama</th>
          <th class="text-center align-middle" rowspan="2">NIK</th>
          <th class="text-center align-middle" colspan="2">Waktu Lembur</th>
          <th class="text-center align-middle" rowspan="2">Keterangan</th>
        </tr>
        <tr>
          <th class="text-center align-middle">Dari</th>
          <th class="text-center align-middle">Sampai</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($pengajuan_lembur_detail as $item)
          <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td>{{ $item->pegawai->nama_pegawai }}</td>
            <td class="text-center">{{ $item->pegawai->nik }}</td>
            <td class="text-center">{{ $item->jam_mulai }}</td>
            <td class="text-center">{{ $item->jam_selesai }}</td>
            <td>{{ $item->jenis_pekerjaan }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="row">
      <div class="col-sm-4">
        {!! QrCode::size(100)->generate($pengajuan_lembur->kode_pengajuan) !!}
      </div>
    </div>
</body>
</html>