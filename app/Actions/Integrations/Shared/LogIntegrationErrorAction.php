<?php

declare(strict_types=1);

namespace App\Actions\Integrations\Shared;

use Illuminate\Support\Facades\Log;

class LogIntegrationErrorAction
{
    /**
     * Registra erros de integração de forma padronizada.
     * 
     * @param string $provider Ex: 'Meta', 'Google', 'TikTok'
     * @param \Throwable $exception A exceção capturada
     * @param array $context Dados adicionais de contexto
     */
    public function execute(string $provider, \Throwable $exception, array $context = []): void
    {
        // Estrutura do log
        $logData = [
            'provider' => $provider,
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'context' => $context,
            'trace' => $exception->getTraceAsString(),
        ];

        // 1. Log no canal padrão (ou dedicado se existir)
        // Idealmente, configurar um channel 'integrations' no logging.php
        Log::channel('daily')->error("[Integração: {$provider}] Falha detectada: {$exception->getMessage()}", $logData);

        // 2. Persistência em Banco (Opcional/Futuro)
        // TODO: Implementar salvamento na tabela 'integration_errors' para exibição no Admin Dashboard
        // IntegrationError::create($logData);
    }
}
