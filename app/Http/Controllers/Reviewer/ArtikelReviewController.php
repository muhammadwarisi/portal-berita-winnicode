<?php

namespace App\Http\Controllers\Reviewer;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ArticleReview\ReviewService;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ArtikelReviewController extends Controller
{
    protected $artikelReview;
    public function __construct(ReviewService $reviewService)
    {
        $this->artikelReview = $reviewService;
    }
    public function index()
    {
        // Ambil artikel yang ditugaskan ke reviewer yang sedang login
        $artikel = $this->artikelReview->getReviewerArticles();
        return view('admin.article-review.index', compact('artikel'));
    }
    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('admin.article-review.show', compact('article'));
    }
    
    public function submitReview(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'comments' => 'required|string|min:10',
        ]);
        
        $reviewerId = Auth::id();
        $status = $request->status;
        $comments = $request->comments;
        
        $result = $this->artikelReview->submitReview($id, $reviewerId, $status, $comments);
        
        if ($result) {
            Alert::success('Success', 'Review berhasil disubmit');
            return redirect()->route('reviewer.artikel.index');
        }
        
        Alert::error('Error', 'Gagal submit review');
        return back();
    }
    
    public function reviewForm($id)
    {
        $article = Article::findOrFail($id);
        return view('admin.article-review.review', compact('article'));
    }
}
