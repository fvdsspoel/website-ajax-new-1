<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * A kitchen / wardrobe accessory shown on /accessories. No price field
 * on purpose — Ajax quotes per project and doesn't sell online.
 *
 * Wholesale boards were removed from the public site: these are the
 * fittings customers can add to a kitchen or wardrobe we build.
 * Category labels are translated in lang/{en,tl}/site.php
 * (accessories.categories.<key>); the English labels here are for
 * the admin panel.
 */
class Product extends Model
{
    protected $fillable = ['name', 'category', 'description', 'image_url'];

    public const CATEGORIES = [
        'pullouts' => 'Pull-out & pantry systems',
        'corner' => 'Corner solutions',
        'organizers' => 'Drawer & cabinet organizers',
        'sinks' => 'Sinks & fixtures',
        'hardware' => 'Hinges, runners & lift systems',
    ];

    /** Translated name if lang/<locale>/catalog.php has one, else the admin-entered text. */
    public function localizedName(): string
    {
        $key = 'catalog.'.Str::slug($this->name).'.name';
        return trans()->has($key) ? __($key) : $this->name;
    }

    public function localizedDescription(): ?string
    {
        $key = 'catalog.'.Str::slug($this->name).'.description';
        return trans()->has($key) ? __($key) : $this->description;
    }
}
