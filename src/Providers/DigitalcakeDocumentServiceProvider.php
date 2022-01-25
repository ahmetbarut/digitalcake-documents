<?php

namespace Digitalcake\Documents\Providers;

use Illuminate\Support\ServiceProvider;

class DigitalcakeDocumentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/documents.php' => config_path('documents.php'),
        ], 'documents');
        
        $this->publishes([
            __DIR__ . '/../../migrations/' => database_path('migrations'),
        ], 'documents');
        $this->loadRoutesFrom(__DIR__ . '/../../routes.web.php');
        $this->loadViewsFrom(__DIR__ . '/../Views', 'documents');
    }
}
