<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\DTOs\Admin\StoreSettingsDTO;
use App\Models\StoreSetting;
use App\Services\BaseService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class StoreSettingService extends BaseService
{
    public function updateSettings(StoreSettingsDTO $dto): void
    {
        // 1. Update Text Settings
        foreach ($dto->textSettings as $key => $value) {
            $type = str_contains($key, 'color') ? 'color' : 'text';
            StoreSetting::set($key, $value, $type);
        }

        // 2. Handle Logo Upload
        if ($dto->storeLogo) {
            // Delete old logo if exists (optional, could verify old path from DB)
            $oldLogo = StoreSetting::get('store_logo');
            if ($oldLogo) {
                 // Simple attempt to clean up, assuming storage path structure
                 $oldPath = str_replace('/storage/', '', $oldLogo);
                 // Check if it's a file relative to storage root to avoid deleting wrong things
                 if (Storage::disk('public')->exists($oldPath)) {
                     Storage::disk('public')->delete($oldPath);
                 }
            }

            $path = $dto->storeLogo->storeAs('uploads/settings', $dto->storeLogo->getClientOriginalName(), 'public');
            StoreSetting::set('store_logo', Storage::url($path), 'image');
        }

        // 2.1 Handle Email Logo (Optional override)
        if ($dto->emailLogo) {
            $oldLogo = StoreSetting::get('email_logo');
            if ($oldLogo) {
                 $oldPath = str_replace('/storage/', '', $oldLogo);
                 if (Storage::disk('public')->exists($oldPath)) {
                     Storage::disk('public')->delete($oldPath);
                 }
            }
            $path = $dto->emailLogo->storeAs('uploads/settings', $dto->emailLogo->getClientOriginalName(), 'public');
            StoreSetting::set('email_logo', Storage::url($path), 'image');
        }

        // 2.2 Handle Profile Logo
        if ($dto->profileLogo) {
            $oldProfileLogo = StoreSetting::get('profile_logo');
            if ($oldProfileLogo) {
                 $oldPath = str_replace('/storage/', '', $oldProfileLogo);
                 if (Storage::disk('public')->exists($oldPath)) {
                     Storage::disk('public')->delete($oldPath);
                 }
            }
            $path = $dto->profileLogo->storeAs('uploads/settings', $dto->profileLogo->getClientOriginalName(), 'public');
            StoreSetting::set('profile_logo', Storage::url($path), 'image');
        }

        // 2.3 Handle Footer Logo
        if ($dto->footerLogo) {
            $oldFooterLogo = StoreSetting::get('footer_logo');
            if ($oldFooterLogo) {
                 $oldPath = str_replace('/storage/', '', $oldFooterLogo);
                 if (Storage::disk('public')->exists($oldPath)) {
                     Storage::disk('public')->delete($oldPath);
                 }
            }
            $path = $dto->footerLogo->storeAs('uploads/settings', $dto->footerLogo->getClientOriginalName(), 'public');
            StoreSetting::set('footer_logo', Storage::url($path), 'image');
        }

        // 2.4 Handle Favicon
        if ($dto->favicon) {
            $oldFavicon = StoreSetting::get('favicon');
            if ($oldFavicon) {
                 $oldPath = str_replace('/storage/', '', $oldFavicon);
                 if (Storage::disk('public')->exists($oldPath)) {
                     Storage::disk('public')->delete($oldPath);
                 }
            }
            $path = $dto->favicon->storeAs('uploads/settings', $dto->favicon->getClientOriginalName(), 'public');
            StoreSetting::set('favicon', Storage::url($path), 'image');
        }

        // 3. Handle Certificates Upload (Append mode as per original logic)
        if (!empty($dto->securityCertificates)) {
            $currentCertificates = StoreSetting::get('security_certificates', []);
            if (!is_array($currentCertificates)) {
                $currentCertificates = [];
            }
            
            foreach ($dto->securityCertificates as $file) {
                if ($file instanceof \Illuminate\Http\UploadedFile) {
                    $path = $file->store('uploads/settings/certificates', 'public');
                    $currentCertificates[] = Storage::url($path);
                }
            }
            
            StoreSetting::set('security_certificates', $currentCertificates, 'json');
        }

        // 4. Clear Cache
        Cache::forget('store_settings');
    }

    public function removeCertificate(string $path): void
    {
        $certificates = StoreSetting::get('security_certificates', []);
        
        // Filter out the path
        $newCertificates = array_values(array_filter($certificates, fn($c) => $c !== $path));
        
        // Update DB
        StoreSetting::set('security_certificates', $newCertificates, 'json');
        
        // Optionally delete file - extracting path logic
        $relativePath = str_replace('/storage/', '', $path);
        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }

        Cache::forget('store_settings');
    }
}
