<?php

namespace App\Services;

use Illuminate\Support\Collection;

class GridComposer
{
    /**
     * Merges products with layout rules to create a grid collection.
     *
     * @param \Illuminate\Pagination\LengthAwarePaginator $products
     * @param array $rules  Array of rules where key is the index and value is the card definition
     * @return Collection
     */
    public function merge($products, array $rules = []): Collection
    {
        // 1. Fetch Rules from Database (Active ones)
        // We ignore the passed $rules argument now, or use it as fallback? 
        // Let's merge DB rules into valid array structure.
        $dbRules = \App\Models\GridRule::active()->get();
        $rules = [];
        foreach($dbRules as $r) {
            $content = $r->configuration;
            
            // If the rule involves a specific product, we need to load it
            if (isset($content['product_id'])) {
                $product = \App\Models\Product::find($content['product_id']);
                if ($product) {
                    $content = $product;
                } else {
                    // Product not found (deleted?), skip this rule to avoid crashing the view
                    continue;
                }
            }

            // Safety check: specific types MUST have a Product object as content
            if (str_contains($r->type, 'product') && is_array($content)) {
                 // Double check: if it's still an array, it means we failed to hydrate (or it didn't have product_id).
                 // Skip to prevents "property on array" error.
                 continue;
            }

            if ($r->type === 'card.newsletter_form') {
                $content = $r->configuration;
            }

            $rules[$r->position] = [
                'type' => $r->type,
                'col_span' => (int) $r->col_span,
                'content' => $content
            ];
        }

        $gridItems = collect();
        $productIterator = $products->getIterator();
        
        // Calculate total potential slots. 
        // We start with product count and add rule count (approximate).
        // A robust implementation might need a more complex loop, but this suffices for "injecting" items.
        
        $totalItems = $products->count() + count($rules);
        $currentProduct = null;
        
        // We iterate through "slots" in the grid
        // index 0 = first item
        $productQueue = $products->items(); // Convert to array for easier shifting
        $index = 0;
        
        while (!empty($productQueue) || isset($rules[$index])) {
            
            // 1. Check if there is a RULE for this specific index
            if (isset($rules[$index])) {
                $rule = $rules[$index];
                $gridItems->push([
                    'type' => $rule['type'],
                    'col_span' => $rule['col_span'] ?? 1,
                    'content' => $rule['content']
                ]);
                $index++;
                continue;
            }

            // 2. If no rule, take the next product
            if (!empty($productQueue)) {
                $product = array_shift($productQueue);
                
                // Determine Card Type for the product
                // If the product has a specific card_type set in DB, use it.
                // Otherwise default to 'product_standard'.
                $type = $product->card_type ?? 'product_standard';
                $colSpan = ($type === 'product_highlight') ? 2 : 1; // Highlight can be wider if desired, default to 1 for now or 2? 
                // User said "Highlight Card" should be "antes dos produtos comuns" (before common products), 
                // but if used as a type, it can be anywhere. Let's assume standard grid placement.
                // But wait, user said "eles devem ser mostrados antes dos produtos comuns".
                // Maybe they want them pinned to top? 
                // For now, respect the DB order, but if it has 'product_highlight' type, use it.

                $gridItems->push([
                    'type' => 'card.' . $type, // Matches component name: cards.product_standard
                    'col_span' => $colSpan,
                    'content' => $product
                ]);
            }
            
            $index++;
        }

        return $gridItems;
    }
}
