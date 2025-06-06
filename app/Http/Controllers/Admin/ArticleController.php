<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Services\Article\ArticleService;
use RealRashid\SweetAlert\Facades\Alert;

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
        // dd(Article::with('user')->get());
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

        Alert::success('Success', 'Article created successfully');

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
        Alert::success('Success', 'Article updated successfully');
        return redirect()->route('index.artikel')
            ->with('message', 'Article updated successfully');
    }

    public function destroy($id)
    {
        $this->articleService->delete($id);
        Alert::success('Success', 'Article deleted successfully');
        return redirect()->route('index.artikel')
            ->with('message', 'Article deleted successfully');
    }
}
