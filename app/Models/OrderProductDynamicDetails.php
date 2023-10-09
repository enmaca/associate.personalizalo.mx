<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductDynamicDetails extends Model
{
    use HasFactory;
    protected $table = 'order_product_dynamic_details';
    protected $primaryKey = 'id';
}
