<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends BaseModel
{
    use HasFactory;

    protected $table = 'media';

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(Product::class, 'catalog_product_id', 'id');
    }

    // 'catalog_products','catalog_materials','sales_lead','order_product_dynamic','order_product'
    public function related(): MorphTo
    {
        return $this->morphTo(null, 'related_type', 'related_id');
    }
}