<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductDetail extends BaseModel
{
    use HasFactory;

    protected $table = 'order_product_details';
    protected $primaryKey = 'id';
    protected $fillable = [
        'order_id',
        'catalog_product_id',
        'quantity',
        'unit_cost',
        'unit_taxes',
        'unit_profit',
        'unit_price',
        'unit_subtotal',
        'cost',
        'taxes',
        'profit',
        'price',
        'subtotal',
        'profit_margin',
        'mfg_media_id_needed',
        'mfg_media_id_exists',
        'created_by'
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::deleting(function ($order_prodcut_detail) {
            $order_prodcut_detail->with_digital_art()->delete();
        });
    }

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

    public function with_digital_art(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->HasOne(OrderProductDetailsDigitalArt::class, 'opd_id', 'id');
    }

    public function createdby(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(User::class, 'created_by', 'id');
    }
}
