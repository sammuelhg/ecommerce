<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsletterSubscriber; // Added this import

class NewsletterController extends Controller
{
    public function show(\App\Models\NewsletterCampaign $campaign)
    {
        // Helper to render public view
        $overrideCard = $campaign->email_card_id ? \App\Models\EmailCard::find($campaign->email_card_id) : null;
        $overrideProducts = $campaign->products;
        $user = new \App\Models\User(['name' => 'Assinante', 'email' => '']);

        return view('newsletter.show', compact('campaign', 'overrideCard', 'overrideProducts', 'user'));
    }

    public function preview(\App\Models\NewsletterEmail $email)
    {
        $email->load('products'); // Ensure products are loaded
        $campaign = $email->campaign;
        
        // Card is usually defined at Campaign level
        $overrideCard = $campaign->email_card_id ? \App\Models\EmailCard::find($campaign->email_card_id) : null;
        
        // Products are defined at Step level (Email)
        $overrideProducts = $email->products;
        
        // Safety Fallback: if step has no products, try campaign fallback? 
        // User complained "products didn't appear". If they didn't select any, maybe they expect nothing.
        // But let's trust that if the collection is empty, the view handles it.
        
        $user = new \App\Models\User(['name' => 'Assinante', 'email' => '']);

        return view('newsletter.show', [
            'campaign' => $email, // View uses $campaign->body
            'subject' => $email->subject,
            'overrideCard' => $overrideCard,
            'overrideProducts' => $overrideProducts,
            'user' => $user
        ]);
    }

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
