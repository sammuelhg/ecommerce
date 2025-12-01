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
        // Create admin user
        User::factory()->create([
            'name' => 'Admin LosFit',
            'email' => 'admin@losfit.com',
            'password' => bcrypt('password'),
        ]);

        // Seed categories and attributes
        $this->call([
            CategoriesSeeder::class,
            ProductAttributesSeeder::class,
            SampleProductsSeeder::class,
        ]);

        $this->command->info('');
        $this->command->info('🎉 Database seeding completed!');
        $this->command->info('📧 Admin: admin@losfit.com | Password: password');
    }
}
