<?php

namespace App\Livewire\Admin\Newsletter;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\EmailTemplate;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class TemplateManager extends Component
{
    use WithPagination;

    // List State
    public string $search = '';

    // Modal State
    public bool $showModal = false;
    public bool $isEditing = false;
    public ?int $editingId = null;

    // Form Fields
    #[Rule('required|min:3')]
    public string $name = '';

    #[Rule('nullable|string')]
    public string $subject = '';

    #[Rule('nullable|string')]
    public string $category = '';

    #[Rule('required')]
    public string $body = '';

    public function updated($property)
    {
        if ($property === 'search') {
            $this->resetPage();
        }
    }

    public function create()
    {
        $this->resetInput();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function edit(int $id)
    {
        $this->resetInput();
        $this->isEditing = true;
        $this->editingId = $id;

        $template = EmailTemplate::find($id);
        $this->name = $template->name;
        $this->subject = $template->subject ?? '';
        $this->category = $template->category ?? '';
        $this->body = $template->body ?? '';

        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing) {
            $template = EmailTemplate::find($this->editingId);
            $template->update([
                'name' => $this->name,
                'subject' => $this->subject,
                'category' => $this->category,
                'body' => $this->body,
            ]);
            session()->flash('success', 'Modelo atualizado com sucesso.');
        } else {
            EmailTemplate::create([
                'name' => $this->name,
                'subject' => $this->subject,
                'category' => $this->category,
                'body' => $this->body,
            ]);
            session()->flash('success', 'Modelo criado com sucesso.');
        }

        $this->showModal = false;
        $this->resetInput();
    }

    public function delete(int $id)
    {
        EmailTemplate::find($id)->delete();
        session()->flash('success', 'Modelo excluído.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetInput();
    }

    private function resetInput()
    {
        $this->name = '';
        $this->subject = '';
        $this->category = '';
        $this->body = '';
        $this->editingId = null;
        $this->resetErrorBag();
    }

    public function render()
    {
        $templates = EmailTemplate::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.newsletter.template-manager', [
            'templates' => $templates
        ]);
    }
}
