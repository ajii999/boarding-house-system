<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    protected $primaryKey = 'payment_id';
    protected $fillable = [
        'tenant_id',
        'booking_id',
        'method_id',
        'amount',
        'payment_date',
        'method',
        'status',
        'notes',
        'receipt_image',
        'reservation_expires_at',
        'verification_code',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
        'reservation_expires_at' => 'datetime',
    ];

    // Relationships
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class, 'payment_id');
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'method_id');
    }

    // Scopes
    public function scopeReserved($query)
    {
        return $query->where('status', 'reserved');
    }

    public function scopeExpired($query)
    {
        return $query->where('reservation_expires_at', '<', now());
    }

    // Methods
    public function isReserved(): bool
    {
        return $this->status === 'reserved' && $this->reservation_expires_at > now();
    }

    public function isExpired(): bool
    {
        return $this->reservation_expires_at && $this->reservation_expires_at < now();
    }
}
