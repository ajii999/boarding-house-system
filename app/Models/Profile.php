<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $fillable = [
        'tenant_id',
        'address',
        'emergency_contact',
        'profile_picture',
        'date_of_birth',
        'occupation',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    // Relationships
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
