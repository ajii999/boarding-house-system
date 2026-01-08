<?php

if (!function_exists('storage_url')) {
    /**
     * Generate URL for storage files
     * Uses route-based approach for Railway compatibility
     * Falls back to asset() if route not available
     */
    function storage_url(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }
        
        // Clean the path - remove leading slashes
        $path = ltrim($path, '/');
        
        // Try route-based approach first (works even if symlink fails)
        try {
            if (function_exists('route') && \Illuminate\Support\Facades\Route::has('storage.show')) {
                return route('storage.show', ['path' => $path]);
            }
        } catch (\Exception $e) {
            // Fall through to asset fallback
        }
        
        // Fallback to asset() - uses public/storage symlink
        return asset('storage/' . $path);
    }
}
