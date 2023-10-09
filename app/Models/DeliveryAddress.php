<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    use HasFactory;

    protected $table = 'delivery_addresses';

    protected $fillable = [
        'client_id',
        'address',
        'short_name',
        'address_line_1',
        'address_line_2',
        'postal_code',
        'city',
        'state',
        'google_maps_data',
        'created_by',
    ];
}
