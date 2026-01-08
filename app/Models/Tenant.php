<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Tenant extends Model
{
    protected $primaryKey = 'tenant_id';
    protected $fillable = [
        'name',
        'email',
        'contact_number',
        'profile_picture',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    // Relationships
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class, 'tenant_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'tenant_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'tenant_id');
    }

    public function maintenanceRequests(): HasMany
    {
        return $this->hasMany(MaintenanceRequest::class, 'tenant_id');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'tenant_id');
    }

    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'generated_by');
    }
}
