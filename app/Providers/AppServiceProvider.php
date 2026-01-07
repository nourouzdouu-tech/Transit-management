<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Dossier;
use App\Observers\DossierObserver;

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
  public function boot()
{
    Dossier::observe(DossierObserver::class);
   

}

}


