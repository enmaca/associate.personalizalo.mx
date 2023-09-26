<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'catalog_products';
    protected $primaryKey = 'id';

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(DigitalArtCategory::class, 'digital_art_category_id', 'id');
    }

    public function mfg_costs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ManufacturingCost::class, 'catalog_product_id', 'id');
    }
}
