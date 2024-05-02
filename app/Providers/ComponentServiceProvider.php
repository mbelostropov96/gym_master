<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ComponentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::componentNamespace('App\\View\\Components\\Admin', 'admin');
        Blade::componentNamespace('App\\View\\Components\\Common', 'common');
        Blade::componentNamespace('App\\View\\Components\\Profile', 'profile');
        Blade::componentNamespace('App\\View\\Components\\Reservations', 'reservations');
        Blade::componentNamespace('App\\View\\Components\\Trainings', 'trainings');
    }
}
