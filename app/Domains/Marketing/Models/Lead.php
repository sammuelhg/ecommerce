<?php

namespace App\Domains\Marketing\Models;

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

    /**
     * Scope a query to only include subscribed leads.
     */
    public function scopeSubscribed($query)
    {
        return $query->where('status', 'active')
                     ->where(function($q) {
                         $q->where('source', 'newsletter')
                           ->orWhere('source', 'like', '%newsletter%');
                     });
    }

    /**
     * Get the campaigns for this lead (migrated from subscribers).
     */
    public function campaigns(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(NewsletterCampaign::class, 'newsletter_campaign_subscriber', 'lead_id', 'newsletter_campaign_id')
            ->withPivot('current_email_id', 'started_at', 'completed_at')
            ->withTimestamps();
    }
}
