<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $primaryKey = 'booking_id';
    protected $fillable = [
        'tenant_id',
        'room_id',
        'booking_date',
        'check_in',
        'check_out',
        'status',
        'total_amount',
        'payment_type',
        'payment_method',
        'ewallet_type',
        'down_payment_amount',
        'payment_receipt',
        'down_payment_receipt',
        'down_payment_date',
        'preferences',
        'emergency_contact',
        'occupancy_type',
        'admin_notes',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'check_in' => 'date',
        'check_out' => 'date',
        'total_amount' => 'decimal:2',
        'down_payment_amount' => 'decimal:2',
        'down_payment_date' => 'date',
    ];

    // Relationships
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'booking_id');
    }

    public function invoices()
    {
        return $this->hasManyThrough(Invoice::class, Payment::class, 'booking_id', 'payment_id');
    }
}
