<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends BaseModel
{
    use HasFactory;
    protected $table = 'catalog_taxes';
    protected $primaryKey = 'id';

    
}
