<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CampaignClick extends Model
{
    protected $fillable = [
        'campaign_id',
        'newsletter_subscriber_id', // keeping consistency with subscriber id if needed, or link to User?
        'campaign_email_id',
        'url',
        'ip_address',
        'user_agent'
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function subscriber(): BelongsTo
    {
        // Assuming we still link to NewsletterSubscriber for now, or User if unified.
        // Given CampaignOpen uses NewsletterSubscriber, we stick to it or make it nullable.
        return $this->belongsTo(NewsletterSubscriber::class, 'newsletter_subscriber_id');
    }
    
    public function email(): BelongsTo
    {
        return $this->belongsTo(CampaignEmail::class, 'campaign_email_id');
    }
}
