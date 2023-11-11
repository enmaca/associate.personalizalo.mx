<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class MexMunicipalities extends BaseModel
{
    use HasFactory;
    protected $table = 'mex_municipalities';
    protected $primaryKey = 'id';


    public function state(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(MexState::class, 'state_id', 'id');
    }
}
