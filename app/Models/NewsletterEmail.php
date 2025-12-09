<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterEmail extends Model
{
    protected $fillable = [
        'newsletter_campaign_id',
        'subject',
        'body',
        'delay_in_hours',
        'sort_order',
        'status',
    ];

    public function campaign(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(NewsletterCampaign::class, 'newsletter_campaign_id');
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'newsletter_email_product')
            ->withPivot('sort_order')
            ->orderByPivot('sort_order');
    }

    public function opens(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CampaignOpen::class, 'newsletter_email_id');
    }
}
