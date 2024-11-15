<?php

namespace App\Traits;

use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Encoders\AutoEncoder;

trait UploadPhotos
{
    const FILESYSTEM = env('FILESYSTEM_DISK', 'public'); 
    
    /**
     * Uploads a photo and optionally deletes an existing photo.
     *
     * @param \Illuminate\Http\UploadedFile $photo The photo to upload.
     * @param string $existingPhoto The path of an existing photo to delete.
     * @param string $directory The directory to store the uploaded photo.
     * @param string $prefix The prefix for the filename.
     * @param string $format The image format (e.g., 'png', 'jpg', 'webp').
     * @param int $quality The quality of the image (1 to 100).
     * @return string|null The path to the uploaded photo or null on failure.
     */
    public function uploadPhoto($photo, $existingPhoto = '', $directory = 'uploads/', $prefix = '')
    {
        if (!$photo || !$photo->isValid()) {
            return null;
        }

        // Generate a unique filename
        $photoPath = self::generateUniqueFileNameWithDirectory($photo->getClientOriginalExtension(), $directory, $prefix);

        // Create and store the new image
        $img = Image::read($photo->getRealPath());
        $img = $img->encode(new AutoEncoder(quality: 80));
        Storage::disk(self::FILESYSTEM)->put($photoPath, $img);

        // Delete the existing photo, if any
        $this->deleteImage($existingPhoto);
        return $photoPath;
    }

    /**
     * Deletes an existing image if it exists.
     *
     * @param string $filePath The path of the file to delete.
     */
    public function deleteImage($filePath)
    {
        if ($filePath && Storage::disk(self::FILESYSTEM)->exists($filePath)) {
            Storage::disk(self::FILESYSTEM)->delete($filePath);
        }
    }

    /**
     * Generates a unique file path with the specified directory and prefix.
     *
     * @param string $extension The file extension.
     * @param string $directory The directory for the file.
     * @param string $prefix The prefix for the file name.
     * @return string The generated file path.
    */

    public static function generateUniqueFileNameWithDirectory($extension, $directory, $prefix)
    {
        return $directory . $prefix . time() . hexdec(uniqid()) . '.' . $extension;
    }


    public function generatePhotoFromText($text){
        $image = Image::create(640, 480)->fill('#ff0000'); // Create a red image
        $image->text($text, 320, 240, function($font) {
            $font->file(public_path('inter.ttf')); // Path to a font file
            $font->size(30);
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('middle');
        });
        return $image;
    }
}
