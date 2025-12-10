<?php

declare(strict_types=1);

namespace App\Actions\Contacts;

use App\DTOs\ContactDTO;
use App\Models\Contact;

final class CreateContactAction
{
    public function execute(ContactDTO $data): Contact
    {
        return Contact::create([
            'name' => $data->name,
            'email' => $data->email,
            'phone' => $data->phone,
            'message' => $data->message,
        ]);
    }
}
