<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintVariationsGroup extends BaseModel
{
    use HasFactory;
    protected $table = 'print_variations_group';
    protected $primaryKey = 'id';

    public function items()
    {
        return $this->hasMany(PrintVariationsGroupDetails::class, 'pvg_id');
    }
}
