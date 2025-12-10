<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Newsletter;

use App\Models\NewsletterSubscriber;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
#[Lazy]
class SubscriberManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filter = 'all'; // all, active, unsubscribed, bounced
    public string $utmSource = '';

    // Reset pagination when searching
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedFilter(): void
    {
        $this->resetPage();
    }

    public function updatedUtmSource(): void
    {
        $this->resetPage();
    }

    public function toggleStatus(int $id): void
    {
        $subscriber = NewsletterSubscriber::findOrFail($id);
        $subscriber->is_active = !$subscriber->is_active;
        $subscriber->save();
        
        $this->dispatch('show-toast', type: 'success', message: 'Status atualizado com sucesso!');
    }

    public function delete(int $id): void
    {
        NewsletterSubscriber::destroy($id);
        $this->dispatch('show-toast', type: 'success', message: 'Inscrito removido.');
    }

    public function render()
    {
        $query = NewsletterSubscriber::query()
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where('email', 'like', '%' . $this->search . '%');
        }

        if ($this->filter === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filter === 'unsubscribed') {
            $query->where('is_active', false);
        }
        
        if ($this->utmSource) {
            $query->where('utm_source', $this->utmSource);
        }
        
        // Get unique UTM Sources for filter
        $utmSources = NewsletterSubscriber::select('utm_source')
            ->whereNotNull('utm_source')
            ->distinct()
            ->pluck('utm_source');

        return view('livewire.admin.newsletter.subscriber-manager', [
            'subscribers' => $query->paginate(20),
            'utmSources' => $utmSources
        ]);
    }
}
