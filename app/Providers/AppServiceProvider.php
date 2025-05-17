<?php

namespace App\Providers;

use App\Services\Auth\AuthServices;
use App\Services\ArticleReview\ReviewService;
use Illuminate\Support\ServiceProvider;
use App\Services\Article\ArticleService;
use RealRashid\SweetAlert\Facades\Alert;
use App\Services\Auth\AuthServiceInterface;
use App\Services\Homepage\HomepageServices;
use App\Services\ArticleReview\ReviewServiceInterface;
use App\Services\Article\ArticleServiceInterface;
use App\Services\Homepage\HomepageServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        RealRashid\SweetAlert\SweetAlertServiceProvider::class;
        $this->app->bind(AuthServiceInterface::class, AuthServices::class);
        $this->app->bind(ArticleServiceInterface::class, ArticleService::class);
        $this->app->bind(HomepageServiceInterface::class, HomepageServices::class);
        $this->app->bind(ReviewServiceInterface::class, ReviewService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
    }
}
