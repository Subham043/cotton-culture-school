<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class School extends Model
{
    use HasFactory;

    protected $table = 'schools';

    protected $fillable = [
        'name',
        'logo',
        'submission_duration',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $image_path = 'schools';

    protected $appends = ['logo_link'];

    protected function logo(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => 'storage/'.$this->image_path.'/'.$value,
        );
    }

    protected function logoLink(): Attribute
    {
        return new Attribute(
            get: fn () => asset($this->logo),
        );
    }

    public function schoolClass()
    {
        return $this->hasMany(SchoolClass::class, 'class_id');
    }

    public function allocated_users()
    {
        return $this->belongsToMany(User::class, 'allocated_schools', 'school_id', 'user_id');
    }
}
