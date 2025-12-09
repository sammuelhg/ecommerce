<?php

declare(strict_types=1);

namespace App\DTOs\Admin;

use App\DTOs\BaseDTO;
use Illuminate\Http\UploadedFile;

class StoreSettingsDTO extends BaseDTO
{
    public function __construct(
        public readonly array $textSettings = [],
        public readonly ?UploadedFile $storeLogo = null,
        public readonly ?UploadedFile $emailLogo = null,
        public readonly ?UploadedFile $profileLogo = null,
        public readonly ?UploadedFile $footerLogo = null,
        public readonly ?UploadedFile $favicon = null,
        public readonly array $securityCertificates = [], // Array of UploadedFile
    ) {}

    public static function fromRequest(\Illuminate\Http\Request $request): self
    {
        // Define known text fields to extract
        $textFields = [
            'store_address', 'store_cnpj', 'store_phone',
            'google_maps_embed_url', 'ai_image_prompt_template',
            'modal_about', 'modal_careers', 'modal_contact', 'modal_returns', 'modal_faq',
            'color_primary', 'color_secondary', 'color_accent', 'color_background', 'color_category_bar',
            'email_card_id',
            'smtp_host', 'smtp_port', 'smtp_username', 'smtp_password', 'smtp_encryption', 'email_subject_prefix', 'global_showcase_products'
        ];

        $settings = [];
        foreach ($textFields as $field) {
            if ($request->has($field)) {
                $settings[$field] = $request->input($field);
            }
        }

        return new self(
            textSettings: $settings,
            storeLogo: $request->file('store_logo'),
            emailLogo: $request->file('email_logo'),
            profileLogo: $request->file('profile_logo'),
            footerLogo: $request->file('footer_logo'),
            favicon: $request->file('favicon'),
            securityCertificates: $request->file('security_certificates', [])
        );
    }
}
