<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderProductDetailsDigitalArt extends BaseModel
{

    use HasFactory;

    protected $table = 'order_product_details_digital_art';
    protected $primaryKey = 'id';
    protected $fillable = [
        'opd_id',
        'mvg_selected_color',
        'mvg_selected_size',
        'mvg_id',
        'digital_art_category_id',
        'digital_art_id',
        'print_variation_group_id',
        'print_variation_group_detail_id',
        'material_id'
    ];

    public function order_product_details(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(OrderProductDetail::class, 'opd_id', 'id');
    }

    public function material_variation_group(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(MaterialVariationsGroup::class, 'mvg_id', 'id');
    }

    public function material(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(Material::class, 'material_id', 'id');
    }

    public function digital_art_category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(DigitalArtCategory::class, 'digital_art_category_id', 'id');
    }

    public function digital_art(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(DigitalArt::class, 'digital_art_id', 'id');
    }

    public function print_variation_group(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(PrintVariationsGroup::class, 'print_variation_group_id', 'id');
    }
    public function print_variation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(PrintVariationsGroupDetails::class, 'print_variation_group_detail_id', 'id');
    }
}
