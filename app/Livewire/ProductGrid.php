<?php

namespace App\Livewire;

use App\Models\Product;
use App\Services\GridComposer;
use Livewire\Component;
use Livewire\WithPagination;

class ProductGrid extends Component
{
    use WithPagination;

    public $newsletterEmail;
    public $newsletterSuccess = false;

    public function newsletterSubscribe()
    {
        $this->validate([
            'newsletterEmail' => 'required|email|unique:newsletter_subscribers,email'
        ], [
            'newsletterEmail.unique' => 'Este email já está inscrito!',
            'newsletterEmail.required' => 'Por favor, informe um email.',
            'newsletterEmail.email' => 'Email inválido.'
        ]);

        \App\Models\NewsletterSubscriber::create([
            'email' => $this->newsletterEmail,
            'source' => $this->source ?? 'grid'
        ]);

        try {
            \Illuminate\Support\Facades\Mail::to($this->newsletterEmail)->send(new \App\Mail\WelcomeNewsletter());
        } catch (\Exception $e) {
            // Log error but show success message to user
            \Illuminate\Support\Facades\Log::error('Newsletter email failed: ' . $e->getMessage());
        }

        $this->newsletterSuccess = true;
        $this->newsletterEmail = '';
        
        session()->flash('newsletter_message', 'Inscrição realizada com sucesso! Ganhe 15% OFF com o cupom: WELCOME15');
    }

    public function render(GridComposer $composer)
    {
        // 1. Fetch Products
        $products = Product::where('is_active', true)
                         ->orderBy('id', 'desc')
                         ->paginate(20);

        $rules = [
            0 => [ // Position 0 (First slot)
                'type' => 'card.product_highlight',
                'col_span' => 1, // Highlight card is 1 column wide usually, or 2? Let's try 1 first as it's a card.
                'content' => $products->first() // Use first product as data source
            ],
            3 => [
                'type' => 'marketing_banner',
                'col_span' => 2,
                'content' => [
                    'title' => 'Oferta Especial',
                    'bg_class' => 'bg-primary text-white',
                    'text' => 'Confira nossas promoções exclusivas!'
                ]
            ]
        ];

        // 3. Compose the Grid
        $gridItems = $composer->merge($products, $rules);

        return view('livewire.shop.product-grid', [
            'gridItems' => $gridItems,
            'products' => $products // Pass original paginator for links
        ]);
    }
}
