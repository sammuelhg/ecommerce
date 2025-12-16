<?php

namespace App\Actions\Cms;

use App\Models\Page;
use App\Models\StoreSetting;
use App\Cms\Blocks\HeroBlock;
use App\Cms\Blocks\TextBlock;
use App\Cms\Blocks\ContactBlock;
use Illuminate\Support\Str;

class MigrateModalsToPagesAction
{
    public function __invoke()
    {
        $settings = StoreSetting::all()->pluck('value', 'key');

        $migrations = [
            'modal_about' => [
                'title' => 'Sobre Nós',
                'slug' => 'sobre-nos',
                'hero_title' => 'Sobre Nós',
                'hero_subtitle' => 'Conheça nossa história',
            ],
            'modal_privacy' => [
                'title' => 'Política de Privacidade',
                'slug' => 'politica-de-privacidade',
                'hero_title' => 'Política de Privacidade',
                'hero_subtitle' => 'Seus dados estão seguros',
            ],
            'modal_faq' => [
                'title' => 'Perguntas Frequentes',
                'slug' => 'faq',
                'hero_title' => 'FAQ',
                'hero_subtitle' => 'Tire suas dúvidas',
            ],
            'modal_contact' => [
                'title' => 'Contato',
                'slug' => 'contato',
                'hero_title' => 'Fale Conosco',
                'hero_subtitle' => 'Estamos aqui para ajudar',
                'add_contact_block' => true,
            ],
            'modal_returns' => [
                'title' => 'Trocas e Devoluções',
                'slug' => 'trocas-e-devolucoes',
                'hero_title' => 'Trocas e Devoluções',
                'hero_subtitle' => 'Política de retorno',
            ],
        ];

        foreach ($migrations as $key => $config) {
            $content = $settings[$key] ?? '';
            
            if (empty($content)) {
                continue;
            }

            // Check if page already exists
            if (Page::where('slug', $config['slug'])->exists()) {
                continue;
            }

            $blocks = [];

            // 1. Hero Block
            $hero = new HeroBlock(
                title: $config['hero_title'],
                subtitle: $config['hero_subtitle'],
                layout: 'center'
            );
            $blocks[] = $hero->toArray();

            // 2. Text Block
            $text = new TextBlock(
                content: $content,
                alignment: 'left'
            );
            $blocks[] = $text->toArray();

            // 3. Optional Contact Block
            if (!empty($config['add_contact_block'])) {
                $contact = new ContactBlock(
                    email: 'contato@loja.com',
                    showForm: true
                );
                $blocks[] = $contact->toArray();
            }

            Page::create([
                'title' => $config['title'],
                'slug' => $config['slug'],
                'content' => $blocks,
                'is_active' => true,
                'meta_title' => $config['title'],
                'meta_description' => $config['hero_subtitle'],
            ]);
        }
    }
}
