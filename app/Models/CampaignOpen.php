<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignOpen extends Model
{
    protected $fillable = ['newsletter_campaign_id', 'newsletter_subscriber_id', 'newsletter_email_id', 'ip_address', 'user_agent'];

    public function campaign()
    {
        return $this->belongsTo(NewsletterCampaign::class, 'newsletter_campaign_id');
    }

    public function subscriber()
    {
        return $this->belongsTo(NewsletterSubscriber::class, 'newsletter_subscriber_id');
    }
}
