<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calculation extends Model
{
    protected $fillable = ['anon_id', 'data'];

    protected $casts = [
        'data' => 'array',
    ];
}

