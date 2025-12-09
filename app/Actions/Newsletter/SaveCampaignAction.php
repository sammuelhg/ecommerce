<?php

declare(strict_types=1);

namespace App\Actions\Newsletter;

use App\DTOs\CampaignDTO;
use App\Models\NewsletterCampaign;

class SaveCampaignAction
{
    public function execute(CampaignDTO $dto): NewsletterCampaign
    {
        $data = [
            'body' => $dto->body,
            'status' => $dto->status,
            'email_card_id' => $dto->email_card_id,
            'promo_image_url' => $dto->promo_image_url,
            'show_promo_image_in_email' => $dto->show_promo_image_in_email,
        ];

        // Only update subject/slug if changed (or always, it's fine)
        if ($dto->subject) {
             $data['subject'] = $dto->subject;
             $data['slug'] = \Illuminate\Support\Str::slug($dto->subject);
        }

        if ($dto->scheduled_at) {
            $data['scheduled_at'] = $dto->scheduled_at;
        }

        $campaign = NewsletterCampaign::updateOrCreate(
            ['id' => $dto->id],
            $data
        );

        // Sync products with order
        if (!empty($dto->product_ids)) {
            $syncData = [];
            foreach ($dto->product_ids as $index => $id) {
                $syncData[$id] = ['order' => $index];
            }
            $campaign->products()->sync($syncData);
        } else {
            $campaign->products()->detach();
        }

        return $campaign;
    }
}
