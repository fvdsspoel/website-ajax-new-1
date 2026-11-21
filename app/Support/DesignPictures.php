<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;

/**
 * Pictures for the "Which style do you like?" step of the design selector,
 * one per room type × style. Order of preference:
 *   1. a picture uploaded in the back office (public/uploads/design/{set}-{style}.jpg)
 *   2. a real Ajax project photo set in config/ajax.php
 *   3. none → the page draws a style sketch of that piece of furniture.
 * Uploads live outside git, so a deploy (git reset) never removes them.
 */
class DesignPictures
{
    /** Room types as shown to staff; the design.js room → set map uses the same keys. */
    public const SETS = [
        'kitchen' => 'Kitchen (also "Whole house")',
        'wardrobe' => 'Wardrobe & bedroom',
        'living' => 'TV wall & living room',
        'office' => 'Office',
        'bath' => 'Bathroom vanity',
        'other' => 'Something else',
    ];

    public const STYLES = ['handleless', 'handles', 'wood', 'dark', 'gloss', 'twotone'];

    public static function dir(): string
    {
        return public_path('uploads/design');
    }

    public static function uploadedFile(string $set, string $style): ?string
    {
        $f = self::dir()."/{$set}-{$style}.jpg";

        return is_file($f) ? $f : null;
    }

    /** URL of the picture for this tile, or null when the sketch should be drawn. */
    public static function url(string $set, string $style, bool $small = true): ?string
    {
        if ($f = self::uploadedFile($set, $style)) {
            return asset("uploads/design/{$set}-{$style}.jpg").'?v='.filemtime($f);
        }
        $path = $set === 'kitchen'
            ? config("ajax.style_images.$style")
            : config("ajax.style_images_by_set.$set.$style");
        if (! $path) {
            return null;
        }

        return asset($small ? str_replace('.webp', '-sm.webp', $path) : $path);
    }

    /** Where the current picture comes from: upload | project | sketch. */
    public static function source(string $set, string $style): string
    {
        if (self::uploadedFile($set, $style)) {
            return 'upload';
        }

        return self::url($set, $style) ? 'project' : 'sketch';
    }

    /** Save an upload as a 4:3 JPEG (max 1200 px wide); falls back to the original file if GD is missing. */
    public static function store(string $set, string $style, UploadedFile $file): void
    {
        if (! is_dir(self::dir())) {
            mkdir(self::dir(), 0755, true);
        }
        $target = self::dir()."/{$set}-{$style}.jpg";

        $src = function_exists('imagecreatefromstring') ? @imagecreatefromstring(file_get_contents($file->getRealPath())) : false;
        if (! $src) {
            $file->move(self::dir(), "{$set}-{$style}.jpg");

            return;
        }
        // Phone photos: respect the camera's rotation.
        if (function_exists('exif_read_data') && in_array(strtolower($file->getClientOriginalExtension()), ['jpg', 'jpeg'])) {
            $o = @exif_read_data($file->getRealPath())['Orientation'] ?? 1;
            $src = match ((int) $o) { 3 => imagerotate($src, 180, 0), 6 => imagerotate($src, -90, 0), 8 => imagerotate($src, 90, 0), default => $src };
        }
        $w = imagesx($src);
        $h = imagesy($src);
        // Centre-crop to 4:3 like the tiles on the website.
        if ($w / $h > 4 / 3) {
            $cw = (int) round($h * 4 / 3); $ch = $h; $cx = (int) (($w - $cw) / 2); $cy = 0;
        } else {
            $cw = $w; $ch = (int) round($w * 3 / 4); $cx = 0; $cy = (int) (($h - $ch) / 2);
        }
        $ow = min(1200, $cw);
        $oh = (int) round($ow * 3 / 4);
        $out = imagecreatetruecolor($ow, $oh);
        imagecopyresampled($out, $src, 0, 0, $cx, $cy, $ow, $oh, $cw, $ch);
        imagejpeg($out, $target, 85);
        imagedestroy($out);
        imagedestroy($src);
    }

    public static function remove(string $set, string $style): void
    {
        if ($f = self::uploadedFile($set, $style)) {
            @unlink($f);
        }
    }
}
