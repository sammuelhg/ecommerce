<?php

namespace App\Services;

use App\Models\Product;

class SkuGeneratorService
{
    /**
     * Lookup tables for standardized codes.
     */
    private const CATEGORY_CODES = [
        'calçado' => 'CAL',
        'roupa' => 'ROU',
        'acessório' => 'ACE',
        'modafit' => 'FIT',
        'modapraia' => 'PRA',
        'modacrochê' => 'CRO',
        'modacroche' => 'CRO',
        'losfitnutri' => 'SUP',
    ];

    private const TYPE_CODES = [
        'tênis' => 'TEN',
        'camisa' => 'CAM',
        'bermuda' => 'BER',
        'jaqueta' => 'JAQ',
    ];

    private const COLOR_CODES = [
        'preto' => 'PRT',
        'branco' => 'BRA',
        'azul marinho' => 'AZM',
        'vermelho' => 'VER',
        'verde' => 'VRD',
        'cinza' => 'CIN',
    ];

    /**
     * Generate a SKU with sequential number.
     *
     * @param string $category
     * @param string $type
     * @param string $color
     * @param string $size
     * @param int|null $excludeId Product ID to exclude when checking for last number (for edits)
     * @return string
     */
    public function generate(string $category, string $type, string $color, string $size, ?int $excludeId = null): string
    {
        $categoryCode = $this->getCategoryCode($category);
        $typeCode = $this->getTypeCode($type);
        $colorCode = $this->getColorCode($color);
        $sizeCode = strtoupper($size);

        // Get next sequential number
        $sequenceNumber = $this->getNextSequenceNumber($excludeId);

        return implode('-', [$categoryCode, $typeCode, $sequenceNumber, $colorCode, $sizeCode]);
    }

    /**
     * Get the next available sequence number (4 digits).
     */
    private function getNextSequenceNumber(?int $excludeId = null): string
    {
        // Get the last product SKU (excluding current product if editing)
        $query = Product::whereNotNull('sku')->where('sku', '!=', '');
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        $lastProduct = $query->orderBy('id', 'desc')->first();

        if (!$lastProduct || !$lastProduct->sku) {
            return '0001';
        }

        // Extract the sequence number from SKU (format: XXX-XXX-0000-XXX-XX)
        $parts = explode('-', $lastProduct->sku);
        
        if (count($parts) >= 3 && is_numeric($parts[2])) {
            $lastNumber = (int) $parts[2];
            $nextNumber = $lastNumber + 1;
            
            // Format with 4 digits
            return str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        }

        return '0001';
    }

    private function getCategoryCode(string $category): string
    {
        $normalized = strtolower($category);
        return self::CATEGORY_CODES[$normalized] ?? strtoupper(substr($category, 0, 3));
    }

    private function getTypeCode(string $type): string
    {
        $normalized = strtolower($type);
        return self::TYPE_CODES[$normalized] ?? strtoupper(substr($type, 0, 3));
    }

    private function getColorCode(string $color): string
    {
        $normalized = strtolower($color);
        return self::COLOR_CODES[$normalized] ?? strtoupper(substr($color, 0, 3));
    }
}
