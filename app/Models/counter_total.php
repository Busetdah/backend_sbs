<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class counter_total extends Model
{
    use HasFactory;

    protected $table = 'counter_total';

    protected $fillable = [
        'countertotal', 'performance',
    ];
}
