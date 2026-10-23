<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaUploadService
{
    /**
     * Upload an image or file and return its accessible URL.
     */
    public function upload(UploadedFile $file, string $directory = 'uploads'): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = Str::uuid() . '.' . strtolower($extension);
        $disk = config('filesystems.default', 'public');

        $path = $file->storeAs($directory, $filename, $disk);

        return Storage::disk($disk)->url($path);
    }

    /**
     * Delete a file if it exists.
     */
    public function delete(?string $url): bool
    {
        if (!$url) {
            return false;
        }

        $disk = config('filesystems.default', 'public');
        
        // Extract relative path from URL if possible
        $path = parse_url($url, PHP_URL_PATH);
        if ($path) {
            $relativePath = ltrim($path, '/');
            // Remove storage/ prefix if local
            if (str_starts_with($relativePath, 'storage/')) {
                $relativePath = substr($relativePath, 8);
            }
            if (Storage::disk($disk)->exists($relativePath)) {
                return Storage::disk($disk)->delete($relativePath);
            }
        }

        return false;
    }
}

