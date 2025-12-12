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
        // Create admin user
        User::create([
            'name' => 'Admin LosFit',
            'email' => 'admin@losfit.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'is_admin' => true,
        ]);

        // Seed categories and attributes
        $this->call([
            CategoriesSeeder::class,
            ProductAttributesSeeder::class,
            SampleProductsSeeder::class,
            LinkItemSeeder::class,
        ]);

        $this->command->info('');
        $this->command->info('🎉 Database seeding completed!');
        $this->command->info('📧 Admin: admin@losfit.com | Password: password');
    }
}
