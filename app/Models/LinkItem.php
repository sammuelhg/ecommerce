<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkItem extends Model
{
    protected $fillable = [
        'title',
        'url',
        'icon',
        'color',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static $iconOptions = [
        'house' => 'Casa',
        'bag' => 'Sacola',
        'cart' => 'Carrinho',
        'whatsapp' => 'WhatsApp',
        'instagram' => 'Instagram',
        'facebook' => 'Facebook',
        'tiktok' => 'TikTok',
        'youtube' => 'YouTube',
        'envelope' => 'Email',
        'telephone' => 'Telefone',
        'geo-alt' => 'Localização',
        'link-45deg' => 'Link',
    ];

    public static $colorOptions = [
        'white' => ['label' => 'Branco', 'bg' => '#ffffff', 'text' => '#000000', 'style' => 'background: #ffffff;'],
        'black' => ['label' => 'Preto', 'bg' => '#000000', 'text' => '#ffffff', 'style' => 'background: #000000;'],
        'green' => ['label' => 'WhatsApp', 'bg' => '#25D366', 'text' => '#ffffff', 'style' => 'background: #25D366;'],
        'instagram' => ['label' => 'Instagram', 'bg' => '#E4405F', 'text' => '#ffffff', 'style' => 'background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);'],
        'gold' => ['label' => 'Dourado', 'bg' => '#C9A04B', 'text' => '#000000', 'style' => 'background: linear-gradient(135deg, #C9A04B 0%, #e6c77a 35%, #f0d890 70%, #A9843F 100%);'],
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    public function getColorStyleAttribute()
    {
        $colors = self::$colorOptions[$this->color] ?? self::$colorOptions['white'];
        return $colors['style'] . " color: {$colors['text']};";
    }
}
