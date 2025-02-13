<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hopper_weigher_1 extends Model
{
    use HasFactory;

    protected $table = 'lpvsvweigher1';

    protected $fillable = [
        'lpvweigher1', 'svweigher1',
    ];
}
