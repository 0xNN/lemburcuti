<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanCuti extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'pengajuan_cutis';
    protected $dates = ['created_at', 'updated_at'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function unit_kerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }

    public function jenis_cuti()
    {
        return $this->belongsTo(JenisCuti::class);
    }

    public function jenis_cuti_extra()
    {
        return $this->belongsTo(JenisCutiExtra::class);
    }

    public function bank_legacy()
    {
        return $this->belongsTo(BankLegacy::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pengajuan_cuti_detail()
    {
        return $this->hasMany(PengajuanCutiDetail::class);
    }

    public function maksimum_cuti()
    {
        return $this->belongsTo(MaksimumCuti::class);
    }

    public function rencana_cuti()
    {
        return $this->belongsTo(RencanaCuti::class);
    }
}
