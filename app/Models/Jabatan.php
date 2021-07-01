<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'jabatans';
    protected $dates = ['created_at', 'updated_at'];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class);
    }
}
