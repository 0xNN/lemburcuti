<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'pegawais';
    protected $dates = ['created_at', 'updated_at'];

    public function unit_kerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }

    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class);
    }

    public function penempatan()
    {
        return $this->belongsTo(Penempatan::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function pengajuan_lembur_detail()
    {
        return $this->hasMany(PengajuanLemburDetail::class);
    }

    public function status_pegawai()
    {
        return $this->belongsTo(StatusPegawai::class);
    }

    public function pengajuan_cuti_detail()
    {
        return $this->hasMany(PengajuanCutiDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
