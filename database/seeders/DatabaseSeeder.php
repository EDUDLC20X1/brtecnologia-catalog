<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            CategorySeeder::class,
            SiteContentSeeder::class,
            // Productos - 657 productos en total
            ProductSeeder::class,
            ProductSeederPart2::class,
            ProductSeederPart3::class,
            ProductSeederPart4::class,
            ProductSeederFixes::class,
            // Iconos de categorías
            CategoryIconsCompleteSeeder::class,
        ]);
    }
}
