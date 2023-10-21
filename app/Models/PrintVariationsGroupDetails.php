<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintVariationsGroupDetails extends BaseModel
{
    use HasFactory;
    protected $table = 'print_variations_group_detail';
    protected $primaryKey = 'id';

    public function pvg()
    {
        return $this->belongsTo(PrintVariationsGroup::class, 'pvg_id');
    }
}
