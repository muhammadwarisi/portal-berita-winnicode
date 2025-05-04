<?php

namespace App\Services\Article;

interface ArticleServiceInterface
{
    public function createArticle(array $artikel);
    public function getAllArticles();
    public function getArticleById($id);

}

