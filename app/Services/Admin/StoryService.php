<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\DTOs\Admin\StoryDTO;
use App\Models\Story;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class StoryService
{
    public function getAll()
    {
        return Story::orderBy('created_at', 'desc')->get();
    }

    public function create(StoryDTO $dto): Story
    {
        $imagePath = '';
        
        if ($dto->image) {
            $imagePath = $dto->image->store('stories', 'public');
        }

        // Se não for passado data de expiração, define 24h a partir de agora
        $expiresAt = $dto->expires_at 
            ? Carbon::parse($dto->expires_at) 
            : Carbon::now()->addHours(24);

        return Story::create([
            'title' => $dto->title,
            'subtitle' => $dto->subtitle,
            'image_path' => '/storage/' . $imagePath,
            'link_url' => $dto->link_url,
            'expires_at' => $expiresAt,
            'is_active' => $dto->is_active,
            'sort_order' => $dto->sort_order,
        ]);
    }

    public function delete(int $id): void
    {
        $story = Story::findOrFail($id);

        if ($story->image_path) {
            // Remove prefixo /storage/ para deletar do disco 'public'
            $path = str_replace('/storage/', '', $story->image_path);
            Storage::disk('public')->delete($path);
        }

        $story->delete();
    }

    public function toggleStatus(int $id): void
    {
        $story = Story::findOrFail($id);

        // Inverte o status
        $story->is_active = !$story->is_active;

        // Se estiver ativando, reseta o tempo de expiração para 24h a partir de agora
        if ($story->is_active) {
            $story->expires_at = Carbon::now()->addHours(24);
        }

        $story->save();
    }

    public function update(int $id, StoryDTO $dto): Story
    {
        $story = Story::findOrFail($id);

        // Upload New Image if provided
        if ($dto->image) {
            // Delete Old Image
            if ($story->image_path) {
                $path = str_replace('/storage/', '', $story->image_path);
                Storage::disk('public')->delete($path);
            }
            
            // Store New Image
            $newPath = $dto->image->store('stories', 'public');
            $story->image_path = '/storage/' . $newPath;
        }

        // Update fields
        $story->title = $dto->title;
        $story->subtitle = $dto->subtitle;
        $story->link_url = $dto->link_url;
        
        $story->save();

        return $story;
    }
}
