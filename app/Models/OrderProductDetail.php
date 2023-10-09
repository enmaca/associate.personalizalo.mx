<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductDetail extends Model
{
    use HasFactory;
    protected $table = 'order_product_details';
    protected $primaryKey = 'id';

    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(Order::class, 'order_id', 'id');
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(Product::class, 'catalog_product_id', 'id');
    }

    public function mfg_device(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(MfgDevice::class, 'mfg_device_id', 'id');
    }
}
