<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function compressAndSave($photo, $filename, $quality = 50)
    {
        $path = storage_path('app/public/absensi_photos/'.$filename);

        if ($photo->getSize() > 2 * 1024 * 1024) {
            $this->compressImage($photo->getRealPath(), $path, $quality);
        } else {
            $photo->move(storage_path('app/public/absensi_photos'), $filename);
        }

        return 'absensi_photos/'.$filename;
    }
    
    private function compressImage($sourcePath, $destinationPath, $quality = 50)
    {
        $info = getimagesize($sourcePath);

        if ($info['mime'] == 'image/jpeg') {
            $image = imagecreatefromjpeg($sourcePath);
            imagejpeg($image, $destinationPath, $quality);
        } elseif ($info['mime'] == 'image/png') {
            $image = imagecreatefrompng($sourcePath);
            imagejpeg($image, $destinationPath, $quality);
        } elseif ($info['mime'] == 'image/webp') {
            $image = imagecreatefromwebp($sourcePath);
            imagewebp($image, $destinationPath, $quality);
        } else {
            copy($sourcePath, $destinationPath);
        }

        imagedestroy($image);
    }

}