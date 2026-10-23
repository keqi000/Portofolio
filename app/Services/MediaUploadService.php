<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

class MediaUploadService
{
    /**
     * Upload an image or file and return its accessible URL.
     */
    public function upload(UploadedFile $file, string $directory = 'uploads', string $filenamePrefix = 'upload'): string
    {
        $extension = $file->getClientOriginalExtension();
        $filenamePrefix = Str::slug($filenamePrefix);
        $sequenceKey = $directory . '/' . $filenamePrefix;
        $number = DB::transaction(function () use ($sequenceKey): int {
            DB::table('media_upload_sequences')->insertOrIgnore([
                'sequence_key' => $sequenceKey,
                'last_number' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $updated = DB::table('media_upload_sequences')
                ->where('sequence_key', $sequenceKey)
                ->increment('last_number', 1, ['updated_at' => now()]);

            if ($updated !== 1) {
                throw new RuntimeException("Upload sequence [{$sequenceKey}] could not be created.");
            }

            return (int) DB::table('media_upload_sequences')
                ->where('sequence_key', $sequenceKey)
                ->value('last_number');
        });
        $filename = $filenamePrefix . '-' . $number . '.' . strtolower($extension);
        $disk = config('filesystems.default', 'public');

        $path = $file->storeAs($directory, $filename, $disk);
        if (!is_string($path) || $path === '') {
            throw new RuntimeException("File upload failed on the [{$disk}] disk.");
        }

        return $this->publicUrl(Storage::disk($disk)->url($path));
    }

    public function replace(
        ?string $oldUrl,
        UploadedFile $newFile,
        string $directory = 'uploads',
        string $filenamePrefix = 'upload'
    ): string
    {
        $newUrl = $this->upload($newFile, $directory, $filenamePrefix);

        try {
            $this->delete($oldUrl);
        } catch (Throwable $exception) {
            try {
                $this->delete($newUrl);
            } catch (Throwable $cleanupException) {
                throw new RuntimeException(
                    "File replacement failed and the new file could not be cleaned up: {$cleanupException->getMessage()}",
                    previous: $exception
                );
            }

            throw $exception;
        }

        return $newUrl;
    }

    public function publicUrl(?string $url): ?string
    {
        if (!$url) {
            return null;
        }

        if (config('filesystems.default') === 'public') {
            $path = parse_url($url, PHP_URL_PATH);
            if ($path && str_starts_with($path, '/storage/')) {
                return $path;
            }
        }

        return $url;
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
        
        $relativePath = $this->relativePath($url);
        if (!$relativePath) {
            return false;
        }

        $storage = Storage::disk($disk);
        if (!$storage->exists($relativePath)) {
            return false;
        }

        if (!$storage->delete($relativePath)) {
            throw new RuntimeException("File deletion failed for [{$relativePath}] on the [{$disk}] disk.");
        }

        return true;
    }

    private function relativePath(string $url): ?string
    {
        $path = parse_url($url, PHP_URL_PATH);
        if (!$path) {
            return null;
        }

        $disk = config('filesystems.default', 'public');
        $diskConfig = config("filesystems.disks.{$disk}", []);
        $basePath = parse_url($diskConfig['url'] ?? '', PHP_URL_PATH);

        if ($basePath && str_starts_with($path, rtrim($basePath, '/') . '/')) {
            return substr($path, strlen(rtrim($basePath, '/')) + 1);
        }

        $relativePath = ltrim($path, '/');
        if (str_starts_with($relativePath, 'storage/')) {
            $relativePath = substr($relativePath, 8);
        }
        if (!empty($diskConfig['bucket']) && str_starts_with($relativePath, $diskConfig['bucket'] . '/')) {
            $relativePath = substr($relativePath, strlen($diskConfig['bucket']) + 1);
        }

        return $relativePath;
    }
}
