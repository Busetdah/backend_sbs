<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class variable_ctq extends Model
{
    use HasFactory;

    protected $table = 'variable_ctq';

    protected $fillable = [
        'status', 'value' 
    ];
}
