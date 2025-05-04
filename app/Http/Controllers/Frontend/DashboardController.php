<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Homepage\HomepageServices;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $homepageService;
    public function __construct(HomepageServices $homepageService)
    {
        $this->homepageService = $homepageService;
    }
    public function halamanAwal()
    {
        $categories = $this->homepageService->getCategories();
        $recommendedArticles = $this->homepageService->getRecommendedArticles(6);
        $latestArticles = $this->homepageService->getLatestArticles(10);
        $trendingArticles = $this->homepageService->getTrendingArticles(10);
        $featuredArticles = $this->homepageService->getPopularArticles(5);
        return view('home.index', compact('categories', 'recommendedArticles', 'latestArticles', 'trendingArticles','featuredArticles'));
    }

    public function halamanKategori($slug)
    {
        $categories = $this->homepageService->getCategories();
        $category = $this->homepageService->getCategoryBySlug($slug);
        $recommendedArticles = $this->homepageService->getRecommendedArticles(6);
        $latestArticles = $this->homepageService->getLatestArticles(10);
        $trendingArticles = $this->homepageService->getTrendingArticles(10);

        if (!$category) {
            abort(404);
        }

        $articles = $this->homepageService->getArticlesByCategory($category->id);

        return view('home.article_by_category', compact('categories', 'category', 'articles', 'latestArticles', 'recommendedArticles', 'trendingArticles'));
    }

    public function halamanArtikel($id)
    {
        $categories = $this->homepageService->getCategories();
        $recommendedArticles = $this->homepageService->getRecommendedArticles(6);
        $latestArticles = $this->homepageService->getLatestArticles(10);
        $trendingArticles = $this->homepageService->getTrendingArticles(10);
        $popularArticles = $this->homepageService->getPopularArticles(5);
        $relatedArticles = $this->homepageService->getRelatedArticles($id);
        $article = $this->homepageService->getArticleById($id);

        if (!$article) {
            abort(404);
        }
        return view('home.article_detail', compact('categories', 'article', 'latestArticles', 'recommendedArticles', 'trendingArticles', 'relatedArticles', 'popularArticles'));
    }

    public function incrementView($id)
    {
        $article = $this->homepageService->getArticleById($id);
        $article->increment('view_count');
        return response()->json(['success' => true]);
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $categories = $this->homepageService->getCategories();
        $articles = $this->homepageService->getArticleBySearch($request->input('q'));
        return view('home.search', compact('articles','query','categories'));
    }
}
