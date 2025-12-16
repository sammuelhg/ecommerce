<?php

namespace App\Actions\Cms;

use App\Models\Page;
use App\Cms\BlockFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdatePageContentAction
{
    public function execute(Page $page, array $blocksData): Page
    {
        // 1. Sanitization and Validation
        $processedBlocks = [];
        
        foreach ($blocksData as $blockRaw) {
            try {
                // Validate structure
                if (!isset($blockRaw['type'])) {
                    continue; 
                }

                // Factory creates the typed object (validating data in constructor/fromArray)
                $blockInstance = BlockFactory::create($blockRaw['type'], $blockRaw);
                $processedBlocks[] = $blockInstance->toArray();

            } catch (\Exception $e) {
                Log::warning("CMS: Failed to process block", [
                    'page_id' => $page->id,
                    'block_raw' => $blockRaw,
                    'error' => $e->getMessage()
                ]);
                // We skip invalid blocks to prevent "Zombie Data" from crashing the page
            }
        }

        // 2. Persistence
        DB::transaction(function () use ($page, $processedBlocks) {
            $page->update([
                'content' => $processedBlocks // Saves the sanitized array
            ]);
        });

        return $page;
    }
}
