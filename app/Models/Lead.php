<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'email',
        'name',
        'phone',
        'source',
        'status',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
        'status' => \App\Enums\LeadStatus::class,
    ];
}
