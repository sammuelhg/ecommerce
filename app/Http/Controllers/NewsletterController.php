<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domains\Marketing\Models\Lead; // Changed from NewsletterSubscriber

class NewsletterController extends Controller
{
    public function show(\App\Domains\Marketing\Models\Campaign $campaign)
    {
        // New System: Use Campaign model
        $overrideCard = $campaign->signCard;
        $overrideProducts = $campaign->products;
        
        // Mock User for template rendering
        $user = new \App\Models\User(['name' => 'Assinante', 'email' => '']);

        return view('newsletter.show', compact('campaign', 'overrideCard', 'overrideProducts', 'user'));
    }

    // Legacy method - keeping for reference or unused routes, but safer to remove if conflicting
    /* public function preview(\App\Domains\Marketing\Models\NewsletterEmail $email) { ... } */

    public function unsubscribe(Request $request, int $leadId)
    {
        if (!$request->hasValidSignature()) {
            abort(403);
        }

        $lead = Lead::findOrFail($leadId);
        $lead->update(['status' => 'unsubscribed']); // Changed column/value

        // View likely expects $subscriber variable, passing as such for compatibility or refactor view
        // Let's pass as 'subscriber' to avoid breaking view
        return view('newsletter.unsubscribe', ['subscriber' => $lead]);
    }

    public function resubscribe(Request $request, int $leadId)
    {
         // Optional: logic to reactivate
         $lead = Lead::findOrFail($leadId);
         $lead->update(['status' => 'active']);
         
         return redirect()->route('shop.index')->with('success', 'Inscrição reativada!');
    }
}
