<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Newsletter;

use App\Models\NewsletterCampaign;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class CampaignManager extends Component
{
    use WithPagination;

    // Search & Filters
    public string $search = '';
    public string $filterStatus = 'all';

    // Modal State
    public bool $showModal = false;
    public bool $isEditing = false;
    public ?int $editingId = null;

    // Form Data
    #[Rule('required|min:3|max:255')]
    public string $subject = '';

    #[Rule('nullable|string')]
    public string $preview_text = ''; // We might need to add this column later if not present, for now keep logic simple or omit

    // Confirmation State
    public ?int $confirmingDeletionId = null;

    public function render()
    {
        $query = NewsletterCampaign::query()
            ->with(['emails'])
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where('subject', 'like', '%' . $this->search . '%');
        }

        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        return view('livewire.admin.newsletter.campaign-manager', [
            'campaigns' => $query->paginate(10)
        ]);
    }

    public function create(): void
    {
        $this->reset(['subject', 'editingId', 'isEditing']);
        $this->showModal = true;
    }

    public function edit(int $id): void
    {
        $campaign = NewsletterCampaign::findOrFail($id);
        $this->editingId = $campaign->id;
        $this->subject = $campaign->subject;
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        if ($this->isEditing) {
            $campaign = NewsletterCampaign::findOrFail($this->editingId);
            $campaign->update([
                'subject' => $this->subject,
            ]);
            session()->flash('success', 'Campanha atualizada com sucesso.');
        } else {
            NewsletterCampaign::create([
                'subject' => $this->subject,
                'body' => '', // Empty body initially
                'status' => \App\Enums\CampaignStatus::DRAFT
            ]);
            session()->flash('success', 'Campanha criada! Agora você pode editar o conteúdo.');
        }

        $this->showModal = false;
        $this->reset(['subject', 'editingId', 'isEditing']);
    }

    public function confirmDeletion(int $id): void
    {
        $this->confirmingDeletionId = $id;
    }

    public function delete(): void
    {
        if ($this->confirmingDeletionId) {
            NewsletterCampaign::findOrFail($this->confirmingDeletionId)->delete();
            $this->confirmingDeletionId = null;
            session()->flash('success', 'Campanha removida.');
        }
    }

    public function cancelDeletion(): void
    {
        $this->confirmingDeletionId = null;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetErrorBag();
    }
}
