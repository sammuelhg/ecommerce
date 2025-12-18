<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use Livewire\Component;
use App\Domains\Marketing\Models\Form;

use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class FormBuilder extends Component
{
    public $forms;
    public $campaigns;
    public $isEditing = false;
    
    // Form Model Fields
    public $formId;
    public $title;
    public $slug;
    public $description;
    
    // Settings Fields
    public $success_title = 'Sucesso!';
    public $success_message = 'Seus dados foram enviados com sucesso.';
    public $button_text = 'Enviar';
    public $campaignId = ''; // New field for automation
    public $display_type = 'inline'; // inline, modal
    public $trigger_text = 'Abrir Formulário';
    


    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->forms = Form::latest()->get();
        // Fetch Strategy Campaigns (New Architecture)
        $this->campaigns = \App\Domains\Marketing\Models\Campaign::with('signCard')->latest()->get();
    }

    public function create()
    {
        $this->reset(['formId', 'title', 'slug', 'description', 'button_text', 'success_title', 'success_message', 'campaignId', 'display_type', 'trigger_text']);
        $this->display_type = 'inline'; // Ensure default
        $this->trigger_text = 'Abrir Formulário';
        $this->isEditing = true;
    }

    public function edit($id)
    {
        $form = Form::findOrFail($id);
        $this->formId = $form->id;
        $this->title = $form->title;
        $this->slug = $form->slug;
        $this->description = $form->description;
        
        $settings = $form->settings ?? [];
        $this->success_title = $settings['success_title'] ?? 'Sucesso!';
        $this->success_message = $settings['success_message'] ?? 'Seus dados foram enviados com sucesso.';
        $this->button_text = $settings['button_text'] ?? 'Enviar';
        
        // Prefer database FK, fallback to settings
        $this->campaignId = $form->campaign_id ?? $settings['campaign_id'] ?? '';
        
        $this->display_type = $settings['display_type'] ?? 'inline';
        $this->trigger_text = $settings['trigger_text'] ?? 'Abrir Formulário';
        
        $this->isEditing = true;
    }

    public function save()
    {
        $rules = [
            'title' => 'required|min:3',
            'slug' => 'required|alpha_dash|unique:forms,slug' . ($this->formId ? ',' . $this->formId : ''),
            'description' => 'nullable|string',
            'button_text' => 'required|string',
            'campaignId' => 'nullable|exists:campaigns,id',
            'display_type' => 'required|in:inline,modal',
            'trigger_text' => 'nullable|string',
        ];

        $this->validate($rules);

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'campaign_id' => $this->campaignId ?: null, // Save FK
            'settings' => [
                'success_title' => $this->success_title,
                'success_message' => $this->success_message,
                'button_text' => $this->button_text,
                // 'campaign_id' => $this->campaignId, // Deprecated in JSON, using FK now
                'display_type' => $this->display_type,
                'trigger_text' => $this->trigger_text,
                'card_style' => '', 
            ],
            'is_active' => true,
        ];

        if ($this->formId) {
            $form = Form::find($this->formId);
            $form->update($data);
            session()->flash('success', 'Formulário atualizado!');
        } else {
            // New Form
            $data['user_id'] = auth()->id() ?? 1; // Fallback
            Form::create($data);
            session()->flash('success', 'Formulário criado!');
        }

        $this->isEditing = false;
        $this->loadData();
    }
    
    public function cancel()
    {
        $this->isEditing = false;
    }
    
    public function delete($id)
    {
        Form::destroy($id);
        $this->loadData();
        session()->flash('success', 'Formulário removido.');
    }

    public function render()
    {
        return view('livewire.forms.form-builder');
    }
}
