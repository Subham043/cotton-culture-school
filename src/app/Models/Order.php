<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'total_amount',
        'receipt',
        'mode_of_payment',
        'order_status',
        'payment_status',
        'razorpay_signature',
        'razorpay_order_id',
        'razorpay_payment_id',
        'placed_at',
        'packed_at',
        'shipped_at',
        'ofd_at',
        'delivered_at',
        'cancelled_at',
        'address_id',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'placed_at' => 'datetime',
        'packed_at' => 'datetime',
        'shipped_at' => 'datetime',
        'ofd_at' => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'mode_of_payment' => PaymentMode::class,
        'order_status' => OrderStatus::class,
        'payment_status' => PaymentStatus::class,
    ];

    protected $attributes = [
        'mode_of_payment' => PaymentMode::COD,
        'order_status' => OrderStatus::PLACED,
        'payment_status' => PaymentStatus::PENDING,
    ];

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function orderItems()
    {
        return $this->hasMany(OrderUnit::class, 'order_id');
    }
}
