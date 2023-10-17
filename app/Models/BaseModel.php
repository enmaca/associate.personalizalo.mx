<?php

namespace App\Models;

use Deligoez\LaravelModelHashId\Traits\HasHashId;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasHashId;
}