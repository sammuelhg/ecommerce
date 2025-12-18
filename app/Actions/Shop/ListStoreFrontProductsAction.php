<?php

declare(strict_types=1);

namespace App\Actions\Shop;

use App\Domains\Catalog\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class ListStoreFrontProductsAction
{
    public function execute(int $perPage = 12): LengthAwarePaginator
    {
        // Log para auditoria (Anti-Zombie)
        Log::info("ListStoreFrontProductsAction: Iniciando busca de produtos ativos.");

        $query = Product::query()
            ->with(['images', 'category']) // Eager Loading vital para performance
            ->where('is_active', true)
            ->where('stock', '>', 0) // Regra de negócio: Apenas com estoque?
            ->orderBy('created_at', 'desc');

        $count = $query->count();
        
        if ($count === 0) {
            Log::warning("ListStoreFrontProductsAction: ALERTA - Nenhum produto ativo encontrado no banco.");
        } else {
            Log::info("ListStoreFrontProductsAction: Encontrados {$count} produtos.");
        }

        return $query->paginate($perPage);
    }
}
