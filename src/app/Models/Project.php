<?php

namespace App\Models;

use App\Enums\AvailibilityType;
use App\Enums\ProjectType;
use App\Enums\RoomType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = [
        'name',
        'project_type',
        'number',
        'facing',
        'availibility',
        'site_measurement',
        'type',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'project_type' => ProjectType::class,
        'type' => RoomType::class,
        'availibility' => AvailibilityType::class,
    ];
}
