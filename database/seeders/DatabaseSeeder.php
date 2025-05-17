<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\RolesSeeder;
use Database\Seeders\ArticleSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ArticleReviewSeeder;
use Database\Seeders\UserArticleViewSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            CategorySeeder::class,
            UserSeeder::class,
            ArticleSeeder::class,
            UserArticleViewSeeder::class,
            ArticleReviewSeeder::class,
        ]);
    }
}
