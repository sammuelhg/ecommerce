<?php

namespace Tests\Feature;

use App\Models\Form;
use App\Models\GridRule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class GridRenderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function grid_loads_new_form_embed()
    {
        // 1. Create a Form
        $form = Form::factory()->create([
            'title' => 'Newsletter',
            'slug' => 'newsletter-grid',
            'is_active' => true,
        ]);

        // 2. Create a GridRule pointing to that form
        $grid = GridRule::create([
            'position' => 1,
            'type' => 'card.newsletter_form',
            'col_span' => 1,
            'is_active' => true,
            'form_id' => $form->id,
            'configuration' => [], // Empty config, should use Form's data
        ]);

        // 3. Render the GridManager (or the component that renders grids on frontend)
        // Frontend component is where <livewire:forms.embed> is called.
        // Assuming it's in `welcome.blade.php` or `marketing-banner.blade.php`.
        // Let's test the component `App\Livewire\Frontend\GridItem` if it exists, or just the view.
        
        // If we don't have a dedicated component, we verify the home page.
        $response = $this->get('/');
        
        $response->assertStatus(200);
        // Assert we see the form title
        $response->assertSee($form->title);
        $response->assertSeeLivewire('cms.universal-form'); 
    }
}
