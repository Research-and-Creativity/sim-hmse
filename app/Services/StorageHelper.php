<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class StorageHelper
{
    /**
     * Generate an authorized accessible URL for files stored in S3/Supabase private storage or local disk.
     *
     * @param string|null $path File storage path or external URL
     * @param int $expirationMinutes Expiration time for signed temporary URLs (default 60 minutes)
     * @return string|null
     */
    public static function url(?string $path, int $expirationMinutes = 60): ?string
    {
        if (!$path || trim($path) === '') {
            return null;
        }

        // If path is already a full external URL (e.g. https://... or http://...), return as is
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, 'data:image')) {
            return $path;
        }

        $defaultDisk = config('filesystems.default', 'local');

        // 1. Try Signed Temporary URL on S3 (Supabase Private Storage)
        if ($defaultDisk === 's3' || env('FILESYSTEM_DISK') === 's3') {
            try {
                return Storage::disk('s3')->temporaryUrl($path, now()->addMinutes($expirationMinutes));
            } catch (\Throwable $e) {
                // If S3 temporaryUrl fails or is unsupported, fallback to server proxy route
                return route('storage.proxy', ['path' => $path]);
            }
        }

        // 2. Local / Testing Environment
        try {
            return Storage::temporaryUrl($path, now()->addMinutes($expirationMinutes));
        } catch (\Throwable $e) {
            // Check if file exists in local storage
            if (Storage::disk('public')->exists($path)) {
                return Storage::disk('public')->url($path);
            }
            return route('storage.proxy', ['path' => $path]);
        }
    }
}
