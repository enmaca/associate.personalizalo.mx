<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MexState extends Model
{
    use HasFactory;
    protected $table = 'mex_states';
    protected $primaryKey = 'id';
}
