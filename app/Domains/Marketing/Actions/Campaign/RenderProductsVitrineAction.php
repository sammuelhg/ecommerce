<?php

declare(strict_types=1);

namespace App\Actions\Campaign;

use Illuminate\Support\Collection;

class RenderProductsVitrineAction
{
    public function execute(Collection $products): string
    {
        if ($products->isEmpty()) {
            return '';
        }

        $html = '<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 30px; margin-bottom: 30px;">';
        $html .= '<tr><td align="center" style="font-family: sans-serif; font-size: 18px; font-weight: bold; padding-bottom: 20px; color: #333;">Destaques para você</td></tr>';
        
        // Items per row (2 items for better mobile)
        $chunked = $products->chunk(2);

        foreach ($chunked as $row) {
            $html .= '<tr><td align="center"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr>';
            
            foreach ($row as $product) {
                // Formatting
                $price = number_format((float)$product->price, 2, ',', '.');
                $oldPriceHtml = '';
                if ($product->old_price && $product->old_price > $product->price) {
                    $oldPrice = number_format((float)$product->old_price, 2, ',', '.');
                    $oldPriceHtml = "<span style='text-decoration: line-through; color: #999; font-size: 12px; margin-right: 5px;'>R$ {$oldPrice}</span>";
                }
                
                $imageUrl = $product->image 
                    ? (str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image))
                    : 'https://placehold.co/300x300?text=Produto';

                $productUrl = route('shop.show', $product->slug);

                $html .= <<<ITEM
                <td width="50%" valign="top" style="padding: 10px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #eeeeee; border-radius: 8px; overflow: hidden;">
                        <tr>
                            <td>
                                <a href="{$productUrl}" target="_blank" style="text-decoration: none; display: block;">
                                    <img src="{$imageUrl}" alt="{$product->name}" width="100%" style="display: block; width: 100%; max-width: 280px; height: auto;">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 15px; text-align: center;">
                                <h3 style="margin: 0 0 10px; font-family: sans-serif; font-size: 14px; color: #333; height: 36px; overflow: hidden;">{$product->name}</h3>
                                <div style="margin-bottom: 10px; font-family: sans-serif;">
                                    {$oldPriceHtml}
                                    <strong style="color: #e91e63; font-size: 16px;">R$ {$price}</strong>
                                </div>
                                <a href="{$productUrl}" target="_blank" style="display: inline-block; padding: 8px 16px; background-color: #333; color: #ffffff; text-decoration: none; border-radius: 4px; font-family: sans-serif; font-size: 12px; font-weight: bold;">VER DETALHES</a>
                            </td>
                        </tr>
                    </table>
                </td>
ITEM;
            }

            // Fill empty cell if odd number
            if ($row->count() < 2) {
                $html .= '<td width="50%" valign="top"></td>';
            }

            $html .= '</tr></table></td></tr>';
        }

        $html .= '</table>';

        return $html;
    }
}
