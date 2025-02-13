<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class qc extends Model
{
    use HasFactory;

    protected $table = 'data_weigher';

    protected $fillable = [
        'weigher', 'status',
    ];
}
