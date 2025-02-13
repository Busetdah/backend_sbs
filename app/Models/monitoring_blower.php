<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class monitoring_blower extends Model
{
    use HasFactory;

    protected $table = 'monitoring_blower';

    protected $fillable = [
        'status',
    ];
}
