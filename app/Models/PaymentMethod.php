<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
    protected $primaryKey = 'method_id';
    
    protected $fillable = [
        'name',
        'type',
        'description',
        'configuration',
        'is_active',
        'requires_verification',
        'processing_fee',
        'processing_time_hours',
    ];

    protected $casts = [
        'configuration' => 'array',
        'is_active' => 'boolean',
        'requires_verification' => 'boolean',
        'processing_fee' => 'decimal:2',
    ];

    // Relationships
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'method_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
