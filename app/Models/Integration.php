<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Integration extends Model
{
    protected $fillable = [
        'provider',
        'name',
        'credentials',
        'is_active',
        'last_synced_at',
    ];

    protected $casts = [
        'credentials' => 'encrypted:array', // MAGIA: Criptografa ao salvar, descriptografa ao ler
        'is_active' => 'boolean',
        'last_synced_at' => 'datetime',
    ];
}
