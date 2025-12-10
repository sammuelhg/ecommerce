<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\DTOs\ContactDTO;
use App\Actions\SendContactEmailAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function store(Request $request, SendContactEmailAction $emailAction, \App\Actions\Contacts\CreateContactAction $createAction)
    {
        $validated = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'phone' => 'required|min:8',
            'message' => 'required|min:10',
        ]);

        $dto = new ContactDTO(
            name: $validated['name'],
            phone: $validated['phone'],
            email: $validated['email'],
            message: $validated['message']
        );

        // 1. Save to Database using Action
        $createAction->execute($dto);

        // 2. Send Notification
        try {
            $emailAction->execute($dto);
            return back()->with('contact_success', 'Mensagem enviada com sucesso!');
        } catch (\Exception $e) {
            Log::error('Standard Contact Form Error: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('contact_error', 'Erro ao enviar: ' . $e->getMessage());
        }
    }
}
