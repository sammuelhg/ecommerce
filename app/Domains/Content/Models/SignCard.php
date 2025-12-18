<?php

namespace App\Domains\Content\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SignCard extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'avatar_url',
        'signature_text',
        'role',
        'slogan',
        'whatsapp',
        'instagram',
        'website',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getAvatarUrlAttribute($value)
    {
        if (!$value) {
            return null; // Return null to allow view-level fallback (e.g. show Logo instead of Photo)
        }

        if (str_starts_with($value, 'http')) {
            return $value;
        }

        // Ensure leading slash for local paths
        return '/' . ltrim($value, '/');
    }
}
