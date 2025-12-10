<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class PixelController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        $lead = Lead::find($id);

        if ($lead) {
            $lead->update([
                'opened_at' => now(),
                'status' => $lead->status === 'new' ? 'opened' : $lead->status,
            ]);
        }

        // Return 1x1 Transparent GIF
        $content = base64_decode('R0lGODlhAQABAJAAAP8AAAAAACH5BAUQAAAALAAAAAABAAEAAAICBAEAOw==');

        return response($content, 200)
            ->header('Content-Type', 'image/gif')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }
}
