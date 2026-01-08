<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Report extends Model
{
    protected $primaryKey = 'report_id';
    protected $fillable = [
        'report_type',
        'generated_by_id',
        'generated_by_type',
        'generated_date',
        'content',
    ];

    protected $casts = [
        'generated_date' => 'date',
    ];

    // Relationships
    public function generatedBy(): MorphTo
    {
        return $this->morphTo('generated_by');
    }
}
