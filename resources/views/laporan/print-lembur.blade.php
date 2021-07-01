<!DOCTYPE html>
<html>
<head>
	<title>PERINTAH LEMBUR</title>
	{{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}
  <style>
    /* Center tables for demo */
    table {
      margin: 0 auto;
    }

    /* Default Table Style */
    table {
      color: #333;
      width: 100%;
      background: white;
      border: 1px solid grey;
      font-size: 12pt;
      border-collapse: collapse;
    }
    table thead th,
    table tfoot th {
      color: #777;
      background: rgba(0,0,0,.1);
    }
    table caption {
      padding:.5em;
    }
    table th,
    table td {
      padding: .5em;
      border: 1px solid lightgrey;
    }
    /* Zebra Table Style */
    [data-table-theme*=zebra] tbody tr:nth-of-type(odd) {
      background: rgba(0,0,0,.05);
    }
    [data-table-theme*=zebra][data-table-theme*=dark] tbody tr:nth-of-type(odd) {
      background: rgba(255,255,255,.05);
    }
    /* Dark Style */
    [data-table-theme*=dark] {
      color: #ddd;
      background: #333;
      font-size: 12pt;
      border-collapse: collapse;
    }
    [data-table-theme*=dark] thead th,
    [data-table-theme*=dark] tfoot th {
      color: #aaa;
      background: rgba(0255,255,255,.15);
    }
    [data-table-theme*=dark] caption {
      padding:.5em;
    }
    [data-table-theme*=dark] th,
    [data-table-theme*=dark] td {
      padding: .5em;
      border: 1px solid grey;
    }
  </style>
</head>
<body>
  <h4 class="text-center">LAPORAN PERINTAH LEMBUR</h4>
  <table class="table table-sm table-bordered">
    <thead>
      <tr>
        <th>NO</th>
        <th>Kode</th>
        <th>Tgl Pengajuan</th>
        <th>Divisi</th>
        <th>Pegawai</th>
        <th>Jenis Pekerjaan</th>
        <th>Waktu Lembur</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($pengajuan_lembur as $item)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $item->kode_pengajuan }}</td>
          <td>{{ $item->tgl_pengajuan }}</td>
          <td>{{ $item->unit_kerja->nama_unit }}</td>
          <td>
            @foreach ($detail as $d)
              @if ($d->pengajuan_lembur_id == $item->id)
                {{ $d->pegawai->nama_pegawai }},
              @endif
            @endforeach
          </td>
          <td>{{ $item->pengajuan_lembur_detail[0]->jenis_pekerjaan }}</td>
          <td>{{ $item->pengajuan_lembur_detail[0]->jam_mulai." / ".$item->pengajuan_lembur_detail[0]->jam_selesai }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>