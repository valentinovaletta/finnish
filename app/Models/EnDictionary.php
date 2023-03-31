<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnDictionary extends Model
{
    use HasFactory;

    protected $fillable = [
        'word',
        'ts',
        'pos',
        'ex',
        'def',
        'audio',
        'img',
        'status'
    ];
}
