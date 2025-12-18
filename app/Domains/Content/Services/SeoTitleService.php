<?php

namespace App\Services;

class SeoTitleService
{
    /**
     * Generate an SEO-optimized title for a product variation.
     *
     * Formula: TYPE + MODEL + MATERIAL + COLOR + SIZE
     *
     * @param string $type
     * @param string $model
     * @param string|null $material
     * @param string $color
     * @param string $size
     * @return string
     */
    public function generate(string $type, string $model, ?string $material, string $color, string $size): string
    {
        $parts = [
            ucfirst($type),
            ucfirst($model),
        ];

        if ($material) {
            $parts[] = "em {$material}";
        }

        $parts[] = "– " . ucfirst($color);
        $parts[] = "Tamanho {$size}";

        return implode(' ', $parts);
    }
}
