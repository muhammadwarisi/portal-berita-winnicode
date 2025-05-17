<?php

namespace App\Services\Article;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleService implements ArticleServiceInterface
{
    public function getAllArticles()
    {
        $user = Auth::user();
        if ($user->role === 'Admin') {
            return Article::with('user')->get();
        } elseif ($user->role === 'Reviewer') {
            // Reviewer hanya melihat artikel yang perlu direview
            return Article::where('status', 'pending_review')->with('user')->get();
        } else {
            // Editor melihat artikel miliknya
            return Article::where('user_id', $user->id)->with('user')->get();
        }
        
    }

    public function getArticlesByUserId($userId)
    {
        return Article::where('user_id', $userId)->get();
    }
    public function createArticle($data)
    {
        // Handle featured image upload
        if (isset($data['featured_image'])) {
            $imagePath = $data['featured_image']->store('articles', 'public');
            $data['featured_image'] = $imagePath;
        }

        // Set additional data
        $data['user_id'] = Auth::id();
        $data['published_at'] = now();

        // Create new article
        return Article::create($data);
    }

    public function getArticleById($id)
    {
        return Article::findOrFail($id);
    }

    public function edit($id)
    {
        return Article::findOrFail($id);
    }

    public function update(array $data, $id)
    {
        $article = Article::findOrFail($id);

        if (isset($data['featured_image'])) {
            // Delete old image
            Storage::disk('public')->delete($article->featured_image);
            // Store new image
            $data['featured_image'] = $data['featured_image']->store('articles', 'public');
        } else {
            // Keep existing image
            unset($data['featured_image']);
        }

        return $article->update($data);
    }

    public function delete($id)
    {
        $article = Article::findOrFail($id);

        // Delete the featured image from storage
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        return $article->delete();
    }
}
