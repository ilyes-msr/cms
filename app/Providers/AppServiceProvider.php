<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\ViewComposers\CategoryComposer;
use App\Http\ViewComposers\CommentComposer;
use App\Http\ViewComposers\RoleComposer;
use App\Http\ViewComposers\PageComposer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view::composer(['partials.sidebar', 'lists.categories'], CategoryComposer::class);
        view::composer(['partials.sidebar'], CommentComposer::class);
        view::composer('lists.roles', RoleComposer::class);
        view::composer('lists.pages', PageComposer::class);
        Paginator::useBootstrap();

        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->isAdmin();
        });
    }
}
