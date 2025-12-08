<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'image_path',
        'link_url',
        'expires_at',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
