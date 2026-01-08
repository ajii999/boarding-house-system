<?php

if (!function_exists('storage_url')) {
    /**
     * Generate URL for storage files
     * For payment receipts, use database route if payment ID is available
     */
    function storage_url(?string $path, $payment = null): ?string
    {
        if (empty($path)) {
            return null;
        }
        
        // If we have a payment model and the path matches, use database route
        if ($payment && is_object($payment) && isset($payment->payment_id)) {
            try {
                if (function_exists('route') && \Illuminate\Support\Facades\Route::has('payments.receipt')) {
                    return route('payments.receipt', ['payment' => $payment->payment_id]);
                }
            } catch (\Exception $e) {
                // Fall through
            }
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
