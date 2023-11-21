<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Validation\Rule;

class OrderProductDynamic extends BaseModel
{
    use HasFactory;

    protected $table = 'order_product_dynamic';
    protected $primaryKey = 'id';

    protected $fillable = [
        'mfg_status',
        'mfg_media_id_needed',
        'mfg_device_id',
        'mfg_media_instructions'
    ];

    /**
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderProductDynamicDetails::class, 'order_product_dynamic_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->BelongsTo(Order::class, 'order_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function mfg_area(): BelongsTo
    {
        return $this->BelongsTo(MfgArea::class, 'mfg_area_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function mfg_device(): BelongsTo
    {
        return $this->BelongsTo(MfgDevice::class, 'mfg_device_id', 'id');
    }

    /**
     * @return MorphMany
     */
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'related');
    }

    /**
     * @return array
     */
    public static function getValidationRules(): array
    {
        return $validateRules = [
            'mfg_status' => Rule::in(['not_needed', 'ready', 'pending']),
            'mfg_media_id_needed' => Rule::in(['yes', 'no']),
            'mfg_device_id' => 'integer',
            'mfg_media_instructions' => 'string'
        ];
    }
}
