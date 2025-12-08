<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterCampaign extends Model
{
    protected $fillable = ['subject', 'body', 'sent_at', 'status'];
    
    protected $casts = [
        'sent_at' => 'datetime',
    ];
    //
}
