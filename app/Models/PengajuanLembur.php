<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanLembur extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    protected $table = 'pengajuan_lemburs';
    protected $dates = ['created_at', 'updated_at'];

    public function unit_kerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }

    public function pengajuan_lembur_detail()
    {
        return $this->hasMany(PengajuanLemburDetail::class);
    }
}
