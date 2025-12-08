<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\DTOs\Auth\RegisterUserDTO;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Log;

class RegistrationService extends BaseService
{
    public function registerUser(RegisterUserDTO $dto): User
    {
        // Regra de Negócio: Criação do Usuário
        $user = User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
        ]);

        // Dispara evento padrão do Laravel (envio de email de verificação, etc)
        event(new Registered($user));
        
        // Envia email de boas-vindas com a senha original (comportamento original preservado)
        try {
            Mail::to($user->email)->send(
                new WelcomeEmail($user, $dto->password)
            );
        } catch (\Exception $e) {
            // Log error but don't stop registration hierarchy as mostly non-critical
            Log::error('Erro ao enviar email de boas-vindas: ' . $e->getMessage());
        }

        return $user;
    }
}
