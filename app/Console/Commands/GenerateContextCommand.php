<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\Finder;

class GenerateContextCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-context';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gera um arquivo de contexto completo do sistema para uso por IAs (Lógica + Blades + Estrutura + URLs)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando geração do contexto do sistema...');

        $outputFile = base_path('codebase_context.txt');
        $content = "CONTEXTO COMPLETO DO SISTEMA - GERADO EM " . date('Y-m-d H:i:s') . "\n\n";

        // --- 1. ESTRUTURA DE PASTAS ---
        $this->info('Gerando estrutura de pastas...');
        $content .= "================================================================================\n";
        $content .= "ESTRUTURA DE DIRETÓRIOS\n";
        $content .= "================================================================================\n";
        $content .= $this->getDirectoryStructure(base_path());
        $content .= "\n\n";

        // --- 2. STATUS DAS URLS ---
        $this->info('Lendo status das URLs...');
        $urlMapFile = base_path('docs/MAPEAMENTO_URLS.md');
        if (File::exists($urlMapFile)) {
            $content .= "================================================================================\n";
            $content .= "STATUS DAS URLS (MAPEAMENTO_URLS.md)\n";
            $content .= "================================================================================\n";
            $content .= File::get($urlMapFile);
            $content .= "\n\n";
        } else {
            $this->warn('Arquivo MAPEAMENTO_URLS.md não encontrado em docs/.');
        }

        // --- 3. CÓDIGO FONTE (Lógica + Blades) ---
        $this->info('Coletando código fonte (App, Views, Routes, Config, Migrations)...');
        $content .= "================================================================================\n";
        $content .= "CONTEÚDO DOS ARQUIVOS\n";
        $content .= "================================================================================\n\n";

        $finder = new Finder();
        $finder->files()
            ->in([
                base_path('app'),
                base_path('resources/views'),
                base_path('routes'),
                base_path('config'),
                base_path('database/migrations'),
            ])
            ->name('*.php')
            ->name('*.blade.php')
            ->notName('*.min.js') // Ignora minificados se houver
            ->sortByName();

        foreach ($finder as $file) {
            $relativePath = str_replace(base_path() . DIRECTORY_SEPARATOR, '', $file->getRealPath());
            // Normaliza barras para forward slash
            $relativePath = str_replace('\\', '/', $relativePath);

            $this->line("Adicionando: $relativePath");

            $content .= "--------------------------------------------------------------------------------\n";
            $content .= "FILE: $relativePath\n";
            $content .= "--------------------------------------------------------------------------------\n";
            $content .= $file->getContents();
            $content .= "\n\n";
        }

        File::put($outputFile, $content);

        $this->info("Contexto gerado com sucesso em: $outputFile");
        $this->info("Tamanho total: " . round(filesize($outputFile) / 1024 / 1024, 2) . " MB");
    }

    private function getDirectoryStructure($path, $prefix = '')
    {
        $structure = '';
        $directories = File::directories($path);
        $files = File::files($path);

        // Directories to ignore
        $ignoreDirs = ['.git', '.idea', '.vscode', 'vendor', 'node_modules', 'storage', 'public/build'];
        // Files to ignore
        $ignoreFiles = ['.DS_Store', 'Thumbs.db', 'composer.lock', 'package-lock.json', 'yarn.lock', 'phpstan.neon', 'phpunit.xml'];

        // Filter directories
        $directories = array_filter($directories, function ($dir) use ($ignoreDirs) {
            return !in_array(basename($dir), $ignoreDirs);
        });

        // Filter files
        $files = array_filter($files, function ($file) use ($ignoreFiles) {
            return !in_array($file->getFilename(), $ignoreFiles) && !str_ends_with($file->getFilename(), '.log'); // Ignore logs
        });

        foreach ($directories as $index => $dir) {
            $dirname = basename($dir);
            $structure .= $prefix . "├── " . $dirname . "/\n";
            // Reduce depth to avoid huge output, or keep full? Let's limit depth logic if needed, but for now full recursive for key dirs.
            // Actually, let's just go one level deep for simplicity in this visualization or recursive?
            // User requested structure. Recursive is better but 'vendor' is checked above so it won't explode.
            $structure .= $this->getDirectoryStructure($dir, $prefix . "│   ");
        }

        foreach ($files as $file) {
            $structure .= $prefix . "├── " . $file->getFilename() . "\n";
        }

        return $structure;
    }
}
