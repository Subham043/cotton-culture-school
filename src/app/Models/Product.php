<?php

namespace App\Models;

use App\Enums\Gender;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'featured_image',
        'price',
        'brief_description',
        'detailed_description',
        'detailed_description_unfiltered',
        'category_id',
        'school_class_id',
        'youtube_video_id',
        'gender',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'gender' => Gender::class,
    ];

    public $image_path = 'products';

    protected $appends = ['featured_image_link'];

    protected function featuredImage(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => 'storage/'.$this->image_path.'/'.$value,
        );
    }

    protected function featuredImageLink(): Attribute
    {
        return new Attribute(
            get: fn () => asset($this->featured_image),
        );
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->withDefault();
    }

    public function schoolAndclass()
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id')->withDefault();
    }

    public function slider_image()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function specification()
    {
        return $this->hasMany(ProductSpecification::class, 'product_id');
    }

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'product_units', 'product_id', 'unit_field_id');
    }
}
