<?php

namespace RicardoVanDerSpoel\LaravelSmartMigrations\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;
use RicardoVanDerSpoel\LaravelSmartMigrations\Services\OpenAIService;
use RicardoVanDerSpoel\LaravelSmartMigrations\Services\SmartMigrationService;
use RicardoVanDerSpoel\LaravelSmartMigrations\Commands\RunSmartMigrations;

class SmartMigrationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SmartMigrationService::class, fn($app) => new SmartMigrationService(
            $app->make(Filesystem::class), $app->make(OpenAIService::class)
        ));

        $this->app->singleton(OpenAIService::class, fn() => new OpenAIService());
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/smartmigrations.php' => config_path('smartmigrations.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__.'/../config/smartmigrations.php', 'smartmigrations'
        );

        if ($this->app->runningInConsole()) {
            $this->commands([
                RunSmartMigrations::class,
            ]);
        }
    }
}
