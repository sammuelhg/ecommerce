<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'form_id',
        'email',
        'name',
        'phone',
        'source',
        'status',
        'data',
        'ip_address',
        'user_agent',
        'opened_at',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
    ];

    protected $casts = [
        'data' => 'array',
        'opened_at' => 'datetime',
        'status' => \App\Enums\LeadStatus::class,
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
