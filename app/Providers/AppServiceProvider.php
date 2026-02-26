<?php

namespace App\Providers;

use App\Models\Business\BusinessReview;
use App\Observers\Business\BusinessReviewObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register domain-namespaced view paths for better organization
        View::addNamespace('africoders', resource_path('views/africoders'));
        View::addNamespace('shared', resource_path('views/shared'));

        // Register model observers
        BusinessReview::observe(BusinessReviewObserver::class);
    }
}
