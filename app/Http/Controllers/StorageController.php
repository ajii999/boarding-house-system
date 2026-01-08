<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class StorageController extends Controller
{
    /**
     * Serve files from storage
     */
    public function show(Request $request, string $path): Response
    {
        try {
            // Decode URL-encoded path and clean it
            $path = urldecode($path);
            $path = ltrim($path, '/');
            
            // Security: Only allow files from public disk
            if (empty($path)) {
                \Log::warning('StorageController: Empty path provided');
                abort(404, 'File not found');
            }
            
            // Check if file exists
            if (!Storage::disk('public')->exists($path)) {
                // File doesn't exist - this is common on Railway due to ephemeral filesystem
                // Return a placeholder image instead of 404
                \Log::warning('StorageController: File not found (ephemeral filesystem issue)', [
                    'path' => $path,
                    'storage_path' => storage_path('app/public/' . $path),
                    'exists' => file_exists(storage_path('app/public/' . $path))
                ]);
                
                // Return a placeholder SVG image
                $placeholder = '<svg xmlns="http://www.w3.org/2000/svg" width="400" height="300" viewBox="0 0 400 300">
                    <rect width="400" height="300" fill="#f0f0f0"/>
                    <text x="50%" y="50%" text-anchor="middle" dy=".3em" fill="#999" font-family="Arial" font-size="16">
                        File not found (ephemeral storage)
                    </text>
                    <text x="50%" y="60%" text-anchor="middle" dy=".3em" fill="#999" font-family="Arial" font-size="12">
                        ' . htmlspecialchars($path) . '
                    </text>
                </svg>';
                
                return response($placeholder, 200)
                    ->header('Content-Type', 'image/svg+xml')
                    ->header('Cache-Control', 'no-cache');
            }

            $file = Storage::disk('public')->get($path);
            
            if ($file === false || $file === null) {
                \Log::warning('StorageController: Failed to read file', ['path' => $path]);
                abort(404, 'File not found');
            }
            
            $mimeType = Storage::disk('public')->mimeType($path) ?? 'image/jpeg';

            return response($file, 200)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'inline')
                ->header('Cache-Control', 'public, max-age=31536000');
        } catch (\Illuminate\Contracts\Filesystem\FileNotFoundException $e) {
            \Log::warning('StorageController: FileNotFoundException', [
                'path' => $path ?? 'null',
                'message' => $e->getMessage()
            ]);
            abort(404, 'File not found');
        } catch (\Exception $e) {
            \Log::error('StorageController error: ' . $e->getMessage(), [
                'path' => $path ?? 'null',
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Error serving file: ' . $e->getMessage());
        }
    }
}
