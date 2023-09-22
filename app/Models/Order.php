<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'customer_id',
        'price',
        'taxes',
        'delivery_fee',
        'shipment_status',
        'shipment_received_at',
    ];

    /**
     * @var array
     */
    protected $allowedFilters = [
        'id' => Where::class,
    ];

    /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'code',
        'customer_id',
    ];

    public function details(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderProductDetail::class, 'order_id', 'id');
    }

    public function customer(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function payments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderPayment::class, 'order_id', 'id');
    }

    public function address_book(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(AddressBook::class, 'id', 'address_book_id');
    }
}
