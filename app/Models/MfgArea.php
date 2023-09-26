<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MfgArea extends Model
{
    use HasFactory;

    protected $table = 'mfg_areas';

    protected $fillable = [
        'name',
    ];
}
