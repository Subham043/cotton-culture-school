<?php

namespace App\Models;

use App\Enums\Gender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kid extends Model
{
    use HasFactory;

    protected $table = 'kids';

    protected $fillable = [
        'name',
        'gender',
        'section',
        'user_id',
        'school_class_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'gender' => Gender::class,
    ];

    public function schoolAndClass()
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }
}
