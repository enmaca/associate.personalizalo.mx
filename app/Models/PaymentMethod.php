<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentMethod extends BaseModel
{
    use HasFactory;
    protected $table = 'payment_methods';
    protected $primaryKey = 'id';
}
