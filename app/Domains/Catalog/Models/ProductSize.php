<?php

namespace App\Domains\Catalog\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    protected $fillable = [
        'name',
        'code',
        'is_active',
    ];
}
