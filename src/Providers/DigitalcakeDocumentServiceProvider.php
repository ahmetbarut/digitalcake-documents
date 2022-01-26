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

        $this->loadViewsFrom(__DIR__ . '/../Views', 'documents');

        if (!is_dir(app_path('Extensions'))) {
            mkdir(app_path('Extensions/Documents'));
        }

        if (is_dir(app_path('Extensions/Documents'))) {
            $this->publishes([
                __DIR__ . '/../../routes.web.php' => app_path('Extensions/Documents/routes.web.php'),
            ], 'documents-route-web');

            $this->publishes([
                __DIR__ . '/../../Lang' => app_path('Extensions/Documents/Lang'),
            ], 'documents');
        } else {
            $this->loadRoutesFrom(__DIR__ . '/../../routes.web.php');
            $this->loadTranslationsFrom(__DIR__ . '/../../Lang', 'documents');
        }
    }
}
