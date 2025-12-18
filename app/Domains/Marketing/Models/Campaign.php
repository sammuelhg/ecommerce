<?php

namespace App\Domains\Marketing\Models;

use App\Domains\Content\Models\SignCard;
use App\Domains\Catalog\Models\Product;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'status',
        'sign_card_id',
        'email_content_body',
        'sending_rules',
        'generated_revenue',
        'conversion_count',
    ];

    protected $casts = [
        'sending_rules' => 'array', // Use simple array cast for JSON
    ];

    /**
     * The Sign Card that defines the visual identity of this campaign.
     */
    public function signCard(): BelongsTo
    {
        return $this->belongsTo(SignCard::class);
    }

    /**
     * The Products showcased in this campaign.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'campaign_product')
            ->withPivot('order')
            ->orderByPivot('order');
    }

    /**
     * The Forms that feed leads into this campaign.
     */
    public function forms(): HasMany
    {
        return $this->hasMany(Form::class);
    }

    /**
     * The User who owns this campaign.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * The Emails sequence for this campaign.
     */
    public function emails(): HasMany
    {
        return $this->hasMany(CampaignEmail::class)->orderBy('order_index');
    }

    public function getEmailCountAttribute(): int
    {
        return $this->emails()->count();
    }

    /**
     * Get the opens for the campaign.
     */
    public function opens(): HasMany
    {
        return $this->hasMany(CampaignOpen::class, 'newsletter_campaign_id');
    }
}
