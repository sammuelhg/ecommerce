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
    /**
     * Merges products with layout rules to create a grid collection.
     *
     * @param \Illuminate\Pagination\LengthAwarePaginator $products
     * @param array $rules  Array of rules where key is the index and value is the card definition
     * @param bool $useDbRules Whether to fetch and merge rules from the database
     * @return Collection
     */
    public function merge($products, array $rules = [], bool $useDbRules = true): Collection
    {
        // 1. Fetch Rules from Database (Active ones)
        // If useDbRules is true, we fetch DB rules and MERGE them with passed rules.
        // Passed rules ($rules) take precedence if keys collide? Or DB?
        // Let's assume passed rules override DB rules if same index.
        
        $finalRules = $rules;

        if ($useDbRules) {
            $dbRules = \App\Models\GridRule::active()->get();
            foreach($dbRules as $r) {
                // If this slot is already defined by passed $rules, skip DB rule? 
                // Or overwrite? Let's say passed rules (hardcoded in controller) might be more specific.
                if (isset($finalRules[$r->position])) {
                    continue; 
                }

                $content = $r->configuration;
                
                // If the rule involves a specific product, we need to load it
                if (isset($content['product_id'])) {
                    $product = \App\Models\Product::find($content['product_id']);
                    if ($product) {
                        if ($r->type === 'card.product_special') {
                             // Preserve config data (badge_type) along with the product
                            $content = ['product' => $product, 'data' => $content];
                        } else {
                            $content = $product;
                        }
                    } else {
                        // Product not found (deleted?), skip this rule to avoid crashing the view
                        continue;
                    }
                }
    
                // Safety check: specific types MUST have a Product object as content (except special card which wraps it)
                if (str_contains($r->type, 'product') && $r->type !== 'card.product_special' && is_array($content)) {
                     // Double check: if it's still an array, it means we failed to hydrate (or it didn't have product_id).
                     // Skip to prevents "property on array" error.
                     continue;
                }
    
                if ($r->type === 'card.newsletter_form') {
                    $content = $r->configuration;
                }
    
                $finalRules[$r->position] = [
                    'type' => $r->type,
                    'col_span' => (int) $r->col_span,
                    'content' => $content
                ];
            }
        }
        
        $rules = $finalRules;

        // ... Rest of logic stays same ...

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



        // Apply smart packing to prevent gaps on desktop
        return $this->packItems($gridItems);
    }

    /**
     * Adjusts item spans to ensure they fit perfectly into the desktop grid (5 columns)
     * without creating gaps.
     * 
     * Logic: If a row has N columns remaining and the next item wants M columns (where M > N),
     * shrink the item to N columns to fill the row exactly.
     */
    private function packItems(Collection $items): Collection
    {
        $desktopCols = 5;
        $currentCol = 0;

        return $items->map(function ($item) use ($desktopCols, &$currentCol) {
            $span = $item['col_span'];
            $remaining = $desktopCols - $currentCol;

            // If the item is larger than the remaining space in the current row
            if ($span > $remaining) {
                // Shrink it to fit!
                $span = $remaining;
            }

            // Update the span in the item array
            $item['col_span'] = $span;

            // Move the cursor forward
            $currentCol = ($currentCol + $span) % $desktopCols;

            return $item;
        });
    }
}
