<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Newsletter;

use App\Actions\Newsletter\SaveCampaignAction;
use App\DTOs\CampaignDTO;
use App\Models\NewsletterCampaign;
use App\Models\NewsletterEmail;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class CampaignBuilder extends Component
{
    use WithFileUploads;

    public NewsletterCampaign $campaign;

    // Active Step State
    public ?int $activeEmailId = null;
    public NewsletterEmail $activeEmail;
    
    // View Mode: 'preview' (Visual) or 'code' (HTML)
    public string $viewMode = 'preview'; 
    public bool $showSettingsModal = false;

    public function setViewMode(string $mode): void
    {
        if (in_array($mode, ['preview', 'desktop', 'code'])) {
            $this->viewMode = $mode;
        }
    }
    
    public function openSettingsModal(): void
    {
        $this->showSettingsModal = true;
    }

    public function closeSettingsModal(): void
    {
        $this->showSettingsModal = false;
    }
    
    // Step Form Fields
    #[Rule('required|min:3|max:255')]
    public string $subject;

    #[Rule('required')]
    public string $body;

    public int $delay = 0;

    public ?int $selectedCard = null;
    public array $selectedProducts = [];

    // UI State
    public bool $showProductModal = false;
    public bool $showTemplateModal = false;
    public string $productSearch = '';
    public string $templateSearch = '';
    public ?string $previewHtml = null;

    // Promo Image State
    #[Rule('nullable|image|max:2048')]
    public $promoImage; // Uploaded file
    public ?string $promoImageUrl = null; // Existing URL
    public bool $showPromoImageInEmail = false;
    
    public function openTemplateModal(): void
    {
        $this->showTemplateModal = true;
    }

    public function closeTemplateModal(): void
    {
        $this->showTemplateModal = false;
    }

    public function importTemplate(int $templateId): void
    {
        $template = \App\Models\EmailTemplate::find($templateId);
        if ($template) {
            $this->body = $template->body ?? '';
            $this->subject = $template->subject ?? $this->subject; // Optional: overwrite subject or keep? Let's overwrite if present.
            // Trigger auto-save or preview update
            $this->updatePreview();
            $this->closeTemplateModal();
            $this->dispatch('alert', type: 'success', message: 'Modelo importado com sucesso.');
        }
    }

    public function getTemplatesProperty()
    {
        return \App\Models\EmailTemplate::where('name', 'like', '%' . $this->templateSearch . '%')
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();
    }

    public function mount(NewsletterCampaign $campaign): void
    {
        $this->campaign = $campaign;
        $this->selectedCard = $campaign->email_card_id;
        $this->promoImageUrl = $campaign->promo_image_url;
        $this->showPromoImageInEmail = (bool) $campaign->show_promo_image_in_email;

        // Load First Email or Create if none
        $firstEmail = $campaign->emails()->first();
        if (!$firstEmail) {
            $firstEmail = $campaign->emails()->create([
                'subject' => $campaign->subject,
                'body' => '',
                'delay_in_hours' => 0,
                'sort_order' => 0,
            ]);
        }
        
        $this->setActiveEmail($firstEmail->id);
    }
    
    // ... (keep intermediate methods if possible, but replace_file_content is block based. 
    // I need to be careful not to overwrite setActiveEmail unless I include it. 
    // Wait, I can target specific method blocks. Let's do save first.)

    public function save(): void
    {
        $this->validate();

        // Handle Image Upload
        if ($this->promoImage) {
            $path = $this->promoImage->store('newsletter-promos', 'public');
            $this->promoImageUrl = '/storage/' . $path;
        }

        // 1. Save Campaign Level Info
        $this->campaign->update([
            'email_card_id' => $this->selectedCard,
            'promo_image_url' => $this->promoImageUrl,
            'show_promo_image_in_email' => $this->showPromoImageInEmail,
        ]);

        // 2. Save Active Email
        $this->activeEmail->update([
            'subject' => $this->subject,
            'body' => $this->body,
            'delay_in_hours' => $this->delay,
        ]);

        // 3. Sync Products for Active Email
        $syncData = [];
        foreach ($this->selectedProducts as $index => $id) {
            $syncData[$id] = ['sort_order' => $index]; 
        }
        $this->activeEmail->products()->sync($syncData);

        session()->flash('success', 'Passo e configurações salvos com sucesso.');
    }

    public function setActiveEmail(int $emailId): void
    {
        $this->activeEmailId = $emailId;
        $this->activeEmail = \App\Models\NewsletterEmail::findOrFail($emailId);
        
        // Load Form
        $this->subject = $this->activeEmail->subject ?? $this->campaign->subject; // Fallback
        $this->body = $this->activeEmail->body ?? '';
        $this->delay = $this->activeEmail->delay_in_hours;
        
        // Load Products for this Email
        $this->selectedProducts = $this->activeEmail->products()->pluck('products.id')->toArray();
        
        $this->updatePreview();
    }
    
    public function addStep(): void
    {
        $count = $this->campaign->emails()->count();
        $newEmail = $this->campaign->emails()->create([
            'subject' => $this->campaign->subject . ' - Passo ' . ($count + 1),
            'body' => '',
            'delay_in_hours' => 24, // Default delay
            'sort_order' => $count,
        ]);
        
        $this->setActiveEmail($newEmail->id);
    }

    public function deleteStep(int $emailId): void
    {
        // Don't delete the last one
        if ($this->campaign->emails()->count() <= 1) {
             $this->dispatch('alert', type: 'error', message: 'A campanha deve ter pelo menos um email.');
             return;
        }

        $email = \App\Models\NewsletterEmail::findOrFail($emailId);
        if ($email->newsletter_campaign_id === $this->campaign->id) {
            $email->delete();
        }

        // Switch to first available
        $this->setActiveEmail($this->campaign->emails()->first()->id);
    }

    public function updated($property): void
    {
        if (in_array($property, ['subject', 'body', 'selectedCard', 'selectedProducts'])) {
            $this->updatePreview();
        }
        
        // Auto-save fields to Active Email model on blur/update? 
        // Or just wait for Save button. User expects "Save".
    }

    public function getEmailCardsProperty()
    {
        return \App\Models\EmailCard::where('is_active', true)->get();
    }

    public function getAvailableProductsProperty()
    {
        return \App\Models\Product::where('is_active', true)
            ->where('name', 'like', '%' . $this->productSearch . '%')
            ->take(20)
            ->get();
    }

    public function toggleProduct(int $productId): void
    {
        if (in_array($productId, $this->selectedProducts)) {
            $this->selectedProducts = array_diff($this->selectedProducts, [$productId]);
        } else {
            if (count($this->selectedProducts) >= 4) {
                return; 
            }
            $this->selectedProducts[] = $productId;
        }
        
        $this->updatePreview();
        $this->syncProducts(); // Auto-save products
    }

    public function syncProducts(): void
    {
        if (!$this->activeEmail) return;

        $syncData = [];
        foreach ($this->selectedProducts as $index => $id) {
            $syncData[$id] = ['sort_order' => $index]; 
        }
        $this->activeEmail->products()->sync($syncData);
    }

    public function updatePreview(): void
    {
        try {
             $user = new \App\Models\User(['name' => 'Cliente Teste', 'email' => 'cliente@teste.com']);
             
             $previewCard = \App\Models\EmailCard::find($this->selectedCard);
             $previewProducts = \App\Models\Product::whereIn('id', $this->selectedProducts)->get();
             
             $this->previewHtml = \Illuminate\Support\Facades\Blade::render(
                 '@extends("emails.layouts.global") 
                  @section("content") {!! $body !!} @endsection', 
                 [
                     'body' => $this->body, 
                     'user' => $user,
                     'overrideCard' => $previewCard,
                     'overrideProducts' => $previewProducts
                 ]
             );
             
        } catch (\Exception $e) {
            $this->previewHtml = '<div class="alert alert-danger">Erro no Preview: ' . $e->getMessage() . '</div>';
        }
    }



    public function openProductModal(): void
    {
        $this->showProductModal = true;
    }

    public function closeProductModal(): void
    {
        $this->showProductModal = false;
    }

    // Render the component
    public function render()
    {
        return view('livewire.admin.newsletter.campaign-builder', [
            'steps' => $this->campaign->emails()->orderBy('sort_order')->get()
        ]);
    }
}
