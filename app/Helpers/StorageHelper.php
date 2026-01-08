<?php

if (!function_exists('storage_url')) {
    /**
     * Generate URL for storage files
     * Uses asset() with symlink for simplicity and reliability
     */
    function storage_url(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }
        
        // Clean the path - remove leading slashes
        $path = ltrim($path, '/');
        
        // Use asset() directly - this uses the public/storage symlink
        // Format: /storage/receipts/filename.jpg
        return asset('storage/' . $path);
    }
}
