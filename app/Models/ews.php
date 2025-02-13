<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ews extends Model
{
    use HasFactory;

    protected $table = 'ews';

    protected $fillable = [
        'status1', 'status2',
    ];
}
