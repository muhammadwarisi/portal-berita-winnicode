<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\ArticleReview;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = [
            'artikelCount' => Article::count(),
            'userCount' => User::count(),
        ];

        // Data untuk Admin
        if ($user->role_id == 1) {
            $data['approvedArticles'] = Article::where('status', 'approved')->count();
            $data['pendingReviews'] = Article::where('status', 'pending_review')->count();
            $data['rejectedArticles'] = Article::where('status', 'rejected')->count();
        }

        // Data untuk Reviewer
        elseif ($user->role_id == 2) {
            $data['assignedArticles'] = ArticleReview::where('reviewer_id', $user->id)->count();
            $data['pendingReviews'] = ArticleReview::where('reviewer_id', $user->id)
                ->where('status', 'pending')
                ->count();
            $data['completedReviews'] = ArticleReview::where('reviewer_id', $user->id)
                ->whereIn('status', ['approved', 'rejected'])
                ->count();
            $data['articlesToReview'] = Article::whereHas('reviews', function ($query) use ($user) {
                $query->where('reviewer_id', $user->id)
                    ->where('status', 'pending');
            })
                ->take(5)
                ->get();
        }

        // Data untuk Author
        elseif ($user->role_id == 3) {
            $data['myArticles'] = Article::where('user_id', $user->id)->count();
            $data['publishedArticles'] = Article::where('user_id', $user->id)
                ->where('status', 'approved')
                ->count();
            $data['pendingArticles'] = Article::where('user_id', $user->id)
                ->where('status', 'pending_review')
                ->count();
            $data['recentArticles'] = Article::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        }

        return view('welcome', $data);
    }
}
