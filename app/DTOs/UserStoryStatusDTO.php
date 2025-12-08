<?php

declare(strict_types=1);

namespace App\DTOs;

readonly class UserStoryStatusDTO
{
    public function __construct(
        public bool $hasActiveStories,
        public bool $hasUnseenStories,
        public ?string $previewImageUrl = null,
        public ?string $storiesRoute = null,
        public ?string $latestStoryTimestamp = null // Timestamp ISO do story mais recente
    ) {}
}
