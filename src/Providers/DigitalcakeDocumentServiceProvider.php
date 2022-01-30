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
        $this->publishes([
            __DIR__ . '/../../config/documents.php' => config_path('documents.php'),
        ], 'documents');

        $this->publishes([
            __DIR__ . '/../../migrations/' => database_path('migrations'),

        ], 'documents');

        $this->loadViewsFrom(__DIR__ . '/../Views', 'documents');

        if (is_dir(app_path('Extensions')) && !is_dir(app_path('Extensions/Documents'))) {
            mkdir(app_path('Extensions/Documents'));
        } else {
            $this->loadRoutesFrom(__DIR__ . '/../../routes.web.php');
            $this->loadTranslationsFrom(__DIR__ . '/../../Lang', 'documents');
        }

        $this->publishes([
            __DIR__ . '/../../routes.web.php' => app_path('Extensions/Documents/routes.web.php'),
            __DIR__ . '/../../navigation.php', app_path('Extensions/Documents/navigation.php'),
            __DIR__ . '/../../Lang' => app_path('Extensions/Documents/Lang'),
        ], 'documents');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
