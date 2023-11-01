<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderProductDynamic extends BaseModel
{
    use HasFactory;

    protected $table = 'order_product_dynamic';
    protected $primaryKey = 'id';

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderProductDynamicDetails::class, 'order_product_dynamic_id', 'id');
    }

    public function order(){
        return $this->BelongsTo(Order::class, 'order_id', 'id');
    }
}
