<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'jurusans';
    protected $dates = ['created_at', 'updated_at'];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class);
    }
}
