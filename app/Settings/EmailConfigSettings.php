<?php

declare(strict_types=1);

namespace App\Settings;

use App\Models\StoreSetting;
use Illuminate\Support\Facades\Config;

class EmailConfigSettings
{
    public function getSmtpConfig(): array
    {
        // Try to get from DB, fallback to Config (env)
        return [
            'transport' => 'smtp',
            'host' => StoreSetting::get('smtp_host') ?? Config::get('mail.mailers.smtp.host'),
            'port' => StoreSetting::get('smtp_port') ?? Config::get('mail.mailers.smtp.port'),
            'username' => StoreSetting::get('smtp_username') ?? Config::get('mail.mailers.smtp.username'),
            'password' => StoreSetting::get('smtp_password') ?? Config::get('mail.mailers.smtp.password'),
            'encryption' => StoreSetting::get('smtp_encryption') ?? Config::get('mail.mailers.smtp.encryption'),
        ];
    }

    public function getShowcaseProductIds(): array
    {
        // Returns array of IDs like [1, 5, 20]
        return StoreSetting::get('global_showcase_products', []);
    }

    public function getGlobalSubjectPrefix(): string
    {
        return StoreSetting::get('email_subject_prefix', '[LosFit]');
    }

    public function getDefaultEmailCard(): ?\App\Models\EmailCard
    {
        return \App\Models\EmailCard::getDefault();
    }
}
