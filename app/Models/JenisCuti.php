<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisCuti extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'jenis_cutis';
    protected $dates = ['created_at', 'updated_at'];
}
