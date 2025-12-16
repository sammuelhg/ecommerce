<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PersistUtmMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $utmFields = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'];
        $utmData = [];
        $hasUtm = false;

        foreach ($utmFields as $field) {
            if ($request->has($field)) {
                $utmData[$field] = $request->query($field);
                $hasUtm = true;
            }
        }

        if ($hasUtm) {
            session(['utm_tracking' => $utmData]);
        }

        return $next($request);
    }
}
