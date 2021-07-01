<form action="{{ route('pegawai.update', ['pegawai'=> auth()->user()->id]) }}" method="POST">
  @csrf
  @method('PUT')
  @if (count($errors) > 0)
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
  @endif  
  <input type="hidden" name="id" id="id" value="{{ ($pegawai == null) ? '' : $pegawai->id }}">
  <div class="row">
    <div class="col-sm-6">
      <div class="form-group">
        <input name="nik" id="nik" class="form-control" placeholder="NIK" value="{{ ($pegawai == null) ? '' : $pegawai->nik }}">
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group">
        <input name="nip" id="nip" class="form-control" placeholder="NIP" value="{{ ($pegawai == null) ? '' : $pegawai->nip }}">
      </div>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-sm-6">
      <div class="form-group">
        <input name="nama_pegawai" id="nama_pegawai" class="form-control" placeholder="Nama Pegawai" value="{{ ($pegawai == null) ? '' : $pegawai->nama_pegawai }}">
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group">
        <input name="tmp_lahir" id="tmp_lahir" class="form-control" placeholder="Tempat Lahir" value="{{ ($pegawai == null) ? '' : $pegawai->tmp_lahir }}">
      </div>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-sm-6">
      <div class="form-group">
        <div class="input-group date">
          <input name="tgl_lahir" id="tgl_lahir" class="form-control" placeholder="Tgl Lahir" value="{{ ($pegawai == null) ? '' : $pegawai->tgl_lahir }}">
          <span class="input-group-addon">
            <i class="material-icons">calendar_today</i>
          </span>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group">
        <input name="no_hp" id="no_hp" class="form-control" placeholder="No HP" value="{{ ($pegawai == null) ? '' : $pegawai->no_hp }}">
      </div>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-sm-12">
      <div class="form-group">
        <textarea class="form-control" name="alamat" id="alamat" placeholder="Alamat">{{ ($pegawai == null) ? '' : $pegawai->alamat }}</textarea>
      </div>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-sm-4">
      <div class="form-group">
        <select name="unit_kerja_id" id="unit_kerja_id" class="form-control">
          <option>-- UNIT --</option>
          @foreach ($unit_kerjas as $item)
            <option value="{{ $item->id }}" 
              @if ($pegawai != null)
                @if ($item->id == $pegawai->unit_kerja_id)
                  selected
                @endif
              @endif >{{ $item->nama_unit }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
        <select name="penempatan_id" id="penempatan_id" class="form-control">
          <option>-- PENEMPATAN --</option>
          @foreach ($penempatans as $item)
            <option value="{{ $item->id }}" 
              @if ($pegawai != null)
                @if ($item->id == $pegawai->penempatan_id)
                  selected
                @endif
              @endif >{{ $item->nama_penempatan }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
        <select name="jabatan_id" id="jabatan_id" class="form-control">
          <option>-- JABATAN --</option>
          @foreach ($jabatans as $item)
            <option value="{{ $item->id }}" 
              @if ($pegawai != null)
                @if ($item->id == $pegawai->jabatan_id)
                  selected
                @endif
              @endif >{{ $item->nama_jabatan }}</option>
          @endforeach
        </select>
      </div>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-sm-6">
      <div class="form-group">
        <select name="pendidikan_id" id="pendidikan_id" class="form-control">
          <option>-- PENDIDIKAN --</option>
          @foreach ($pendidikans as $item)
            <option value="{{ $item->id }}" @if ($pegawai != null)
              @if ($item->id == $pegawai->pendidikan_id)
                selected
              @endif
            @endif >{{ $item->nama_pendidikan }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group">
        <select name="jurusan_id" id="jurusan_id" class="form-control">
          <option>-- JURUSAN --</option>
          @foreach ($jurusans as $item)
            <option value="{{ $item->id }}" 
              @if ($pegawai != null)
                @if ($item->id == $pegawai->jurusan_id)
                  selected
                @endif
              @endif >{{ $item->nama_jurusan }}</option>
          @endforeach
        </select>
      </div>
    </div>
  </div>
  <button type="submit" class="btn btn-sm btn-success" id="tombol-simpan" value="create">Simpan</button>
</form>