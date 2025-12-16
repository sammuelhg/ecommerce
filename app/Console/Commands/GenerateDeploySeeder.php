<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\SignCard;
use App\Models\StoreSetting;
use App\Models\GridRule;

class GenerateDeploySeeder extends Command
{
    protected $signature = 'make:deploy-seeder';
    protected $description = 'Export data and assets for deployment recovery';

    public function handle()
    {
        $this->info('Starting Deployment Bundle Generation...');

        // 1. Prepare Target Directory
        $targetDir = public_path('deploy_assets/forced_migration');
        if (!File::exists($targetDir)) {
            File::makeDirectory($targetDir, 0755, true);
        }
        $this->info("Target directory created: {$targetDir}");

        // 2. Process Sign Cards
        $this->info('Processing Sign Cards...');
        $signCards = SignCard::all()->map(function ($card) use ($targetDir) {
            $data = $card->toArray(); 
            // Fix: Access raw attribute to avoid accessor modifictions if model doesn't use append
            $avatar = $card->getRawOriginal('avatar_url'); 
            
            if ($avatar) {
                $newPath = $this->copyAsset($avatar, $targetDir, 'card');
                if ($newPath) {
                    $data['avatar_url'] = $newPath;
                    $this->line("Copied SignCard avatar: {$avatar} -> {$newPath}");
                }
            }
            return $data;
        });

        // 3. Process Store Settings (Logos)
        $this->info('Processing Store Settings...');
        $targetKeys = ['store_logo', 'footer_logo', 'email_logo', 'profile_logo', 'favicon'];
        $storeSettings = StoreSetting::whereIn('key', $targetKeys)->get()->map(function ($setting) use ($targetDir) {
            $data = $setting->toArray();
            $value = $setting->value; // Accessor might return array or string
            
            // Fix: If value is an array/object (due to JSON cast/accessor), encode back to string for storage path check
            $checkValue = is_array($value) || is_object($value) ? json_encode($value) : $value;
            
            if (is_string($checkValue) && (str_contains($checkValue, '/storage/') || str_contains($checkValue, 'http'))) {
                 $newPath = $this->copyAsset($checkValue, $targetDir, 'setting');
                 if ($newPath) {
                     $data['value'] = $newPath;
                     $this->line("Copied Setting {$setting->key}: {$checkValue} -> {$newPath}");
                 }
            }

            // CRITICAL FIX: Ensure value is stored as string/json encoded for the seeder array
            // because strict 'updateOrCreate' might fail if passed an array for a string column without mutator.
            // AND the generated seeder code puts this into a PHP array structure.
            // If $data['value'] is an array, var_export will output it as an array.
            // When seeder runs: 'value' => ['foo' => 'bar']
            // Eloquent updateOrCreate(['value' => ['foo' => 'bar']]) -> Exception: Array to string conversion if column is text.
            
            if (is_array($data['value']) || is_object($data['value'])) {
                $data['value'] = json_encode($data['value']);
            }

            return $data;
        });

        // 4. Process Grid Rules
        $this->info('Processing Grid Rules...');
        $gridRules = GridRule::all()->map(function ($rule) use ($targetDir) {
            $data = $rule->toArray();
            $config = $rule->configuration ?? []; // Casted to array

            if (isset($config['image'])) {
                $newPath = $this->copyAsset($config['image'], $targetDir, 'grid');
                if ($newPath) {
                    $config['image'] = $newPath;
                    $data['configuration'] = $config; 
                    $this->line("Copied GridRule Image: {$newPath}");
                }
            }
            
            // Fix: Ensure configuration is encoded as string if the DB expects it?
            // GridRule casts 'configuration' => 'array'.
            // If we pass an array to create(), Eloquent handles json_encode automatically thanks to casting.
            // UNLIKE StoreSetting which relies on manual 'type' column and might not cast 'value' automatically.
            // So GridRule is likely fine, but checking StoreSettings was critical.
            
            return $data;
        });

        // 5. Generate Seeder Content
        $seederContent = $this->generateSeederTemplate($signCards, $storeSettings, $gridRules);
        
        $seederPath = database_path('seeders/DeployRecoverySeeder.php');
        File::put($seederPath, $seederContent);

        $this->info("Seeder generated successfully at: {$seederPath}");
        $this->warn("IMPORTANT: Commit 'public/deploy_assets' and 'database/seeders/DeployRecoverySeeder.php' before deploying.");
    }

    private function copyAsset($sourcePath, $targetDir, $prefix = 'asset')
    {
        // 1. Clean Path (remove domain)
        $relativePath = preg_replace('/^http(s)?:\/\/[^\/]+/', '', $sourcePath);
        
        // Remove /storage/ prefix for storage disk check
        $storageRelativePath = $relativePath;
        if (str_starts_with($storageRelativePath, '/storage/')) {
            $storageRelativePath = substr($storageRelativePath, 9);
        }
        $storageRelativePath = ltrim($storageRelativePath, '/');

        // Remove leading slash for public path check
        $publicRelativePath = ltrim($relativePath, '/');

        $sourceFullPath = null;

        // Check 1: Storage Disk
        if (Storage::disk('public')->exists($storageRelativePath)) {
            $sourceFullPath = Storage::disk('public')->path($storageRelativePath);
        }
        // Check 2: Direct public folder
        elseif (File::exists(public_path($publicRelativePath))) {
            $sourceFullPath = public_path($publicRelativePath);
        }

        if ($sourceFullPath && File::exists($sourceFullPath)) {
            $fileName = basename($sourceFullPath);
            
            // Simplify Filename: prefix_originalName
            // Clean filename to be safe
            $safeName = preg_replace('/[^a-zA-Z0-9._-]/', '', $fileName);
            $destName = $prefix . '_' . $safeName;

            $destPath = $targetDir . '/' . $destName;
            
            File::copy($sourceFullPath, $destPath);
            
            return '/deploy_assets/forced_migration/' . $destName;
        }
        
        $this->warn("Could not find asset: {$sourcePath}");
        return null;
    }

    private function generateSeederTemplate($signCards, $storeSettings, $gridRules)
    {
        $cardsExport = $this->varExport($signCards->toArray());
        $settingsExport = $this->varExport($storeSettings->toArray());
        $rulesExport = $this->varExport($gridRules->toArray());

        return <<<PHP
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SignCard;
use App\Models\StoreSetting;
use App\Models\GridRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DeployRecoverySeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        // 1. Restore Sign Cards
        DB::table('sign_cards')->truncate();
        \$cards = {$cardsExport};
        foreach (\$cards as \$card) {
            SignCard::create(\$card);
        }

        // 2. Restore Settings
        \$settings = {$settingsExport};
        foreach (\$settings as \$setting) {
            StoreSetting::updateOrCreate(
                ['key' => \$setting['key']],
                [
                    'value' => \$setting['value'],
                    'type' => \$setting['type']
                ]
            );
        }

        // 3. Restore Grid Rules
        DB::table('grid_rules')->truncate();
        \$rules = {$rulesExport};
        foreach (\$rules as \$rule) {
            // Encode configuration if necessary, usually Model handles casting
            GridRule::create(\$rule);
        }

        Schema::enableForeignKeyConstraints();
    }
}
PHP;
    }

    private function varExport($expression)
    {
        return var_export($expression, true);
    }
}
