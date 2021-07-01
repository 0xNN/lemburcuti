<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaksimumCuti extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'maksimum_cutis';
    protected $dates = ['created_at', 'updated_at'];

    public function pengajuan_cuti()
    {
        return $this->hasMany(PengajuanCuti::class);
    }
}
