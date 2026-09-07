<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * A completed project shown on /portfolio. Kept deliberately simple
 * (no pricing fields — see the site's decision log on not showing
 * prices) — this is a credibility showcase, not a catalog.
 */
class PortfolioItem extends Model
{
    protected $fillable = ['title', 'category', 'description', 'image_url', 'is_featured'];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    public const CATEGORIES = [
        'kitchen' => 'Kitchens',
        'wardrobe' => 'Wardrobes',
        'commercial' => 'Commercial',
    ];
}
