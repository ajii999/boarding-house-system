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
        
        // Use route if available, otherwise fallback to asset
        try {
            if (function_exists('route') && \Illuminate\Support\Facades\Route::has('storage.show')) {
                return route('storage.show', ['path' => $path]);
            }
        } catch (\Exception $e) {
            // Fall through to asset fallback
        }
        
        // Fallback to asset helper
        return asset('storage/' . ltrim($path, '/'));
    }
}
