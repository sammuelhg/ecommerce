<?php

namespace App\Helpers;

class ColorHelper
{
    /**
     * Mapeamento de nomes de cores para códigos hexadecimais
     */
    private static $colorMap = [
        // Cores básicas
        'preto' => '#000000',
        'branco' => '#FFFFFF',
        'cinza' => '#808080',
        'cinza claro' => '#D3D3D3',
        'cinza escuro' => '#A9A9A9',
        
        // Vermelhos
        'vermelho' => '#FF0000',
        'vermelho escuro' => '#8B0000',
        'bordô' => '#800020',
        'vinho' => '#722F37',
        
        // Azuis
        'azul' => '#0000FF',
        'azul claro' => '#87CEEB',
        'azul escuro' => '#00008B',
        'azul marinho' => '#000080',
        'azul royal' => '#4169E1',
        'turquesa' => '#40E0D0',
        
        // Verdes
        'verde' => '#008000',
        'verde claro' => '#90EE90',
        'verde escuro' => '#006400',
        'verde limão' => '#32CD32',
        'verde água' => '#7FFFD4',
        'verde militar' => '#4B5320',
        
        // Amarelos/Laranjas
        'amarelo' => '#FFFF00',
        'amarelo ouro' => '#FFD700',
        'laranja' => '#FFA500',
        'laranja queimado' => '#CC5500',
        'coral' => '#FF7F50',
        
        // Rosas/Roxos
        'rosa' => '#FFC0CB',
        'rosa choque' => '#FF1493',
        'rosa bebê' => '#FFB6C1',
        'roxo' => '#800080',
        'lilás' => '#C8A2C8',
        'violeta' => '#EE82EE',
        
        // Marrons
        'marrom' => '#964B00',
        'marrom claro' => '#D2691E',
        'bege' => '#F5F5DC',
        'caramelo' => '#C68E17',
        
        // Outros
        'nude' => '#E3BC9A',
        'dourado' => '#FFD700',
        'prateado' => '#C0C0C0',
        'off white' => '#FAF9F6',
        'creme' => '#FFFDD0',
    ];

    /**
     * Retorna o código hexadecimal para um nome de cor
     */
    public static function getHex(string $colorName): string
    {
        $normalized = strtolower(trim($colorName));
        
        // Se já é um código hex, retorna
        if (preg_match('/^#[0-9A-Fa-f]{6}$/', $colorName)) {
            return $colorName;
        }
        
        return self::$colorMap[$normalized] ?? '#CCCCCC'; // Cinza padrão se não encontrar
    }

    /**
     * Retorna um array com nome e hex
     */
    public static function getColorData(string $colorName): array
    {
        return [
            'name' => $colorName,
            'hex' => self::getHex($colorName)
        ];
    }
}
