<?php

namespace App\Domains\Content\Models;

use Illuminate\Database\Eloquent\Model;

class CmsComponent extends Model
{
    protected $fillable = [
        'name',
        'type',
        'data',
        'image_preview',
    ];

    protected $casts = [
        'data' => 'array',
    ];
}
