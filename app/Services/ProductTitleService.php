<?php

namespace App\Services;

use App\Models\ProductType;
use App\Models\ProductModel;
use App\Models\ProductMaterial;

class ProductTitleService
{
    /**
     * Generate a product title based on its attributes.
     *
     * @param int|null $typeId
     * @param int|null $modelId
     * @param int|null $materialId
     * @param string|null $attribute
     * @param string|null $color
     * @param string|null $size
     * @return string
     */
    public function generateTitle($typeId, $modelId, $materialId, $attribute, $color, $size): string
    {
        $parts = [];

        if (!empty($typeId)) {
            $type = ProductType::find($typeId);
            if ($type) {
                $parts[] = $type->name;
            }
        }

        if (!empty($modelId)) {
            $model = ProductModel::find($modelId);
            if ($model) {
                $parts[] = $model->name;
            }
        }

        if (!empty($materialId)) {
            $material = ProductMaterial::find($materialId);
            if ($material) {
                $parts[] = "em {$material->name}";
            }
        }

        // Atributo Genérico (antes da cor)
        if (!empty($attribute)) {
            $parts[] = $attribute;
        }

        if (!empty($color)) {
            $parts[] = "– {$color}";
        }

        // Apply title case to all parts except size
        $title = '';
        if (!empty($parts)) {
            $title = ucwords(strtolower(implode(' ', $parts)));
        }
        
        // Add size without case transformation to preserve GG, PP, etc.
        if (!empty($size)) {
            $title .= ($title ? ' ' : '') . "Tamanho {$size}";
        }

        return $title;
    }
}
