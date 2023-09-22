<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MexMunicipality extends Model
{
    use HasFactory;
    protected $table = 'mex_municipalities';
    protected $primaryKey = 'id';
}
