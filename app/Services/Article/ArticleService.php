<?php

namespace App\Services\Article;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleService implements ArticleServiceInterface
{
    public function getAllArticles()
    {
        return Article::all();
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
