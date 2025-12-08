<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GridRule extends Model
{
    protected $fillable = [
        'position',
        'type',
        'col_span',
        'configuration',
        'is_active',
    ];

    protected $casts = [
        'configuration' => 'array',
        'is_active' => 'boolean',
        'col_span' => 'integer',
        'position' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
