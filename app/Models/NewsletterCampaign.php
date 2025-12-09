<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterCampaign extends Model
{
    protected $fillable = ['subject', 'sent_at', 'status', 'email_card_id', 'slug', 'promo_image_url', 'show_promo_image_in_email'];
    
    protected $casts = [
        'sent_at' => 'datetime',
        'status' => \App\Enums\CampaignStatus::class,
    ];

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('id', $value)
            ->orWhere('slug', $value)
            ->firstOrFail();
    }

    public function emailCard(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(EmailCard::class);
    }

    public function emails(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(NewsletterEmail::class)->orderBy('sort_order');
    }

    // Deprecated: Access products via emails->first()->products
    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->emails()->first()?->products() ?? $this->belongsToMany(Product::class, 'newsletter_campaign_products_deprecated'); // Fallback or null
    }

    public function subscribers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(NewsletterSubscriber::class, 'newsletter_campaign_subscriber')
            ->withPivot('current_email_id', 'started_at', 'completed_at')
            ->withTimestamps();
    }
}
