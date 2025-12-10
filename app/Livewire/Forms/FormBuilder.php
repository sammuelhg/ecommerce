<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use App\DTOs\FormData;
use App\Actions\Forms\CreateFormAction;

class FormBuilder extends Component
{
    public string $title = '';
    public array $fields = [];

    public function mount()
    {
        // Initialize with one default field
        $this->fields[] = ['type' => 'text', 'label' => 'Nome', 'name' => 'name'];
        $this->fields[] = ['type' => 'email', 'label' => 'Email', 'name' => 'email'];
    }

    public function addField()
    {
        $this->fields[] = ['type' => 'text', 'label' => 'Nova Pergunta', 'name' => 'field_' . count($this->fields)];
    }

    public function removeField($index)
    {
        unset($this->fields[$index]);
        $this->fields = array_values($this->fields);
    }

    public function save(CreateFormAction $action)
    {
        $this->validate([
            'title' => 'required|min:3',
            'fields.*.label' => 'required',
            'fields.*.name' => 'required',
        ]);

        $dto = new FormData(
            title: $this->title,
            structure: $this->fields
        );

        $form = $action->execute($dto);

        session()->flash('message', 'Formulário criado com sucesso!');
        return redirect()->route('admin.dashboard');
    }

    public function render()
    {
        return view('livewire.forms.form-builder')->layout('layouts.admin');
    }
}
