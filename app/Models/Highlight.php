<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Replaces the old ad-hoc "highlights" feed that dominated the
 * homepage (report Section 2). Same content type, but now scoped to
 * a small homepage strip plus its own dedicated /highlights page,
 * rather than being the entire homepage.
 */
class Highlight extends Model
{
    protected $fillable = ['title', 'body', 'image_url', 'published_at'];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
