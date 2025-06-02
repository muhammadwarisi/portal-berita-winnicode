<?php

namespace App\Services\Homepage;

use App\Models\Article;
use App\Models\Category;
use App\Models\UserArticleViews;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\Homepage\HomepageServiceInterface;

class HomepageServices implements HomepageServiceInterface
{
    public function getArticles()
    {
        return Article::whereHas('reviews', function ($query) {
            $query->where('status', 'approved');
        })->all();
    }

        /**
     * Get article by ID or slug
     * 
     * @param string|int $idOrSlug ID atau slug artikel
     * @return \App\Models\Article
     */
    public function getArticleById($idOrSlug)
    {
        // Cek apakah parameter adalah ID (angka) atau slug (string)
        $isId = is_numeric($idOrSlug);
        
        // Cari artikel berdasarkan ID atau slug
        if ($isId) {
            $article = Article::findOrFail($idOrSlug);
        } else {
            $article = Article::where('slug', $idOrSlug)->firstOrFail();
        }
        
        // Cek apakah artikel sudah dilihat dalam session saat ini
        $viewedArticles = session()->get('viewed_articles', []);
        $articleId = $article->id;
        
        // Jika artikel belum dilihat dalam session ini, increment view_count
        if (!in_array($articleId, $viewedArticles)) {
            $article->increment('view_count');
            
            // Tambahkan artikel ke daftar yang sudah dilihat
            $viewedArticles[] = $articleId;
            session()->put('viewed_articles', $viewedArticles);
            
            // Jika user login, catat di user_article_views
            if (Auth::check()) {
                // Cek apakah sudah ada catatan view untuk user ini
                $userView = UserArticleViews::where('user_id', Auth::id())
                    ->where('article_id', $articleId)
                    ->first();
                
                // Jika belum ada, buat catatan baru
                if (!$userView) {
                    UserArticleViews::create([
                        'user_id' => Auth::id(),
                        'article_id' => $articleId
                    ]);
                }
            }
        }
        
        return $article;
    }
    // public function getArticleById($id)
    // {
    //     $article = Article::findOrFail($id);
        
    //     // Cek apakah artikel sudah dilihat dalam session saat ini
    //     $viewedArticles = session()->get('viewed_articles', []);
        
    //     // Jika artikel belum dilihat dalam session ini, increment view_count
    //     if (!in_array($id, $viewedArticles)) {
    //         $article->increment('view_count');
            
    //         // Tambahkan artikel ke daftar yang sudah dilihat
    //         $viewedArticles[] = $id;
    //         session()->put('viewed_articles', $viewedArticles);
            
    //         // Jika user login, catat di user_article_views
    //         if (Auth::check()) {
    //             // Cek apakah sudah ada catatan view untuk user ini
    //             $userView = UserArticleViews::where('user_id', Auth::id())
    //                 ->where('article_id', $id)
    //                 ->first();
                
    //             // Jika belum ada, buat catatan baru
    //             if (!$userView) {
    //                 UserArticleViews::create([
    //                     'user_id' => Auth::id(),
    //                     'article_id' => $id
    //                 ]);
    //             }
    //         }
    //     }
        
    //     return $article;
    // }

    public function getArticleBySearch($search)
    {
        $query = $search;

        return Article::whereHas('reviews', function ($query) {
            $query->where('status', 'approved');
            })
            ->where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->paginate(12);
    }

    public function getCategories()
    {
        return Category::all();
    }

    public function getArticlesByCategory($category)
    {
        return Article::whereHas('reviews', function($query) {
            $query->where('status', 'approved');
            })
            ->where('category_id', $category)->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->paginate(12);
    }

    public function getCategoryBySlug($slug)
    {
        return Category::where('slug', $slug)->first();
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
            ->whereHas('reviews', function($query) {
                $query->where('status', 'approved');
            })
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
        return Article::whereHas('reviews', function($query) {
            $query->where('status', 'approved');
            })
            ->whereIn('category_id', $categoryIds)
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
        return Article::whereHas('reviews', function($query) {
            $query->where('status', 'approved');
        })->where('published_at', '<=', now())
            ->orderBy('view_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get trending articles (popular in the last 7 days)
     */
    public function getTrendingArticles($limit = 5)
    {
        return Article::whereHas('reviews', function($query) {
            $query->where('status', 'approved');
        })->where('published_at', '<=', now())
            ->where('published_at', '>=', now()->subDays(7))
            ->orderBy('view_count', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getLatestArticles($limit = 5)
    {
        return Article::whereHas('reviews', function($query) {
            $query->where('status', 'approved');
            })
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getRelatedArticles($articleId, $limit = 5)
    {
        $article = Article::findOrFail($articleId);
        $categoryId = $article->category_id;

        return Article::whereHas('reviews', function($query) {
            $query->where('status', 'approved');
        })
            ->where('category_id', $categoryId)
            ->where('id', '!=', $articleId)
            ->where('published_at', '<=', now())->take($limit)->get();
    }
}
