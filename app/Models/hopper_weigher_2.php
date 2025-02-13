<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hopper_weigher_2 extends Model
{
    use HasFactory;

    protected $table = 'lpvsvweigher2';

    protected $fillable = [
        'lpvweigher2', 'svweigher2',
    ];
}
