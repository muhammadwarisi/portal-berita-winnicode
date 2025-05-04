<?php
namespace App\Services\Homepage;

interface HomepageServiceInterface
{
    public function getArticles();
    public function getArticlesByCategory($category);
    public function getArticleById($id);
    public function getArticleBySearch($search);
    public function getRecommendedArticles();
    public function getUserReadCategories($userId);
    public function getArticlesBySimilarCategories($categoryIds, $limit);
    public function getPopularArticles($limit);
    public function getTrendingArticles($limit);
    public function getRelatedArticles($articleId, $limit);
    
}
