<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateSeedersFromDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:generate-seeders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate seeders from current database content for production mirror';

    /**
     * tables/models to export
     */
    protected $tables = [
        'users' => [
            'model' => \App\Models\User::class,
            'seeder' => 'ProductionUsersSeeder',
            'order' => 'id',
        ],
        'categories' => [
            'model' => \App\Domains\Catalog\Models\Category::class,
            'seeder' => 'ProductionCategoriesSeeder',
            'order' => 'id',
        ],
        'products' => [
            'model' => \App\Domains\Catalog\Models\Product::class,
            'seeder' => 'ProductionProductsSeeder',
            'order' => 'id',
        ],
        'sign_cards' => [
            'model' => \App\Domains\Content\Models\SignCard::class,
            'seeder' => 'ProductionSignCardsSeeder', // Splitting DeployRecovery for clarity, or can merge later
            'order' => 'id',
        ],
        'store_settings' => [
            'model' => \App\Domains\Shared\Models\StoreSetting::class,
            'seeder' => 'ProductionSettingsSeeder',
            'order' => 'id',
        ],
        'grid_rules' => [
            'model' => \App\Domains\Catalog\Models\GridRule::class,
            'seeder' => 'ProductionGridRulesSeeder',
            'order' => 'position',
        ],
        'newsletter_campaigns' => [
            'model' => \App\Domains\Marketing\Models\NewsletterCampaign::class,
            'seeder' => 'ProductionCampaignsSeeder',
            'order' => 'id',
        ],
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting Seeder Generation from Real Data...');

        foreach ($this->tables as $table => $config) {
            $this->generateSeeder($table, $config);
        }

        $this->info(' All Production Seeders Generated!');
        $this->info('PLEASE CHECK: Update your DatabaseSeeder.php to call these new seeders.');
    }

    protected function generateSeeder($tableName, $config)
    {
        $className = $config['seeder'];
        $modelClass = $config['model'];

        if (!class_exists($modelClass)) {
            $this->warn("Model $modelClass not found. Skipping $tableName.");
            return;
        }

        // Fetch data
        $records = $modelClass::orderBy($config['order'])->get()->makeVisible(['password', 'remember_token']); // Show hidden if needed
        
        if ($records->isEmpty()) {
            $this->warn("No records found for $tableName. Skipping.");
             // Still create empty seeder to avoid errors if called? No, better skip or create empty.
             // Let's create empty to be safe.
        }

        $dataArrayString = "[\n";
        foreach ($records as $record) {
            $attributes = $record->getAttributes();
            
            // CLEANUP: 
            // 1. Remove ID if you want auto-increment, BUT for mirroring, we usually WANT IDs to match relationships.
            //    So we KEEP IDs.
            // 2. Handle NULLs
            // 3. Escape strings
            
            $dataArrayString .= "            [\n";
            foreach ($attributes as $key => $value) {
                // Formatting value
                $formattedValue = $this->formatValue($value);
                $dataArrayString .= "                '$key' => $formattedValue,\n";
            }
            $dataArrayString .= "            ],\n";
        }
        $dataArrayString .= "        ]";

        // Seeder Template
        $content = "<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use {$modelClass};

class {$className} extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate
        {$this->getModelShortName($modelClass)}::truncate();

        // Data
        \$data = {$dataArrayString};

        foreach (\$data as \$item) {
            {$this->getModelShortName($modelClass)}::create(\$item);
        }

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
";

        $path = database_path("seeders/{$className}.php");
        File::put($path, $content);
        $this->info("Generated: {$className}.php (" . $records->count() . " records)");
    }

    protected function formatValue($value)
    {
        if (is_null($value)) {
            return 'null';
        }
        if (is_int($value) || is_float($value)) {
            return $value;
        }
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }
        
        // Escape single quotes
        $value = str_replace("'", "\'", $value);
        // Ensure backslashes are escaped if needed (basic version)
        // $value = str_replace('\\', '\\\\', $value); 
        
        return "'$value'";
    }

    protected function getModelShortName($fullClass)
    {
        return class_basename($fullClass);
    }
}
