<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'sku',
        'description',
        'marketing_description',
        'price',
        'stock',
        'is_active',
        'image',
        'product_type_id',
        'product_model_id',
        'product_material_id',
        'product_color_id',
        'product_size_id',
        'color',
        'attribute',
        'size',
    ];

    protected $appends = ['image'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function productModel()
    {
        return $this->belongsTo(ProductModel::class);
    }

    public function productMaterial()
    {
        return $this->belongsTo(ProductMaterial::class);
    }

    public function productColor()
    {
        return $this->belongsTo(ProductColor::class);
    }

    public function productSize()
    {
        return $this->belongsTo(ProductSize::class);
    }

    /**
     * Get the items included in this product (if it is a kit).
     */
    public function bundleItems()
    {
        return $this->belongsToMany(Product::class, 'product_bundles', 'kit_id', 'product_id')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    /**
     * Check if the product is a kit.
     */
    public function isKit()
    {
        // Check if product_type_id exists and matches KIT
        if (!$this->product_type_id) {
            return false;
        }

        // If relationship is loaded, use it
        if ($this->relationLoaded('productType')) {
            return $this->productType && $this->productType->code === 'KIT';
        }

        // Otherwise, query the type directly
        $type = ProductType::find($this->product_type_id);
        return $type && $type->code === 'KIT';
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the product image.
     * Fallback to the first image in product_images table if the main image column is empty.
     */
    public function getImageAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }

        // Try to get from relationship if loaded, otherwise query
        $image = $this->relationLoaded('images') 
            ? $this->images->first() 
            : $this->images()->orderBy('order')->first();

        return $image ? $image->path : null;
    }
}
