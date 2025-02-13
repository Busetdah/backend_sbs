<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hopper_air_pressure extends Model
{
    use HasFactory;

    protected $table = 'data_pressure';

    protected $fillable = [
        'pressure',
    ];
}
