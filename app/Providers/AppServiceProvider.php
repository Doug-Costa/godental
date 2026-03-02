<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

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
        // Forçar HTTP no IP de teste para evitar erro de Mixed Content e falha de SSL
        $isStaging = str_contains(request()->fullUrl(), '187.77.48.78') || str_contains(env('APP_URL', ''), '187.77.48.78');

        if ($isStaging) {
            \URL::forceScheme('http');
        } elseif (env('APP_ENV') !== 'local') {
            \URL::forceScheme('https');
        }

        Paginator::useBootstrapFive();

        // Share ServicePrice with consultation modals
        \Illuminate\Support\Facades\View::composer(
            ['facelift2.partials.modal_nova_consulta', 'consultas.hub', 'consultas.index', 'patients.show'],
            function ($view) {
                $view->with('servicePrices', \App\Models\ServicePrice::all());
            }
        );
    }
}
