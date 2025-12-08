<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTOs\HighlightsDTO;
use App\Mail\HighlightsEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendHighlightsEmailAction
{
    public function execute(string $recipientEmail, HighlightsDTO $dto): void
    {
        Log::info('Sending Highlights Email', [
            'recipient' => $recipientEmail,
            'title' => $dto->title
        ]);

        Mail::to($recipientEmail)->send(new HighlightsEmail($dto));
    }
}
