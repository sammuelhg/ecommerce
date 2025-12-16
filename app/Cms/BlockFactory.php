<?php

namespace App\Cms;

use App\Cms\Contracts\PageBlockInterface;
use App\Cms\Blocks\HeroBlock;
use App\Cms\Blocks\TextBlock;
use App\Cms\Blocks\ContactBlock;
use App\Cms\Blocks\FaqBlock;
use InvalidArgumentException;

class BlockFactory
{
    protected static array $map = [
        'hero' => HeroBlock::class,
        'text' => TextBlock::class,
        'faq' => FaqBlock::class,
        'contact' => ContactBlock::class,
    ];

    public static function create(string $type, array $data): PageBlockInterface
    {
        if (!array_key_exists($type, self::$map)) {
            throw new InvalidArgumentException("Unknown block type: {$type}");
        }

        $class = self::$map[$type];
        
        // Ensure data is valid for fromArray if needed, or pass directly.
        // The interface defines fromArray(array $data).
        
        return $class::fromArray($data);
    }

    public static function getAvailableBlocks(): array
    {
        $blocks = [];
        foreach (self::$map as $type => $class) {
            $blocks[$type] = $class::label();
        }
        return $blocks;
    }
}
