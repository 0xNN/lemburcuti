<!DOCTYPE html>
<html>
<head>
	<title>CUTI</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body onload="window.print()">
  <div class="container">
    <div class="text-right">
      <img width="210px" height="60px" src="{{ asset('material') }}/img/logo_bsi.png" alt="bsi logo">
    </div>
    <br />
    <h4 class="text-center">PERMOHONAN CUTI</h4>
    <div class="row">
      <div class="col-sm-3">
        <p>Hari / Tanggal Pengajuan</p>
      </div>
      <div class="col-sm-9">
        <p>: {{ $hari }}, {{ $tanggal }}</p>
      </div>
    </div>
    <small>Data Pegawai</small>
    <table class="table table-sm table-bordered">
      <tr>
        <td width="25%">Nama Lengkap / NIP (Legacy)</td>
        <td>{{ $pengajuan_cuti->pegawai->nama_pegawai }} / {{ $pengajuan_cuti->pegawai->nip }}</td>
      </tr>
      <tr>
        <td width="25%">Jabatan</td>
        <td>{{ $pengajuan_cuti->pegawai->jabatan->nama_jabatan }}</td>
      </tr>
      <tr>
        <td width="25%">Divisi / Unit Kerja</td>
        <td>{{ $pengajuan_cuti->pegawai->unit_kerja->nama_unit }}</td>
      </tr>
      <tr>
        <td width="25%">Mulai Dinas di BSI</td>
        <td>{{ $pengajuan_cuti->tgl_mulai_dinas }}</td>
      </tr>
      <tr>
        <td width="25%">Bank Legacy</td>
        <td>{{ $pengajuan_cuti->bank_legacy->nama_bank_legacy }}</td>
      </tr>
    </table>
    <small>Keterangan Cuti</small>
    <table class="table table-sm table-bordered">
      <tr>
        <td width="30%">Jenis Cuti yang Diminta</td>
        <td>{{ $pengajuan_cuti->jenis_cuti->nama_jenis }}</td>
      </tr>
      <tr>
        <td width="30%">Pilihan Rencana Cuti</td>
        <td>{{ $pengajuan_cuti->rencana_cuti->nama_rencana }}</td>
      </tr>
      <tr>
        <td width="30%">Lama Cuti / Tgl mulai s.d</td>
        <td>{{ $pengajuan_cuti->tgl_mulai_cuti }} - {{ $pengajuan_cuti->tgl_selesai_cuti }} ({{ $pengajuan_cuti->total_hari }} hari)</td>
      </tr>
      <tr>
        <td width="30%">Alamat Lengkap & No Telp Selama Cuti</td>
        <td>{{ $pengajuan_cuti->alamat_lengkap_selama_cuti }} / {{ $pengajuan_cuti->no_hp_selama_cuti }}</td>
      </tr>
      <tr>
        <td width="30%">Keterangan Lain dari Pemohon</td>
        <td>{{ $pengajuan_cuti->keterangan }}</td>
      </tr>
    </table>
    <small>Keterangan Cuti Extra</small>
    <table class="table table-sm table-bordered">
      <tr>
        <td width="30%">Jenis Cuti yang Diminta</td>
        <td>{{ $pengajuan_cuti->jenis_cuti_extra->nama_jenis }}</td>
      </tr>
      <tr>
        <td width="30%">Tgl mulai</td>
        <td>{{ $pengajuan_cuti->tgl_mulai_extra_cuti }}</td>
      </tr>
      <tr>
        <td width="30%">Alamat Lengkap & No Telp Selama Cuti</td>
        <td>{{ $pengajuan_cuti->alamat_lengkap_extra_selama_cuti }} / {{ $pengajuan_cuti->no_hp_extra_selama_cuti }}</td>
      </tr>
      <tr>
        <td width="30%">Keterangan Lain dari Pemohon</td>
        <td>{{ $pengajuan_cuti->keterangan_extra }}</td>
      </tr>
    </table>
    <small>Selama Cuti di Jalankan, Tugas Digantikan Oleh</small>
    <table class="table table-sm table-bordered">
      <tr>
        @foreach ($pengajuan_cuti_detail as $item)
          <td>Nama</td>
          <td>{{ $loop->iteration }}. {{ $item->pegawai->nama_pegawai }}</td>
        @endforeach
      </tr>
    </table>
    <br />
    <div class="row">
      <div class="col-sm-4">
        {!! QrCode::size(100)->generate($pengajuan_cuti->kode_pengajuan) !!}
      </div>
    </div>
  </div>
</body>
</html>