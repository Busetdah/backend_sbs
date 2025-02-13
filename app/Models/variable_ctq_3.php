<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class variable_ctq_3 extends Model
{
    use HasFactory;

    protected $table = 'variable_ctq_3';

    protected $fillable = [
        'status', 'value', 'onspec', 'offspec'
    ];
}
