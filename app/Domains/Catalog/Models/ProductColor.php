<?php

namespace App\Domains\Catalog\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    protected $fillable = [
        'name',
        'code',
        'hex_code',
        'is_active',
    ];
}
