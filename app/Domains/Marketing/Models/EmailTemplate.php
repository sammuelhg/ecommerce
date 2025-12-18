<?php

namespace App\Domains\Marketing\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = ['name', 'subject', 'body', 'category'];
}
