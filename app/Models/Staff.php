<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Staff extends Model
{
    protected $primaryKey = 'staff_id';
    protected $fillable = [
        'name',
        'role',
        'contact_number',
        'email',
        'password',
        'profile_picture',
    ];

    // Relationships
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'staff_id');
    }

    public function taskNotifications(): HasMany
    {
        return $this->hasMany(TaskNotification::class, 'staff_id');
    }

    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'generated_by');
    }
}
