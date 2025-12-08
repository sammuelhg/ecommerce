<?php

declare(strict_types=1);

namespace App\Services\Story;

use App\DTOs\UserStoryStatusDTO;
use Illuminate\Support\Facades\Auth;

class CheckUserStoriesService
{
    public function handle(?int $userId): UserStoryStatusDTO
    {
        // Verifica se existem stories ativos no sistema
        // Get collection to find max updated_at for cache busting/unseen logic
        $activeStories = \App\Models\Story::where('is_active', true)
            ->where('expires_at', '>', now())
            ->get();

        $hasActiveStories = $activeStories->isNotEmpty();
        
        $latestTimestamp = null;
        if ($hasActiveStories) {
            $latestTimestamp = $activeStories->max('updated_at')?->toIso8601String();
        }
        
        // "Unseen" vs "Seen" logic is handled by frontend (LocalStorage vs Timestamp)
        // because we don't have a user_stories_view table yet.
        // So backend always returns "true" for hasUnseenStories if active stories exist used for the Ring.
        $hasUnseenStories = $hasActiveStories; 
        
        return new UserStoryStatusDTO(
            hasActiveStories: $hasActiveStories,
            hasUnseenStories: $hasUnseenStories,
            previewImageUrl: null, 
            storiesRoute: '#',
            latestStoryTimestamp: $latestTimestamp
        );
    }
}
