<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserArticleViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role_id', 3)->get(); // Regular users
        $articles = Article::all();
        
        foreach ($users as $user) {
            // Each user views 10-20 random articles
            $viewCount = rand(10, 20);
            $viewedArticles = $articles->random($viewCount);
            
            foreach ($viewedArticles as $article) {
                DB::table('user_article_views')->insert([
                    'user_id' => $user->id,
                    'article_id' => $article->id,
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
