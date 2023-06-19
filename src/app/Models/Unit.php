<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $table = 'unit_fields';

    protected $fillable = [
        'unit_title',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function units()
    {
        return $this->belongsToMany(Product::class, 'product_units', 'unit_field_id', 'product_id');
    }
}
