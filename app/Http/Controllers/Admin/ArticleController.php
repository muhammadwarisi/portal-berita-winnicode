<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Models\Category;
use App\Services\Article\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index()
    {
        $articles = $this->articleService->getAllArticles();
        return view('admin.article.index', compact('articles'));
    }

    public function create()
    {
        $category = Category::all();
        return view('admin.article.create', compact('category'));
    }

    public function store(ArticleRequest $request)
    {
        $this->articleService->createArticle($request->validated());

        return redirect()->route('index.artikel')
            ->with('message', 'Article created successfully');
    }
    public function show($id)
    {
        $article = $this->articleService->getArticleById($id);
        return view('admin.article.show', compact('article'));
    }

    public function edit($id)
    {
        $article = $this->articleService->edit($id);
        $category = Category::all();
        return view('admin.article.edit', compact('article', 'category'));
    }

    public function update(ArticleRequest $request, $id)
    {
        $this->articleService->update($request->validated(), $id);

        return redirect()->route('index.artikel')
            ->with('message', 'Article updated successfully');
    }

    public function destroy($id)
    {
        $this->articleService->delete($id);

        return redirect()->route('index.artikel')
            ->with('message', 'Article deleted successfully');
    }
}
