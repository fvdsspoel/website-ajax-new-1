<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * A catalog entry shown on /products. No price field on purpose —
 * see the site's decision log: Ajax isn't selling online yet, so
 * this page is "what we make," not a store.
 */
class Product extends Model
{
    protected $fillable = ['name', 'category', 'description', 'image_url'];

    public const CATEGORIES = [
        'hardware' => 'Universal Hardware System',
        'storage' => 'Storage Application',
        'boards' => 'Boards',
    ];
}
