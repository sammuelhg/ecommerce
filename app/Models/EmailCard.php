<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailCard extends Model
{
    protected $fillable = [
        'name',
        'sender_name',
        'sender_role',
        'instagram',
        'whatsapp',
        'website',
        'slogan',
        'photo',
        'is_default',
        'is_active',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    public static function getDefault()
    {
        return static::active()->default()->first() 
            ?? static::active()->first();
    }

    public function setAsDefault()
    {
        static::where('is_default', true)->update(['is_default' => false]);
        $this->update(['is_default' => true]);
    }
}
