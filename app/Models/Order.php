<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends BaseModel
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'id';

    public static function CreateToCustomer($customer_id): Order
    {
        $newOrder = new self();
        $newOrder->customer_id = $customer_id;
        // Generate Random Order Code
        $order_date_part = date('Ym');
        $order_six_digit_hex = bin2hex(random_bytes(3));  // 3 bytes = 6 hex digits
        // Combine the parts with hyphens
        $newOrder->code = strtoupper("{$order_date_part}-{$order_six_digit_hex}");
        $newOrder->save();
        return $newOrder;
    }
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