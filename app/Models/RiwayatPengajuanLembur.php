<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPengajuanLembur extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'riwayat_pengajuan_lemburs';
    protected $dates = ['created_at', 'updated_at'];

    public function unit_kerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
