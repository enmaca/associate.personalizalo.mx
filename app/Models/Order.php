<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'id';

    public function details(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(OrderProductDetail::class, 'order_id', 'id');
    }

    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(Customer::class, 'customer_id', 'id');
    }

    public function payments(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(OrderPayment::class, 'order_id', 'id');
    }

    public function address(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(AddressBook::class, 'address_book_id', 'id');
    }

}