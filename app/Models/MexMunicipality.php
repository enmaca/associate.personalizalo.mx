<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MexMunicipality extends Model
{
    use HasFactory;
    protected $table = 'v_mex_municipalities';
    protected $primaryKey = 'id';


    public function state(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(MexState::class, 'state_id', 'id');
    }
}
