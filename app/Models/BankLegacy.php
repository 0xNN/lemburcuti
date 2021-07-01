<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankLegacy extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'bank_legacies';
    protected $dates = ['created_at', 'updated_at'];
}
