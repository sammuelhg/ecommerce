<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketingExpense extends Model
{
    protected $fillable = [
        'date',
        'amount',
        'source', // meta, google, tiktok, other
        'description',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];
}
