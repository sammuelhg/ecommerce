<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use Livewire\Component;
use App\Actions\Forms\CreateFormAction;
use App\DTOs\FormData;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class FormBuilder extends Component
{
    public string $title = '';
    public string $structureJson = '[]';

    public function save(CreateFormAction $action)
    {
        $this->validate([
            'title' => 'required|min:3',
            'structureJson' => 'required|json',
        ]);

        $structure = json_decode($this->structureJson, true);

        $action->execute(new FormData(
            title: $this->title,
            structure: $structure
        ));

        session()->flash('success', 'Formulário criado com sucesso!');
        
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.forms.form-builder');
    }
}
