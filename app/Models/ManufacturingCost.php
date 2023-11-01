<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ManufacturingCost extends Model
{
    use HasFactory;

    protected $table = 'mfg_costs';

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(Product::class, 'catalog_product_id', 'id');
    }

    // 'catalog_materials','catalog_labor_costs','mfg_overhead','material_variations_group','print_variations_group'
    public function related(): MorphTo
    {
        return $this->morphTo(null, 'cost_type', 'cost_type_id');
    }
}
