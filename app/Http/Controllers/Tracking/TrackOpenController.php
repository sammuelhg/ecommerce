<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tracking;

use App\Http\Controllers\Controller;
use App\Jobs\RecordCampaignOpen;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TrackOpenController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $campaign, int $lead): Response
    {
        // Dispatch job immediately to record the open attempt
        RecordCampaignOpen::dispatch(
            $campaign,
            $lead,
            $request->ip(),
            $request->userAgent(),
            $request->input('email_id') // Pass email_id from query string
        );

        // Return a transparent 1x1 GIF
        $pixel = base64_decode('R0lGODlhAQABAJAAAP8AAAAAACH5BAUQAAAALAAAAAABAAEAAAICBAEAOw==');

        return response($pixel, 200, [
            'Content-Type' => 'image/gif',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0, post-check=0, pre-check=0',
            'Pragma' => 'no-cache',
            'Expires' => 'Sat, 01 Jan 2000 00:00:00 GMT',
        ]);
    }
}
