<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
    protected $fillable = [
        'user_id',
        'invoice_code',
        'customer_name',
        'customer_email',
        'customer_whatsapp',
        'customer_address',
        'payment_method_id', // <--- Tambahkan ini
        'total_price',
        'discount_amount',
        'status',
        'proof_of_payment',
    ];
}
