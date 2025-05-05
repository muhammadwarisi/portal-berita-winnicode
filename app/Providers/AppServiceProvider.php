<?php

namespace App\Providers;

use App\Services\Article\ArticleService;
use App\Services\Article\ArticleServiceInterface;
use App\Services\Auth\AuthServices;
use App\Services\Auth\AuthServiceInterface;
use App\Services\Homepage\HomepageServiceInterface;
use App\Services\Homepage\HomepageServices;
use Illuminate\Support\ServiceProvider;
use RealRashid\SweetAlert\Facades\Alert;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
    }
}
