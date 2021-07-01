<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanLemburDetail extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'pengajuan_lembur_details';
    protected $dates = ['created_at', 'updated_at'];

    public function pengajuan_lembur()
    {
        return $this->belongsTo(PengajuanLembur::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
