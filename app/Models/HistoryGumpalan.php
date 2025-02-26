<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryGumpalan extends Model
{
    use HasFactory;

    protected $table = 'history_gumpalan';
    protected $fillable = ['waktu'];
    public $timestamps = false;
}
