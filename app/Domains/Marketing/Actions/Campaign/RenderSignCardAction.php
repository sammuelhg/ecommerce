<?php

declare(strict_types=1);

namespace App\Actions\Campaign;

use App\Domains\Content\Models\SignCard;

class RenderSignCardAction
{
    public function execute(?SignCard $signCard): string
    {
        if (!$signCard) {
            return '';
        }

        $avatarUrl = $signCard->avatar_url 
            ? asset($signCard->avatar_url) 
            : 'https://placehold.co/80x80?text=Avatar';

        // Table-based HTML for better Email client compatibility
        return <<<HTML
        <table border="0" cellpadding="0" cellspacing="0" style="margin-top: 30px; border-top: 1px solid #eeeeee; width: 100%; max-width: 600px;">
            <tr>
                <td style="padding-top: 20px; width: 60px; vertical-align: top;">
                    <img src="{$avatarUrl}" alt="{$signCard->name}" width="60" height="60" style="border-radius: 50%; display: block;">
                </td>
                <td style="padding-top: 20px; padding-left: 15px; vertical-align: top;">
                    <p style="margin: 0; font-family: sans-serif; font-size: 16px; font-weight: bold; color: #333333;">
                        {$signCard->name}
                    </p>
                    <p style="margin: 3px 0 0; font-family: sans-serif; font-size: 14px; color: #666666;">
                        {$signCard->role}
                    </p>
                    <p style="margin: 10px 0 0; font-family: serif; font-style: italic; font-size: 14px; color: #888888;">
                        "{$signCard->signature_text}"
                    </p>
                </td>
            </tr>
        </table>
HTML;
    }
}
