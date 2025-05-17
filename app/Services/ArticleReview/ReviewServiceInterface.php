<?php

namespace App\Services\ArticleReview;

interface ReviewServiceInterface
{
    public function getArticlesForReview();
    public function getReviewerArticles();
    public function assignReviewer($articleId, $reviewerId);
    public function submitReview($articleId, $reviewerId, $status, $comments);
    public function updateArticleStatus($articleId);
    public function getReviewers();
}
