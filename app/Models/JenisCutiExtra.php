<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisCutiExtra extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'jenis_cuti_extras';
    protected $dates = ['created_at', 'updated_at'];
}
