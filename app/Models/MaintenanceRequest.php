<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaintenanceRequest extends Model
{
    protected $primaryKey = 'request_id';
    protected $fillable = [
        'tenant_id',
        'room_id',
        'issue_type',
        'description',
        'request_date',
        'priority',
        'status',
        'assigned_staff_id',
        'tenant_photo',
        'staff_proof_photo',
        'staff_report',
        'assigned_at',
        'started_at',
        'completed_at',
        'tenant_confirmed_at',
        'closed_at',
        'assignment_notes',
        'admin_notes',
    ];

    protected $casts = [
        'request_date' => 'date',
        'assigned_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'tenant_confirmed_at' => 'datetime',
        'closed_at' => 'datetime',
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

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'maintenance_request_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'notifiable_id');
    }

    public function assignedStaff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'assigned_staff_id');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'request_id';
    }
}
