<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBundle extends Model
{
    use HasFactory;

    protected $fillable = [
        'kit_id',
        'product_id',
        'quantity',
    ];

    /**
     * Get the kit product that owns this bundle item.
     */
    public function kit()
    {
        return $this->belongsTo(Product::class, 'kit_id');
    }

    /**
     * Get the component product that is part of this bundle.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
