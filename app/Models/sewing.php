<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sewing extends Model
{
    use HasFactory;

    protected $table = 'sewing';

    protected $fillable = [
        'status', 
    ];
}
