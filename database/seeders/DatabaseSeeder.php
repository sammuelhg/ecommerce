<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Production Mirror Seeding
        $this->call([
            ProductionUsersSeeder::class,
            ProductionCategoriesSeeder::class,
            ProductionProductsSeeder::class,
            ProductionSignCardsSeeder::class,
            ProductionSettingsSeeder::class,
            ProductionGridRulesSeeder::class,
            ProductionCampaignsSeeder::class,
        ]);

        $this->command->info('');
        $this->command->info('🎉 Production Mirror seeding completed!');
        $this->command->info('🚀 Use this data for valid deployment.');
    }
}
