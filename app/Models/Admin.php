<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Model
{
    protected $primaryKey = 'admin_id';
    protected $fillable = [
        'master_id',
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    // Relationships
    public function tenants(): HasMany
    {
        return $this->hasMany(Tenant::class, 'admin_id');
    }

    public function reports(): HasMany
    {
        return $this->morphMany(Report::class, 'generated_by');
    }
}
