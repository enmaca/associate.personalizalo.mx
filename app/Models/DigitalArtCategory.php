<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigitalArtCategory extends BaseModel
{
    use HasFactory;

    protected $table = 'digital_art_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'parent_id',
        'created_at',
        'updated_at',
    ];

    public function arts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DigitalArt::class, 'da_category_id', 'id');
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(DigitalArtCategory::class, 'parent_id', 'id');
    }
}
