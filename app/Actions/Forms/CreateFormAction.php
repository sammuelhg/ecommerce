<?php

declare(strict_types=1);

namespace App\Actions\Forms;

use App\DTOs\FormData;
use App\Models\Form;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

final class CreateFormAction
{
    public function execute(FormData $data): Form
    {
        $slug = Str::slug($data->title) . '-' . Str::random(4);

        return Form::create([
            'user_id' => Auth::id() ?? 1, // Fallback for dev/test if no auth
            'title'   => $data->title,
            'slug'    => $slug,
            'config'  => $data->structure,
            'is_active' => true,
        ]);
    }
}
