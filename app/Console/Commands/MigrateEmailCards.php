<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EmailCard;
use App\Models\SignCard;

class MigrateEmailCards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-email-cards';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate legacy EmailCards to the new SignCard system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting migration of EmailCards to SignCards...');

        $legacyCards = EmailCard::where('is_active', true)->get();

        $count = 0;

        foreach ($legacyCards as $legacy) {
            // Check if a SignCard with this name already exists to avoid duplicates
            if (SignCard::where('name', $legacy->sender_name)->exists()) {
                $this->warn("Skipping '{$legacy->sender_name}' (already exists).");
                continue;
            }

            // Construct rich signature text from legacy fields
            $signatureText = $legacy->slogan;
            $extras = [];
            if ($legacy->whatsapp) $extras[] = 'WhatsApp: ' . $legacy->whatsapp;
            if ($legacy->instagram) $extras[] = 'Insta: ' . $legacy->instagram;
            if ($legacy->website) $extras[] = $legacy->website;
            
            if (!empty($extras)) {
                $signatureText .= "\n" . implode(' | ', $extras);
            }

            // Find a valid user (Admin)
            $userId = \App\Models\User::first()?->id;

            if (!$userId) {
                $this->error('No users found in database. Cannot assign SignCard owner.');
                return;
            }

            $card = SignCard::where('name', $legacy->sender_name)->first(); // force find

            SignCard::updateOrCreate(
                ['name' => $legacy->sender_name], 
                [
                    'user_id' => $userId,
                    'role' => $legacy->sender_role ?? 'Equipe LosFit',
                    'avatar_url' => $legacy->photo,
                    'signature_text' => $signatureText,
                    // Force update new fields even if record exists
                    'slogan' => $legacy->slogan,
                    'whatsapp' => $legacy->whatsapp,
                    'instagram' => $legacy->instagram,
                    'website' => $legacy->website,
                ]
            );

            $this->info("Migrated: {$legacy->sender_name}");
            $count++;
        }

        $this->info("Migration completed! {$count} cards migrated.");
    }
}
