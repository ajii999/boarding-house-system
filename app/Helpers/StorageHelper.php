<?php

if (!function_exists('storage_url')) {
    /**
     * Generate URL for storage files
     * Uses route-based approach for Railway compatibility
     */
    function storage_url(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }
        
        // Clean the path
        $path = ltrim($path, '/');
        
        // Use route if available, otherwise fallback to asset
        try {
            if (function_exists('route') && \Illuminate\Support\Facades\Route::has('storage.show')) {
                // URL encode the path to handle special characters
                return route('storage.show', ['path' => $path]);
            }
        } catch (\Exception $e) {
            // Fall through to asset fallback
        }
        
        // Fallback to asset helper (uses symlink)
        return asset('storage/' . $path);
    }
}
