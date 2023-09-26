<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigitalArt extends Model
{
    use HasFactory;

    protected $table = 'digital_art';

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(DigitalArtCategory::class, 'da_category_id', 'id');
    }
}
