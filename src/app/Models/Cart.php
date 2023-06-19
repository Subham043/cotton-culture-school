<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';

    protected $fillable = [
        'units',
        'quantity',
        'product_id',
        'user_id',
        'kid_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = ['cart_quantity_price'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->withDefault();
    }

    public function kid()
    {
        return $this->belongsTo(Kid::class, 'kid_id')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    protected function cartQuantityPrice(): Attribute
    {
        return new Attribute(
            get: fn () => (int) $this->quantity * (int) $this->product->price,
        );
    }
}
