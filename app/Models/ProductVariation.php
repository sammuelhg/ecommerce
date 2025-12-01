<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    protected $fillable = [
        'product_id',
        'sku',
        'gtin',
        'type',
        'model',
        'color',
        'size',
        'price',
        'stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the effective price (variation price or parent price).
     */
    public function getEffectivePriceAttribute()
    {
        return $this->price ?? $this->product->price;
    }
}
