<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'unit_kerjas';
    protected $dates = ['created_at', 'updated_at'];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class);
    }

    public function pengajuan_lembur()
    {
        return $this->hasMany(PengajuanLembur::class);
    }
}
