<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{

    use HasFactory;
    protected $fillable = [
    'user_id',
    'customer_name',
    'customer_email',
    'customer_phone',
    'shipping_address',
    'city',
    'postal_code',
    'payment_method',
    'total_amount',
    'status',
];
public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}

