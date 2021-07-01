<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanCutiDetail extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'pengajuan_cuti_details';
    protected $dates = ['created_at', 'updated_at'];

    public function pengajuan_cuti()
    {
        return $this->belongsTo(PengajuanCuti::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
