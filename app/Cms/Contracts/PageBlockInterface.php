<?php

namespace App\Cms\Contracts;

interface PageBlockInterface
{
    /**
     * The unique type identifier for the block (e.g., 'hero', 'text').
     */
    public static function type(): string;

    /**
     * The human-readable label for the block.
     */
    public static function label(): string;

    /**
     * Convert the block data to an array for storage.
     */
    public function toArray(): array;

    /**
     * Render the block to HTML.
     */
    public function render(): string;

    /**
     * Create a new instance of the block from stored array data.
     */
    public static function fromArray(array $data): self;
}
