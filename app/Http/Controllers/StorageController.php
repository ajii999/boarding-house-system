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
            // Security: Only allow files from public disk
            if (!Storage::disk('public')->exists($path)) {
                abort(404, 'File not found');
            }

            $file = Storage::disk('public')->get($path);
            $mimeType = Storage::disk('public')->mimeType($path) ?? 'image/jpeg';

            return response($file, 200)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'inline')
                ->header('Cache-Control', 'public, max-age=31536000');
        } catch (\Exception $e) {
            abort(404, 'File not found');
        }
    }
}
