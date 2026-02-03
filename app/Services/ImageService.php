<?php

namespace App\Services;

class ImageService
{
    public function compressAndSave($photo, $filename, $quality = 70)
    {
        $dir = storage_path('app/public/absensi_photos');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $destinationPath = $dir . '/' . $filename;

        if ($photo->getSize() < 1024 * 1024) {
            $photo->move($dir, $filename);
            return 'absensi_photos/' . $filename;
        }

        $this->resizeAndCompress(
            $photo->getRealPath(),
            $destinationPath,
            $quality
        );

        return 'absensi_photos/' . $filename;
    }

    private function resizeAndCompress($sourcePath, $destinationPath, $quality)
    {
        $info = getimagesize($sourcePath);
        if (!$info) {
            copy($sourcePath, $destinationPath);
            return;
        }

        [$width, $height] = $info;
        $mime = $info['mime'];

        $maxWidth = 1280;
        if ($width > $maxWidth) {
            $ratio = $maxWidth / $width;
            $newWidth = $maxWidth;
            $newHeight = (int) ($height * $ratio);
        } else {
            $newWidth = $width;
            $newHeight = $height;
        }

        switch ($mime) {
            case 'image/jpeg':
                $src = imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $src = imagecreatefrompng($sourcePath);
                break;
            case 'image/webp':
                $src = imagecreatefromwebp($sourcePath);
                break;
            default:
                copy($sourcePath, $destinationPath);
                return;
        }

        $dst = imagecreatetruecolor($newWidth, $newHeight);

        imagecopyresampled(
            $dst,
            $src,
            0,
            0,
            0,
            0,
            $newWidth,
            $newHeight,
            $width,
            $height
        );

        imagejpeg($dst, $destinationPath, $quality);

        imagedestroy($src);
        imagedestroy($dst);
    }
}
