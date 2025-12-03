<?php

namespace App\Services;

use App\Models\Product;

class SkuGeneratorService
{
    private const CATEGORY_CODES = [
        'calcado'       => 'CAL',
        'roupa'         => 'ROU',
        'acessorio'     => 'ACE',
        'modafit'       => 'FIT',
        'modapraia'     => 'PRA',
        'modacroche'    => 'CRO',
        'modacroche^e'  => 'CRO', // Variação com acento normalizado
        'losfitnutri'   => 'SUP',
        'suplementos'   => 'SUP',
    ];

    private const TYPE_CODES = [
        'tenis'   => 'TEN',
        'camisa'  => 'CAM',
        'bermuda' => 'BER',
        'jaqueta' => 'JAQ',
    ];

    private const COLOR_CODES = [
        'preto'        => 'PRT',
        'branco'       => 'BRA',
        'azul marinho' => 'AZM',
        'vermelho'     => 'VER',
        'verde'        => 'VRD',
        'cinza'         => 'CIN',
    ];

    public function generate(string $category, string $type, string $color, string $size, ?int $excludeId = null): string
    {
        if (!$category || !$type || !$color || !$size) {
            return '';
        }

        $categoryCode = $this->getCategoryCode($category);
        $typeCode     = $this->getTypeCode($type);
        $colorCode    = $this->getColorCode($color);
        $sizeCode     = strtoupper(trim($size));

        $sequenceNumber = $this->getNextSequenceNumber($excludeId);

        return implode('-', [
            $categoryCode,
            $typeCode,
            $sequenceNumber,
            $colorCode,
            $sizeCode
        ]);
    }

    private function getNextSequenceNumber(?int $excludeId = null): string
    {
        $query = Product::whereNotNull('sku')->where('sku', '!=', '');

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        $last = $query
            ->orderByRaw("CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(sku,'-',3),'-',-1) AS UNSIGNED) DESC")
            ->first();

        if (!$last || !$last->sku) {
            return '0001';
        }

        $parts = explode('-', $last->sku);

        if (isset($parts[2]) && is_numeric($parts[2])) {
            return str_pad(((int) $parts[2]) + 1, 4, '0', STR_PAD_LEFT);
        }

        return '0001';
    }

    private function normalize(string $value): string
    {
        $value = trim($value);
        $value = iconv('UTF-8', 'ASCII//TRANSLIT', $value);
        // Remove caracteres especiais gerados pela transliteração (como ^)
        $value = preg_replace('/[^a-zA-Z0-9]/', '', $value);
        return strtolower($value);
    }

    private function getCategoryCode(string $category): string
    {
        $key = $this->normalize($category);
        return self::CATEGORY_CODES[$key] ?? strtoupper(substr($key, 0, 3));
    }

    private function getTypeCode(string $type): string
    {
        $key = $this->normalize($type);
        return self::TYPE_CODES[$key] ?? strtoupper(substr($key, 0, 3));
    }

    private function getColorCode(string $color): string
    {
        $key = $this->normalize($color);
        return self::COLOR_CODES[$key] ?? strtoupper(substr($key, 0, 3));
    }
}
