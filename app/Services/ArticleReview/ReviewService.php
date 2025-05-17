<?php

namespace App\Services\ArticleReview;

use App\Models\Article;
use App\Models\ArticleReview;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewService implements ReviewServiceInterface
{
    public function getArticlesForReview()
    {
        // Ambil artikel dengan status pending_review
        return Article::where('status', 'pending_review')->get();
    }
    
    public function getReviewerArticles()
    {
        // Ambil artikel yang ditugaskan ke reviewer yang sedang login
        $reviewerId = Auth::id();
        
        return Article::whereHas('reviews', function($query) use ($reviewerId) {
            $query->where('reviewer_id', $reviewerId)
                  ->where('status', 'pending');
        })->get();
    }
    
    public function assignReviewer($articleId, $reviewerId)
    {
        // Cek apakah reviewer sudah ditugaskan ke artikel ini
        $exists = ArticleReview::where('article_id', $articleId)
                              ->where('reviewer_id', $reviewerId)
                              ->exists();
        
        if (!$exists) {
            // Buat tugas review baru
            return ArticleReview::create([
                'article_id' => $articleId,
                'reviewer_id' => $reviewerId,
                'status' => 'pending'
            ]);
        }
        
        return false;
    }
    
    public function submitReview($articleId, $reviewerId, $status, $comments)
    {
        // Cari review yang ada
        $review = ArticleReview::where('article_id', $articleId)
                              ->where('reviewer_id', $reviewerId)
                              ->first();
        
        if ($review) {
            // Update review
            $review->update([
                'status' => $status,
                'comments' => $comments,
                'reviewed_at' => now()
            ]);
            
            // Update status artikel berdasarkan kebijakan review
            $this->updateArticleStatus($articleId);
            
            return $review;
        }
        
        return false;
    }
    
    public function updateArticleStatus($articleId)
    {
        $article = Article::findOrFail($articleId);
        $reviews = $article->reviews;
        
        // Hitung jumlah review
        $totalReviews = $reviews->count();
        $approvedReviews = $reviews->where('status', 'approved')->count();
        $rejectedReviews = $reviews->where('status', 'rejected')->count();
        
        // Logika untuk menentukan status artikel
        // Contoh: Jika semua reviewer telah memberikan review dan mayoritas menyetujui
        $allReviewed = $reviews->where('status', '!=', 'pending')->count() === $totalReviews;
        
        if ($allReviewed) {
            if ($approvedReviews > $rejectedReviews) {
                $article->reviews->status = 'approved';
                $article->reviews->reviewed_at = now();
                $article->published_at = now(); // Atur tanggal publikasi
            } else {
                $article->status = 'rejected';
            }
            
            // Gabungkan semua komentar review
            $reviewNotes = $reviews->pluck('comments')->filter()->implode("\n\n");
            $article->reviews->comments = $reviewNotes;
            
            $article->save();
        }
        
        return $article;
    }
    
    public function getReviewers()
    {
        // Ambil semua user dengan role Reviewer
        return User::where('role', 'Reviewer')->get();
    }
}
