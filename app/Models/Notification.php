<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notification extends Model
{
    protected $primaryKey = 'notification_id';
    protected $fillable = [
        'notifiable_id',
        'notifiable_type',
        'type',
        'title',
        'message',
        'data',
        'status',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'data' => 'array',
    ];

    // Relationships
    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'notification_id';
    }
}
