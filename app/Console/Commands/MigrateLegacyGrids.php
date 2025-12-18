<?php

namespace App\Console\Commands;

use App\Domains\Marketing\Models\Campaign;
use App\Domains\Marketing\Models\Form;
use App\Domains\Catalog\Models\GridRule;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MigrateLegacyGrids extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:legacy-grids';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate legacy GridRules (with internal config) to new Forms';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting Legacy Grid Migration...');

        // 1. Get a valid user ID (first available)
        $adminUser = \App\Models\User::first();
        if (!$adminUser) {
            $this->error('No users found in database. Please create a user first.');
            return;
        }

        // 2. Create Legacy Campaign
        $campaign = Campaign::firstOrCreate(
            ['name' => 'Legacy Migration Campaign'],
            [
                'is_active' => true,
                'email_content_body' => '<p>Olá {name}, obrigado pelo cadastro!</p>',
                'sending_rules' => ['delay' => 0],
                'user_id' => $adminUser->id,
            ]
        );
        
        $this->info("Using Campaign: {$campaign->name} (ID: {$campaign->id})");

        // 2. Find Legacy Grids
        // We look for 'card.newsletter_form' or 'newsletter_form'.
        // Also ensure form_id is NULL so we don't migrate twice.
        $grids = GridRule::where(function ($q) {
                $q->where('type', 'card.newsletter_form')
                  ->orWhere('type', 'newsletter_form');
            })
            ->whereNull('form_id')
            ->get();

        if ($grids->isEmpty()) {
            $this->info('No legacy grids found to migrate.');
            return;
        }

        $this->info("Found {$grids->count()} legacy grids.");

        foreach ($grids as $grid) {
            $config = $grid->configuration ?? [];
            
            // Extract values
            $title = $config['title'] ?? 'Newsletter';
            $text = $config['text'] ?? '';
            $btnText = $config['button_text'] ?? 'Cadastrar';
            // Only legacy grids had bg_class, new ones have dedicated color props. 
            // We can try to preserve some style if needed, but defaults are fine.

            // 3. Create Form
            $formName = "Newsletter Grid (Pos: {$grid->position})";
            $formSlug = Str::slug($formName . '-' . uniqid());

            $form = Form::create([
                'title' => $formName,
                'slug' => $formSlug,
                'is_active' => true,
                'campaign_id' => $campaign->id,
                'settings' => [
                    'design' => [
                        'title' => $title,
                        'description' => $text,
                        'button_text' => $btnText,
                        // Preserve visual config if possible
                        'cta_color' => $config['btn_color'] ?? 'primary',
                    ]
                ],
                // Assuming user_id is needed if Form requires it (checking migration: usually nullable or belongsTo User)
                // If Form model has user_id, add it. Checking User.php... Form relationship exists.
            ]);
            
            // 4. Update GridRule
            $grid->form_id = $form->id;
            
            // Cleanup Legacy Config
            // We keep visual props (bg_color, etc) but remove content props (title, text)
            unset($config['title']);
            unset($config['text']);
            unset($config['button_text']);
            // unset($config['link']); // Link usually not used for newsletter forms?

            $grid->configuration = $config;
            $grid->save();

            $this->line("Migrated Grid #{$grid->id} -> Form #{$form->id}");
        }

        $this->info('Migration Completed Successfully!');
    }
}
