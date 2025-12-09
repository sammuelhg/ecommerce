<?php

declare(strict_types=1);


declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\StoryService;
use App\DTOs\Admin\StoryDTO;

class StoryController extends Controller
{
    public function __construct(
        protected StoryService $service
    ) {}

    public function index(): \Illuminate\View\View
    {
        $stories = $this->service->getAll();
        return view('admin.stories.index', compact('stories'));
    }

    public function store(\App\Http\Requests\Admin\StoreStoryRequest $request): \Illuminate\Http\RedirectResponse
    {
        $dto = StoryDTO::fromRequest($request);
        
        $this->service->create($dto);

        return redirect()->route('admin.stories.index')->with('success', 'Story publicado com sucesso!');
    }

    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        $this->service->delete($id);
        return redirect()->route('admin.stories.index')->with('success', 'Story removido com sucesso!');
    }

    public function update(\App\Http\Requests\Admin\UpdateStoryRequest $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $dto = StoryDTO::fromRequest($request);
        
        $this->service->update($id, $dto);

        return redirect()->route('admin.stories.index')->with('success', 'Story atualizado com sucesso!');
    }

    public function toggleStatus(int $id): \Illuminate\Http\RedirectResponse
    {
        $this->service->toggleStatus($id);
        return redirect()->back()->with('success', 'Status do story atualizado com sucesso!');
    }
}
