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
                // Don't URL encode here - Laravel route() will handle it
                // But we need to ensure the path is properly formatted
                $url = route('storage.show', ['path' => $path]);
                return $url;
            }
        } catch (\Exception $e) {
            // Fall through to asset fallback
            \Log::warning('storage_url route failed, using asset fallback', [
                'path' => $path,
                'error' => $e->getMessage()
            ]);
        }
        
        // Fallback to asset helper (uses symlink)
        return asset('storage/' . $path);
    }
}
