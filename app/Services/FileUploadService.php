<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Upload single file to specified disk and directory.
     */
    public function upload(UploadedFile $file, string $directory = 'uploads', string $disk = 'public'): string
    {
        return $file->store($directory, $disk);
    }

    /**
     * Upload and optimize thumbnail image (scale down to maxWidth and compress).
     */
    public function uploadThumbnail(
        UploadedFile $file,
        string $directory = 'news',
        int $maxWidth = 1200,
        int $quality = 82,
        string $disk = 'public'
    ): string {
        $filename = trim($directory, '/').'/'.Str::random(40).'.jpg';
        $fullTarget = storage_path('app/public/'.$filename);

        if (! is_dir(dirname($fullTarget))) {
            mkdir(dirname($fullTarget), 0755, true);
        }

        if (extension_loaded('gd')) {
            $srcPath = $file->getRealPath();
            $info = @getimagesize($srcPath);

            if ($info && in_array($info['mime'], ['image/jpeg', 'image/png', 'image/webp'])) {
                $origW = $info[0];
                $origH = $info[1];

                $srcImg = match ($info['mime']) {
                    'image/jpeg' => @imagecreatefromjpeg($srcPath),
                    'image/png' => @imagecreatefrompng($srcPath),
                    'image/webp' => @imagecreatefromwebp($srcPath),
                    default => null,
                };

                if ($srcImg) {
                    $targetW = min($maxWidth, $origW);
                    $targetH = (int) round(($origH / $origW) * $targetW);

                    $dstImg = imagecreatetruecolor($targetW, $targetH);
                    $white = imagecolorallocate($dstImg, 255, 255, 255);
                    imagefill($dstImg, 0, 0, $white);

                    imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $targetW, $targetH, $origW, $origH);
                    imagejpeg($dstImg, $fullTarget, $quality);

                    imagedestroy($srcImg);
                    imagedestroy($dstImg);

                    return $filename;
                }
            }
        }

        return $file->store($directory, $disk);
    }

    /**
     * Upload an array of files.
     *
     * @param  array<UploadedFile>  $files
     * @return array<string>
     */
    public function uploadMultiple(array $files, string $directory, string $disk = 'public'): array
    {
        $paths = [];
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $paths[] = $file->store($directory, $disk);
            }
        }

        return $paths;
    }

    /**
     * Safely delete a file if it exists.
     */
    public function delete(?string $path, string $disk = 'public'): bool
    {
        if (! empty($path) && Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }

        return false;
    }

    /**
     * Safely delete multiple files.
     *
     * @param  array<string>  $paths
     */
    public function deleteMultiple(array $paths, string $disk = 'public'): void
    {
        foreach ($paths as $path) {
            $this->delete($path, $disk);
        }
    }

    /**
     * Process embedded base64 images inside HTML content, saving them to disk
     * and replacing the data URI with the permanent public storage URL.
     */
    public function processEmbeddedContentImages(?string $htmlContent, string $folder = 'news/content', string $disk = 'public'): ?string
    {
        if (empty($htmlContent)) {
            return $htmlContent;
        }

        // Match all src="data:image/(png|jpeg|jpg|gif|webp|svg+xml);base64,..."
        $pattern = '/src=["\'](data:image\/(?<type>[a-zA-Z0-9\+\-]+);base64,(?<data>[^"\']+))["\']/i';

        return preg_replace_callback($pattern, function ($matches) use ($folder, $disk) {
            $rawType = strtolower($matches['type']);
            $extension = match ($rawType) {
                'jpeg', 'jpg' => 'jpg',
                'png' => 'png',
                'gif' => 'gif',
                'webp' => 'webp',
                'svg+xml' => 'svg',
                default => 'png',
            };

            $base64Data = base64_decode(str_replace(' ', '+', $matches['data']), true);
            if ($base64Data === false) {
                return $matches[0];
            }

            $filename = Str::random(40) . '.' . $extension;
            $relativePath = trim($folder, '/') . '/' . $filename;

            Storage::disk($disk)->put($relativePath, $base64Data);

            $permanentUrl = asset('storage/' . $relativePath);

            return 'src="' . $permanentUrl . '"';
        }, $htmlContent);
    }

    /**
     * Extract and delete images embedded inside HTML content (e.g. TinyMCE uploads).
     */
    public function deleteEmbeddedContentImages(?string $htmlContent, string $disk = 'public'): void
    {
        if (empty($htmlContent)) {
            return;
        }

        preg_match_all('/src="[^"]*\/storage\/([a-zA-Z0-9_\-\/]+\.[a-zA-Z0-9]+)"/i', $htmlContent, $matches);
        if (! empty($matches[1])) {
            foreach ($matches[1] as $imageRelativePath) {
                $this->delete($imageRelativePath, $disk);
            }
        }
    }
}
