<?php

namespace App\Providers;

use App\Contracts\ExternalApiService;
use App\Http\Controllers\NewsApi\ArticleController;
use App\Http\Controllers\NewsApi\SourceController;
use App\Http\Controllers\Skyscanner\BrowseQuotesController;
use App\Services\ExternalApi\NewsApi\Articles;
use App\Services\ExternalApi\NewsApi\Sources;
use App\Services\ExternalApi\Skyscanner\BrowseQuotes;
use Illuminate\Support\ServiceProvider;

class ExternalApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //Binding for NewsApi Sources
        $this->app
            ->when(SourceController::class)
            ->needs(ExternalApiService::class)
            ->give(function () {
                return new Sources();
            });

        //Binding for NewsApi Articles
        $this->app
            ->when(ArticleController::class)
            ->needs(ExternalApiService::class)
            ->give(function () {
                return new Articles();
            });

        //Binding for Skyscanner Browse Quotes
        $this->app
            ->when(BrowseQuotesController::class)
            ->needs(ExternalApiService::class)
            ->give(function () {
                return new BrowseQuotes();
            });
    }
}
