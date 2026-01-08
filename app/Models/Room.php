<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $primaryKey = 'room_id';
    protected $fillable = [
        'room_number',
        'room_type',
        'status',
        'price',
        'pricing_period',
        'description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // Relationships
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'room_id');
    }

    public function maintenanceRequests(): HasMany
    {
        return $this->hasMany(MaintenanceRequest::class, 'room_id');
    }
}
