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
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
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
