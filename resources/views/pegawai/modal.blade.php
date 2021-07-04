<div class="modal fade" id="addUtamaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="form-tambah-edit" name="form-tambah-edit">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pegawai</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="id">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <input name="nik" id="nik" class="form-control" placeholder="NIK">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <input name="nip" id="nip" class="form-control" placeholder="NIP">
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-sm-6">
            <div class="form-group">
              <input name="nama_pegawai" id="nama_pegawai" class="form-control" placeholder="Nama Pegawai">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <input name="tmp_lahir" id="tmp_lahir" class="form-control" placeholder="Tempat Lahir">
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="input-group date">
                <input name="tgl_lahir" id="tgl_lahir" class="form-control" placeholder="Tgl Lahir">
                <span class="input-group-addon">
                  <i class="material-icons">calendar_today</i>
                </span>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <input name="no_hp" id="no_hp" class="form-control" placeholder="No HP">
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-sm-12">
            <div class="form-group">
              <textarea class="form-control" name="alamat" id="alamat" placeholder="Alamat"></textarea>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-sm-4">
            <div class="form-group">
              <select name="unit_kerja_id" id="unit_kerja_id" class="form-control">
                <option>-- UNIT --</option>
                @foreach ($unit_kerjas as $item)
                  <option value="{{ $item->id }}">{{ $item->nama_unit }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <select name="penempatan_id" id="penempatan_id" class="form-control">
                <option>-- PENEMPATAN --</option>
                @foreach ($penempatans as $item)
                  <option value="{{ $item->id }}">{{ $item->nama_penempatan }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <select name="jabatan_id" id="jabatan_id" class="form-control">
                <option>-- JABATAN --</option>
                @foreach ($jabatans as $item)
                  <option value="{{ $item->id }}">{{ $item->nama_jabatan }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-sm-4">
            <div class="form-group">
              <select name="pendidikan_id" id="pendidikan_id" class="form-control">
                <option>-- PENDIDIKAN --</option>
                @foreach ($pendidikans as $item)
                  <option value="{{ $item->id }}">{{ $item->nama_pendidikan }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <select name="jurusan_id" id="jurusan_id" class="form-control">
                <option>-- JURUSAN --</option>
                @foreach ($jurusans as $item)
                  <option value="{{ $item->id }}">{{ $item->nama_jurusan }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <select name="status_pegawai_id" id="status_pegawai_id" class="form-control">
                <option>-- STATUS PEGAWAI --</option>
                @foreach ($status_pegawais as $item)
                  <option value="{{ $item->id }}">{{ $item->nama_status }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        @if (auth()->user()->is_admin == 1)    
        <div class="row mt-3">
          <div class="col-sm-12">
            <div class="form-group">
              <select name="user_id" id="user_id" class="form-control">
                <option>-- USER --</option>
                @foreach ($users as $item)
                  <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-sm btn-success" id="tombol-simpan" value="create">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteUtamaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Hapus User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Apakah Anda Yakin Akan di Hapus?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" name="tombol-utama-hapus" id="tombol-utama-hapus" class="btn btn-danger">Hapus</button>
      </div>
    </div>
  </div>
</div>