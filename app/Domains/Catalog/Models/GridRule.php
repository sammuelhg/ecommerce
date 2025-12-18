<?php

namespace App\Domains\Catalog\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Marketing\Models\Form;

class GridRule extends Model
{
    protected $fillable = [
        'position',
        'type',
        'col_span',
        'configuration',
        'is_active',
        'form_id',
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

    public function form(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Form::class);
    }
}
