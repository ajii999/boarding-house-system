<?php

if (!function_exists('storage_url')) {
    /**
     * Generate URL for storage files
     * Uses route-based approach for Railway compatibility
     */
    function storage_url(string $path): string
    {
        return route('storage.show', ['path' => $path]);
    }
}
