<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends BaseModel
{
    use HasFactory;
    protected $table = 'payment_methods';
    protected $primaryKey = 'id';

    public function details(): HasMany {
        return $this->hasMany(PaymentDetails::class, 'payment_method_id');
    }

    public function customer(): HasMany {
        return $this->hasMany(Customer::class, 'customer_id');
    }

    public function createdBy(): HasMany {
        return $this->hasMany(User::class, 'created_by');
    }

    public function scopeGeneral($query) {
        return $query->where('account_scope', 'general');
    }

}
