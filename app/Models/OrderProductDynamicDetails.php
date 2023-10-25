<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderProductDynamicDetails extends BaseModel
{
    use HasFactory;

    protected $table = 'order_product_dynamic_details';
    protected $primaryKey = 'id';

    public function related(): MorphTo
    {
        return $this->morphTo(null, 'reference_type', 'reference_id');
    }

    public function order_product_dynamic()
    {
        return $this->BelongsTo(OrderProductDynamic::class, 'order_product_dynamic_id', 'id');
    }
}
