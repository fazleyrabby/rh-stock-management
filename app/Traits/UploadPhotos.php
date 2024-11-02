<?php

namespace App\Traits;

use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Encoders\WebpEncoder;

trait UploadPhotos
{
    public function uploadPhoto($photo, $existingPhoto = '', $directory = 'uploads/', $prefix = '', $format = 'png', $quality = 90)
    {
        if (!$photo || !$photo->isValid()) {
            return null;
        }

        // Generate a unique filename
        $photoPath = self::generateUniqueFileNameWithDirectory($photo->getClientOriginalExtension(), $directory, $prefix);

        // Delete the existing photo, if any
        $this->deleteImage($existingPhoto);

        // Create and store the new image
        $img = Image::read($photo->getRealPath());
        $img = $img->encode(new WebpEncoder(quality: 70));
        Storage::disk('public')->put($photoPath, $img);

        return $photoPath;
    }

    public function deleteImage($filePath)
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }

    public static function generateUniqueFileNameWithDirectory($extension, $directory, $prefix)
    {
        return $directory . $prefix . time() . hexdec(uniqid()) . '.' . $extension;
    }
}
