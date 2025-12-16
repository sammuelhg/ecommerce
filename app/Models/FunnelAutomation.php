<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FunnelAutomation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'trigger_event',
        'trigger_operator',
        'trigger_value',
        'action_type',
        'action_payload',
        'is_active',
    ];

    protected $casts = [
        'action_payload' => 'array',
        'is_active' => 'boolean',
    ];
}
