<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiDictionary extends Model
{
    use HasFactory;

    protected $fillable = [
        'word',
        'ex',
        'status'
    ];
}
