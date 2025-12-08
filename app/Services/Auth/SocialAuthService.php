<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\DTOs\Auth\SocialUserDTO;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Log;

class SocialAuthService extends BaseService
{
    public function handleSocialUser(SocialUserDTO $dto): User
    {
        // 1. Tenta encontrar usuário pelo email
        $user = User::where('email', $dto->email)->first();

        if ($user) {
            // 2. Se existe, atualiza informações
            $this->updateExistingUser($user, $dto);
        } else {
            // 3. Se não existe, cria novo
            $user = $this->createNewUser($dto);
        }

        return $user;
    }

    protected function updateExistingUser(User $user, SocialUserDTO $dto): void
    {
        $updates = [];

        // Atualiza ID do provider se não existir
        $providerIdField = "{$dto->providerName}_id";
        if (!$user->$providerIdField) {
            $updates[$providerIdField] = $dto->providerId;
        }

        // Atualiza avatar se não tiver
        if (!$user->avatar && $dto->avatar) {
            $updates['avatar'] = $dto->avatar;
        }

        if (!empty($updates)) {
            $user->update($updates);
        }
    }

    protected function createNewUser(SocialUserDTO $dto): User
    {
        $password = Str::random(16); // Gera senha segura aleatória

        $user = User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make($password),
            "{$dto->providerName}_id" => $dto->providerId,
            'avatar' => $dto->avatar,
            'email_verified_at' => now(), // Assume email verified by provider
        ]);

        // Envia email de boas-vindas
        try {
            Mail::to($user->email)->send(
                new WelcomeEmail($user, 'login com ' . ucfirst($dto->providerName))
            );
        } catch (\Exception $e) {
            Log::error('Erro ao enviar email de boas-vindas social: ' . $e->getMessage());
        }

        return $user;
    }
}
