<?php

namespace App\Providers;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use PSpell\Config;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use App\Models\Student;

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
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
    }
}
