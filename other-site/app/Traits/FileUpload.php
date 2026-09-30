<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Storage;

trait FileUpload {
    
    public function uploadImage($folder,$file)
    {
        $path1 = Storage::disk('public')->put($folder, $file);
        $image1='/storage/'.$path1;
        
        $path = Storage::path('public/'.$path1);
        $base =env('APP_URL');
        $imagepath = public_path('/storage/'.$path1);
        $ext = pathinfo($imagepath, PATHINFO_EXTENSION);

        if ($ext == 'png') {
            $im = imagecreatefrompng($imagepath);
            imagepalettetotruecolor($im);
            imagealphablending($im, true);
            imagesavealpha($im, true);
            $newImagePath = str_replace("png", "webp", $path);
            imagewebp($im, $newImagePath, 40);
            $converted_path = str_replace(".png",".webp",$image1);

        } elseif ($ext == 'jpg') {

            $im = imagecreatefromjpeg($imagepath);
            imagepalettetotruecolor($im);
            imagealphablending($im, true);
            imagesavealpha($im, true);
            $newImagePath = str_replace("jpg", "webp", $path);
            imagewebp($im, $newImagePath, 40);
            $converted_path = str_replace(".jpg",".webp",$image1);

        } elseif ($ext == 'webp') {

            $im = imagecreatefromwebp($imagepath);
            imagepalettetotruecolor($im);
            imagealphablending($im, true);
            imagesavealpha($im, true);
            $newImagePath = str_replace("webp", "webp", $path);
            imagewebp($im, $newImagePath, 40);
            $converted_path = str_replace(".webp",".webp",$image1);

        } elseif ($ext == 'gif') {
            $im = imagecreatefromgif($imagepath);
            imagepalettetotruecolor($im);
            imagealphablending($im, true);
            imagesavealpha($im, true);
            $newImagePath = str_replace("gif", "webp", $path);
            imagewebp($im, $newImagePath, 40);
            $converted_path = str_replace(".gif",".webp",$image1);

        } else {

            $im = imagecreatefromjpeg($imagepath);
            imagepalettetotruecolor($im);
            imagealphablending($im, true);
            imagesavealpha($im, true);
            $newImagePath = str_replace("jpeg", "webp", $path);
            imagewebp($im, $newImagePath, 40);
            $converted_path = str_replace(".jpeg",".webp",$image1);
        }

        return $converted_path;
    }
}