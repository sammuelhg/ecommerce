<?php

declare(strict_types=1);

namespace App\Interfaces;

interface AdNetworkInterface
{
    public function validateConnection(array $credentials): bool;
    public function sendEvent(string $eventName, array $payload): void;
}
