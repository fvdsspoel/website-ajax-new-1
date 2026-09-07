<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShowroomLocation extends Model
{
    protected $fillable = [
        'name', 'address', 'phone',
        'is_headquarters', 'is_factory', 'is_showroom', 'is_upcoming', 'is_active',
    ];

    protected $casts = [
        'is_headquarters' => 'boolean',
        'is_factory' => 'boolean',
        'is_showroom' => 'boolean',
        'is_upcoming' => 'boolean',
        'is_active' => 'boolean',
    ];
}
