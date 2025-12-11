<?php

namespace App\Models;

use App\Models\NewsletterCampaign; // Added this line
use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    protected $fillable = [
        'name',
        'email',
        'is_active',
        'source',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_content'
    ];

    public function campaigns(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(NewsletterCampaign::class, 'newsletter_campaign_subscriber')
            ->withPivot('current_email_id', 'started_at', 'completed_at')
            ->withTimestamps();
    }
    //
}
