<?php

namespace App\Domains\Marketing\Models;

use App\Domains\Content\Models\SignCard;
use App\Domains\Catalog\Models\Product;
use App\Domains\Marketing\Models\Lead;
use App\Domains\Marketing\Models\NewsletterEmail;
use Illuminate\Database\Eloquent\Model;

class NewsletterCampaign extends Model
{
    protected $fillable = ['name', 'subject', 'sent_at', 'status', 'email_card_id', 'slug', 'promo_image_url', 'show_promo_image_in_email', 'is_active'];
    
    protected $casts = [
        'sent_at' => 'datetime',
        'status' => \App\Enums\CampaignStatus::class,
        'is_active' => 'boolean', // Ensure casts to bool
    ];

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('id', $value)
            ->orWhere('slug', $value)
            ->firstOrFail();
    }

    public function emailCard(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SignCard::class, 'email_card_id');
    }

    public function emails(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(NewsletterEmail::class)->orderBy('step_order');
    }

    // Deprecated: Access products via emails->first()->products
    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->emails()->first()?->products() ?? $this->belongsToMany(Product::class, 'newsletter_campaign_products_deprecated'); // Fallback or null
    }

    public function subscribers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Lead::class, 'newsletter_campaign_subscriber', 'newsletter_campaign_id', 'lead_id')
            ->withPivot('current_email_id', 'started_at', 'completed_at')
            ->withTimestamps();
    }
}
