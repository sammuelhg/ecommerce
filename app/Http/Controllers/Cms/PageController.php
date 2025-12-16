<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

use App\Cms\BlockFactory;

class PageController extends Controller
{
    public function show(Page $page)
    {
        if (!$page->is_active) {
            abort(404);
        }

        $renderedBlocks = [];
        if ($page->content) {
            foreach ($page->content as $blockData) {
                try {
                    $block = BlockFactory::create($blockData['type'], $blockData);
                    $renderedBlocks[] = $block->render();
                } catch (\Exception $e) {
                    // Fail silently for corrupted blocks in frontend
                    continue;
                }
            }
        }

        return view('cms.page', [
            'page' => $page,
            'renderedContent' => implode("\n", $renderedBlocks)
        ]);
    }
}
