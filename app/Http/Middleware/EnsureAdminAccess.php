<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminAccess
{
    /**
     * Emails authorized to access admin panel.
     * Add additional admin emails to this array as needed.
     */
    protected array $allowedAdmins = [
        'sammuelhg@gmail.com',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Must be authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Must be in the allowed admins list
        $userEmail = strtolower(auth()->user()->email);
        if (!in_array($userEmail, array_map('strtolower', $this->allowedAdmins))) {
            return redirect()->route('customer.account.profile.edit');
        }

        return $next($request);
    }
}
