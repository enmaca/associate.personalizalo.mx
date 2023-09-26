<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufacturingCost extends Model
{
    use HasFactory;

    protected $table = 'mfg_costs';

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(Product::class, 'catalog_product_id', 'id');
    }
}
