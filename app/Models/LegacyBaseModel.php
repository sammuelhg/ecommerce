<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class LegacyBaseModel extends Model
{
    // Define a conexão para todos os filhos
    protected $connection = 'legacy';

    // DICA: Se o banco antigo não tem timestamps (created_at/updated_at),
    // descomente a linha abaixo:
    // public $timestamps = false;
}
