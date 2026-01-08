<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Tenant;
use App\Models\Booking;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Payment::with(['tenant', 'booking', 'paymentMethod']);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('amount', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('method', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%")
                  ->orWhereHas('tenant', function($tenantQuery) use ($search) {
                      $tenantQuery->where('name', 'like', "%{$search}%")
                                 ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('paymentMethod', function($methodQuery) use ($search) {
                      $methodQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $payments = $query->latest('payment_date')->paginate(10);
        
        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tenants = Tenant::all();
        $bookings = Booking::whereIn('status', ['confirmed', 'completed'])->get();
        $paymentMethods = PaymentMethod::active()->get();
        
        return view('admin.payments.create', compact('tenants', 'bookings', 'paymentMethods'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tenant_id' => 'required|exists:tenants,tenant_id',
            'booking_id' => 'nullable|exists:bookings,booking_id',
            'method_id' => 'nullable|exists:payment_methods,method_id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'method' => 'required|in:cash,gcash,paymaya',
            'notes' => 'nullable|string|max:1000',
            'receipt_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB max
        ]);

        // Set status to completed automatically
        $request->merge(['status' => 'completed']);

        $data = $request->all();

        // Handle receipt image upload
        if ($request->hasFile('receipt_image')) {
            $receiptPath = $request->file('receipt_image')->store('receipts', 'public');
            $data['receipt_image'] = $receiptPath;
        }

        $payment = Payment::create($data);

        // Create invoice record for the payment
        if ($payment) {
            \App\Models\Invoice::create([
                'payment_id' => $payment->payment_id,
                'tenant_id' => $payment->tenant_id,
                'date' => $request->payment_date,
                'due_date' => \Carbon\Carbon::parse($request->payment_date)->addDays(30), // 30 days from payment date
                'amount' => $request->amount,
                'status' => 'paid', // Since admin creates payment, mark as paid
                'notes' => 'Admin created payment - ' . ($request->notes ?: 'No additional notes'),
            ]);
        }

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $payment->load(['tenant', 'booking', 'invoice', 'paymentMethod']);
        
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Serve receipt image from database or storage
     */
    public function receiptImage(Payment $payment)
    {
        if (!$payment->receipt_image) {
            abort(404, 'Receipt image not found');
        }

        $path = $payment->receipt_image;
        
        // Check if it's a file path (starts with receipts/ or contains /)
        if (strpos($path, 'receipts/') === 0 || strpos($path, '/') !== false) {
            // It's a file path - try to serve from storage
            $fullPath = storage_path('app/public/' . $path);
            
            // First try Laravel Storage
            if (Storage::disk('public')->exists($path)) {
                $file = Storage::disk('public')->get($path);
                $mimeType = Storage::disk('public')->mimeType($path) ?? $this->detectMimeType($file);
                
                return response($file, 200)
                    ->header('Content-Type', $mimeType)
                    ->header('Content-Disposition', 'inline')
                    ->header('Cache-Control', 'public, max-age=31536000');
            }
            
            // Try direct file system access (for persistent volumes)
            if (file_exists($fullPath)) {
                $file = file_get_contents($fullPath);
                $mimeType = $this->detectMimeType($file) ?? 'image/jpeg';
                
                return response($file, 200)
                    ->header('Content-Type', $mimeType)
                    ->header('Content-Disposition', 'inline')
                    ->header('Cache-Control', 'public, max-age=31536000');
            }
            
            // File doesn't exist - log and return placeholder
            \Log::warning('Payment receipt file not found', [
                'payment_id' => $payment->payment_id,
                'path' => $path,
                'full_path' => $fullPath,
                'storage_exists' => Storage::disk('public')->exists($path),
                'file_exists' => file_exists($fullPath)
            ]);
            
            // Return a helpful placeholder image
            return $this->placeholderImage('File not found: ' . $path);
        }
        
        // Try to decode as base64
        $imageData = base64_decode($path, true);
        if ($imageData !== false && strlen($imageData) > 100) {
            // It's base64 encoded
            $mimeType = $this->detectMimeType($imageData) ?? 'image/jpeg';
            return response($imageData, 200)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'inline')
                ->header('Cache-Control', 'public, max-age=31536000');
        }
        
        // Assume it's binary data stored directly (unlikely with string column)
        $mimeType = $this->detectMimeType($path) ?? 'image/jpeg';
        
        return response($path, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'inline')
            ->header('Cache-Control', 'public, max-age=31536000');
    }
    
    /**
     * Detect MIME type from binary data
     */
    private function detectMimeType($data): ?string
    {
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_buffer($finfo, $data);
            finfo_close($finfo);
            return $mimeType ?: null;
        }
        return null;
    }
    
    /**
     * Return a placeholder SVG image
     */
    private function placeholderImage(string $message): Response
    {
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="400" height="300" viewBox="0 0 400 300">
            <rect width="400" height="300" fill="#f0f0f0"/>
            <text x="50%" y="45%" text-anchor="middle" dy=".3em" fill="#999" font-family="Arial" font-size="14">
                Receipt Image Not Found
            </text>
            <text x="50%" y="55%" text-anchor="middle" dy=".3em" fill="#999" font-family="Arial" font-size="11">
                ' . htmlspecialchars($message) . '
            </text>
            <text x="50%" y="65%" text-anchor="middle" dy=".3em" fill="#999" font-family="Arial" font-size="10">
                File may have been lost due to ephemeral storage
            </text>
        </svg>';
        
        return response($svg, 200)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Cache-Control', 'no-cache');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        $tenants = Tenant::all();
        $bookings = Booking::whereIn('status', ['confirmed', 'completed'])->get();
        $paymentMethods = PaymentMethod::active()->get();
        
        return view('admin.payments.edit', compact('payment', 'tenants', 'bookings', 'paymentMethods'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'tenant_id' => 'required|exists:tenants,tenant_id',
            'booking_id' => 'nullable|exists:bookings,booking_id',
            'method_id' => 'nullable|exists:payment_methods,method_id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'method' => 'required|in:cash,digital_wallet,bank_transfer,credit_card,online,gcash,maya',
            'status' => 'required|in:pending,completed,failed,refunded,reserved',
            'notes' => 'nullable|string|max:1000',
            'receipt_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB max
        ]);

        $data = $request->all();

        // Handle receipt image upload
        if ($request->hasFile('receipt_image')) {
            // Delete old receipt if exists
            if ($payment->receipt_image && Storage::disk('public')->exists($payment->receipt_image)) {
                Storage::disk('public')->delete($payment->receipt_image);
            }
            
            // Store new receipt
            $receiptPath = $request->file('receipt_image')->store('receipts', 'public');
            $data['receipt_image'] = $receiptPath;
        } else {
            // Keep existing receipt_image if no new file is uploaded
            unset($data['receipt_image']);
        }

        $payment->update($data);

        return redirect()->route('admin.payments.show', $payment)
            ->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment deleted successfully.');
    }
}
