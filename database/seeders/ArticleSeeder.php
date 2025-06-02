<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $categories = Category::all();
        $editors = User::where('role_id', 2)->get(); // Get editors
        
        // Create 50 articles
        for ($i = 0; $i < 50; $i++) {
            $title = $faker->sentence(rand(6, 10));
            $category = $categories->random();
            $editor = $editors->random();
            
            // Create article with random view count
            Article::create([
                'title' => $title,
                'content' => $faker->paragraphs(rand(5, 15), true),
                'slug' => Str::slug($title),
                'featured_image' => 'articles/default-' . rand(1, 5) . '.jpg',
                'category_id' => $category->id,
                'user_id' => $editor->id,
                'published_at' => $faker->dateTimeBetween('-3 months', 'now'),
                'view_count' => rand(10, 1000),
            ]);
        }
    }
}
