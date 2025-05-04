<?php
namespace App\Services\Homepage;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\Homepage\HomepageServiceInterface;

class HomepageServices implements HomepageServiceInterface
{
    public function getArticles()
    {
        return Article::all();
    }

    public function getCategories()
    {
        return Category::all();
    }

    public function getArticlesByCategory($category)
    {
        return Article::where('category', $category)->get();
    }

    public function getRecommendedArticles($limit = 5)
    {
        // If user is logged in, use personalized recommendations
        if (Auth::check()) {
            $user = Auth::user();
            
            // Get user's recently read article categories
            $userReadCategories = $this->getUserReadCategories($user->id);
            
            if (!empty($userReadCategories)) {
                // Content-based filtering: recommend articles from similar categories
                return $this->getArticlesBySimilarCategories($userReadCategories, $limit);
            }
        }
        
        // Fallback to popularity-based recommendations
        return $this->getPopularArticles($limit);
    }

    /**
     * Get user's most read categories
     */
    public function getUserReadCategories($userId)
    {
        // Assuming you have a user_article_views table that tracks which articles users have viewed
        return DB::table('user_article_views')
            ->join('articles', 'user_article_views.article_id', '=', 'articles.id')
            ->where('user_article_views.user_id', $userId)
            ->select('articles.category_id', DB::raw('COUNT(*) as view_count'))
            ->groupBy('articles.category_id')
            ->orderBy('view_count', 'desc')
            ->limit(3)
            ->pluck('category_id')
            ->toArray();
    }

    /**
     * Get articles from similar categories
     */
    public function getArticlesBySimilarCategories($categoryIds, $limit)
    {
        return Article::whereIn('category_id', $categoryIds)
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }
    
    /**
     * Get popular articles based on view count
     */
    public function getPopularArticles($limit)
    {
        // Assuming you have a view_count column in your articles table
        return Article::where('published_at', '<=', now())
            ->orderBy('view_count', 'desc')
            ->limit($limit)
            ->get();
    }
    
    /**
     * Get trending articles (popular in the last 7 days)
     */
    public function getTrendingArticles($limit = 5)
    {
        return Article::where('published_at', '<=', now())
            ->where('published_at', '>=', now()->subDays(7))
            ->orderBy('view_count', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getLatestArticles($limit = 5)
    {
        return Article::where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
