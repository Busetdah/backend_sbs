<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class monitoring_room extends Model
{
    use HasFactory;

    protected $table = 'temphumd_sekitar';

    protected $fillable = [
        'temp', 'humd'
    ];
}
