<?php

namespace App\Services\Files;

use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class ThumbnailService
{
    public static function generate_thumbnail($file, $ext, $width=100, $height=100): string|null{
        try {
            if (!extension_loaded('gd')) {
                Log::error("gd extension not loaded");
                return null;
            }
            $manager = new ImageManager(new GdDriver());
            $image = $manager->read($file);
            $thumbName = 'thumb_' . time() . '_' . rand(10, 9999) . '.' . $ext;
            $thumbPath = 'uploads/thumbnails/' . $thumbName;
            $image->resize($width, $height);
            $image->save($thumbPath);
            return '/' . $thumbPath;
        }
        catch (\Exception $e){
            Log::error($e->getMessage());
            return null;
        }
    }
}
