<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Campaign;

use App\Domains\Marketing\Models\Campaign;
use App\Domains\Catalog\Models\Product;
use App\Domains\Marketing\Models\Form;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Illuminate\Support\Collection;
use App\Domains\Content\Models\SignCard;

#[Layout('layouts.admin')]
class CampaignBuilder extends Component
{
    public ?Campaign $campaign = null;

    // Wizard State
    public int $currentStep = 1;

    // Step 1: Trigger (Form)
    #[Rule('required|array|min:1')]
    public array $form_ids = [];

    // Step 2: Vitrine (Products)
    #[Rule('required|array|min:1')]
    public array $product_ids = [];
    
    public string $productSearch = '';

    // Step 3: Content (Email Sequence)
    #[Rule('required|array|min:1')]
    public array $emails = [];

    // Step 4: Card (SignCard)
    #[Rule('required|exists:sign_cards,id')]
    public ?int $sign_card_id = null;

    // Step 4: Automation (Sending Rules) - NOW UNUSED/HIDDEN or Integrated into Step 4 later
    public array $sending_rules = [];

    // General Info (Step 5 Review)
    #[Rule('required|string|min:3')]
    public string $name = '';

    public function mount(?Campaign $campaign = null): void
    {
        if ($campaign && $campaign->exists) {
            $this->campaign = $campaign;
            $this->form_ids = $campaign->forms->pluck('id')->toArray();
            $this->product_ids = $campaign->products->pluck('id')->toArray();
            $this->sign_card_id = $campaign->sign_card_id;
            
            // Load Emails
            $this->emails = $campaign->emails->map(function($email) {
                return [
                    'id' => $email->id, // Track existing ID for updates
                    'subject' => $email->subject ?? '',
                    'body' => $email->body ?? '',
                    'delay_hours' => $email->delay_hours,
                    'order_index' => $email->order_index,
                ];
            })->toArray();

            // Fallback for migration safety if count is 0 but we have content (should be covered by migration though)
            if (empty($this->emails) && !empty($campaign->email_content_body)) {
                 $this->emails[] = [
                    'subject' => $campaign->sending_rules['subject'] ?? '',
                    'body' => $campaign->email_content_body,
                    'delay_hours' => 0,
                    'order_index' => 0
                ];
            }

            $this->sending_rules = $campaign->sending_rules ?? [];
            $this->name = $campaign->name;
        } else {
            // Defaults (New Campaign)
            $this->sending_rules = [];
            
            // Initialize with ONE immediate email
            $this->addEmail(true); 
        }
    }

    public function addEmail($isFirst = false)
    {
        $this->emails[] = [
            'subject' => '',
            'body' => '',
            'delay_hours' => $isFirst ? 0 : 24, // Default 0 for first, 24h for others
            'order_index' => count($this->emails)
        ];
    }

    public function removeEmail($index)
    {
        unset($this->emails[$index]);
        $this->emails = array_values($this->emails); // Reindex
    }

    public function updatedProductSearch()
    {
        // Livewire updates automatically
    }

    public function getAvailableProductsProperty(): Collection
    {
        if (empty($this->productSearch)) {
            return Product::take(10)->get();
        }

        return Product::where('name', 'like', '%' . $this->productSearch . '%')
            ->take(10)
            ->get();
    }

    public function getAvailableFormsProperty(): Collection
    {
        return Form::all();
    }

    public function toggleForm(int $formId): void
    {
        if (in_array($formId, $this->form_ids)) {
            $this->form_ids = array_diff($this->form_ids, [$formId]);
        } else {
            $this->form_ids[] = $formId; // Allow multiple triggers
        }
    }

    public function getAvailableSignCardsProperty(): Collection
    {
        return SignCard::all();
    }

    public function selectSignCard(int $cardId): void
    {
        $this->sign_card_id = $cardId;
    }

    public function getSelectedSignCardProperty()
    {
        return SignCard::find($this->sign_card_id);
    }

    public function getSelectedProductsListProperty(): Collection
    {
        return Product::whereIn('id', $this->product_ids)->get();
    }

    // Product selection is now handled on the client-side via Alpine.js 
    // and synced with $product_ids via @entangle.

    // ... (Keep existing property getters like getAvailableProductsProperty) ...

    // ... (Keep existing toggleProduct) ...

    public function nextStep(): void
    {
        $this->validateStep($this->currentStep);
        $this->currentStep++;
    }

    public function prevStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function setStep(int $step): void
    {
        // Allow navigation
        if ($step < $this->currentStep || $this->campaign) {
            $this->currentStep = $step;
        }
    }

    public function validateStep(int $step): void
    {
        if ($step === 1) {
            $this->validate(['form_ids' => 'required|array|min:1']);
        } elseif ($step === 2) {
            $this->validate(['product_ids' => 'required|array|min:1']);
        } elseif ($step === 3) {
            $this->validate([
                'emails.*.subject' => 'required|string|min:3',
                'emails.*.body' => 'required|string|min:10',
                'emails.*.delay_hours' => 'required|integer|min:0',
            ], [
                'emails.*.subject.required' => 'O assunto é obrigatório.',
                'emails.*.body.required' => 'O conteúdo do email é obrigatório.'
            ]);
        } elseif ($step === 4) {
             $this->validate(['sign_card_id' => 'required|exists:sign_cards,id']);
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|min:3',
            'form_ids' => 'required|array|min:1',
            'product_ids' => 'required|array|min:1',
            'sign_card_id' => 'required|exists:sign_cards,id',
            'emails' => 'required|array|min:1',
            'emails.*.subject' => 'required|string|min:3',
            'emails.*.body' => 'required|string|min:10',
        ]);

        try {
            if ($this->campaign) {
                $this->campaign->update([
                    'name' => $this->name,
                    'sign_card_id' => $this->sign_card_id,
                    'sending_rules' => $this->sending_rules,
                ]);
            } else {
                $this->campaign = Campaign::create([
                    'user_id' => auth()->id() ?? 1,
                    'name' => $this->name,
                    'sign_card_id' => $this->sign_card_id,
                    'sending_rules' => $this->sending_rules,
                    'status' => 'active',
                ]);
            }

            // Sync Forms (Triggers)
            // Dissociate all first
            Form::where('campaign_id', $this->campaign->id)->update(['campaign_id' => null]);
            // Associate selected
            Form::whereIn('id', $this->form_ids)->update(['campaign_id' => $this->campaign->id]);

            // Sync Products
            $syncData = [];
            foreach ($this->product_ids as $index => $id) {
                $syncData[$id] = ['order' => $index];
            }
            $this->campaign->products()->sync($syncData);

            // Sync Emails
            // Strategy: Delete all and recreate? Or update existing?
            // Update existing is better to preserve IDs (stats).
            
            $existingIds = $this->campaign->emails()->pluck('id')->toArray();
            $currentIds = [];

            foreach ($this->emails as $index => $data) {
                if (isset($data['id'])) {
                    $currentIds[] = $data['id'];
                    $this->campaign->emails()->where('id', $data['id'])->update([
                        'subject' => $data['subject'],
                        'body' => $data['body'],
                        'delay_hours' => $data['delay_hours'],
                        'order_index' => $index
                    ]);
                } else {
                    $newEmail = $this->campaign->emails()->create([
                        'subject' => $data['subject'],
                        'body' => $data['body'],
                        'delay_hours' => $data['delay_hours'],
                        'order_index' => $index
                    ]);
                    // Update the array with ID if we continue editing (not needed for redirect)
                }
            }
            
            // Delete removed emails
            $toDelete = array_diff($existingIds, $currentIds);
            if (!empty($toDelete)) {
                $this->campaign->emails()->whereIn('id', $toDelete)->delete();
            }

            session()->flash('success', 'Campanha salva com sucesso!');
            return redirect()->route('admin.campaigns.index'); 

        } catch (\Exception $e) {
            $this->addError('general_save_error', 'Erro ao salvar: ' . $e->getMessage());
        }
    }

    public function getTemplatesProperty()
    {
        return \App\Domains\Marketing\Models\EmailTemplate::all(['id', 'name', 'subject', 'body']);
    }

    public function applyTemplate(int $index, int $templateId): void
    {
        $template = \App\Domains\Marketing\Models\EmailTemplate::find($templateId);
        if ($template) {
            $this->emails[$index]['subject'] = $template->subject;
            $this->emails[$index]['body'] = $template->body;
        }
    }

    public function render()
    {
        return view('livewire.admin.campaign.campaign-builder');
    }
}
