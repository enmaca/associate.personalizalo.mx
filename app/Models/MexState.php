<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class MexState extends BaseModel
{
    use HasFactory;
    protected $table = 'mex_states';
    protected $primaryKey = 'id';
}
