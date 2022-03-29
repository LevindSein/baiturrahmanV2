<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fitrah extends Model
{
    use HasFactory;

    protected $table = 'fitrah';
    protected $fillable = [
        'muzakki',
        'jumlah',
        'admin'
    ];
}
