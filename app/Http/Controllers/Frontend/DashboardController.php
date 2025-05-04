<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Homepage\HomepageServices;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $homepageService;
    public function __construct(HomepageServices $homepageService)
    {
        $this->homepageService = $homepageService;
    }
    public function halamanAwal()
    {
        $categories = $this->homepageService->getCategories();
        $recommendedArticles = $this->homepageService->getRecommendedArticles();
        $latestArticles = $this->homepageService->getLatestArticles(10);
        return view('layouts.frontend.app', compact('categories','recommendedArticles','latestArticles'));
    }
}
