<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    use HasFactory;
    protected $table = 'order_payments';
    protected $primaryKey = 'id';

    public function payment_method(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'id', 'payment_method_id');
    }
}
