<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsletterSubscriber; // Added this import

class NewsletterController extends Controller
{
    public function show(\App\Models\Campaign $campaign)
    {
        // New System: Use Campaign model
        $overrideCard = $campaign->signCard;
        $overrideProducts = $campaign->products;
        
        // Mock User for template rendering
        $user = new \App\Models\User(['name' => 'Assinante', 'email' => '']);

        return view('newsletter.show', compact('campaign', 'overrideCard', 'overrideProducts', 'user'));
    }

    // Legacy method - keeping for reference or unused routes, but safer to remove if conflicting
    /* public function preview(\App\Models\NewsletterEmail $email) { ... } */

    public function unsubscribe(Request $request, int $subscriberId)
    {
        if (!$request->hasValidSignature()) {
            abort(403);
        }

        $subscriber = NewsletterSubscriber::findOrFail($subscriberId); // Changed to use imported model
        $subscriber->update(['is_active' => false]);

        return view('newsletter.unsubscribe', compact('subscriber'));
    }

    public function resubscribe(Request $request, int $subscriberId)
    {
         // Optional: logic to reactivate
         $subscriber = NewsletterSubscriber::findOrFail($subscriberId); // Changed to use imported model
         $subscriber->update(['is_active' => true]);
         
         return redirect()->route('shop.index')->with('success', 'Inscrição reativada!');
    }
}
