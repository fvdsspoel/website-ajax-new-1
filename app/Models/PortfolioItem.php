<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * A completed project shown on /portfolio — a credibility showcase, never a
 * price list. `image_url` is the cover; `images` the whole gallery (paths
 * under public/, each with a "-sm" thumbnail next to it when it is a .webp
 * the site made, or an uploaded file in storage).
 */
class PortfolioItem extends Model
{
    protected $fillable = ['title', 'location', 'category', 'description', 'image_url', 'images', 'is_featured', 'sort'];

    protected $casts = [
        'is_featured' => 'boolean',
        'images' => 'array',
    ];

    public const CATEGORIES = [
        'kitchen' => 'Kitchens',
        'wardrobe' => 'Wardrobes',
        'living' => 'TV & living',
        'commercial' => 'Office & commercial',
        'other' => 'Other',
    ];

    /** Every photo of the project, cover first: [['src' => url, 'thumb' => url], …]. */
    public function gallery(): array
    {
        $paths = array_values(array_unique(array_filter(array_merge([$this->image_url], $this->images ?? []))));

        return array_map(fn (string $p) => ['src' => self::url($p), 'thumb' => self::url(self::thumbPath($p))], $paths);
    }

    public function coverUrl(): ?string
    {
        return $this->image_url ? self::url($this->image_url) : null;
    }

    public function coverThumbUrl(): ?string
    {
        return $this->image_url ? self::url(self::thumbPath($this->image_url)) : null;
    }

    public static function thumbPath(string $path): string
    {
        if (Str::endsWith($path, '.webp') && Str::startsWith($path, 'images/') && file_exists(public_path(Str::replaceLast('.webp', '-sm.webp', $path)))) {
            return Str::replaceLast('.webp', '-sm.webp', $path);
        }

        return $path;
    }

    private static function url(string $path): string
    {
        if (Str::startsWith($path, ['http://', 'https://', '/'])) {
            return $path;
        }

        // Admin uploads live on the public disk; the site's own photos under public/images.
        return Str::startsWith($path, 'images/') ? asset($path) : asset('storage/'.$path);
    }
}
