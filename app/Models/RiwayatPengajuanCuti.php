<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPengajuanCuti extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'riwayat_pengajuan_cutis';
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
}
