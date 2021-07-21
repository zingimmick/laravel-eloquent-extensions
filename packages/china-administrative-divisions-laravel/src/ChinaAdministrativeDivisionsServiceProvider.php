<?php

declare(strict_types=1);

namespace Zing\ChinaAdministrativeDivisions;

use Illuminate\Support\ServiceProvider;
use Zing\ChinaAdministrativeDivisions\Console\InitCommand;

class ChinaAdministrativeDivisionsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [
                    $this->getConfigPath() => config_path('china-administrative-divisions.php'),
                ],
                'china-administrative-divisions-config'
            );
            $this->publishes(
                [
                    $this->getMigrationsPath() => database_path('migrations'),
                ],
                'china-administrative-divisions-migrations'
            );
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom($this->getConfigPath(), 'china-administrative-divisions');
        if ($this->app->runningInConsole()) {
            if ($this->shouldLoadMigrations()) {
                $this->loadMigrationsFrom($this->getMigrationsPath());
            }

            $this->commands([InitCommand::class]);
        }
    }

    protected function getMigrationsPath(): string
    {
        return __DIR__ . '/../migrations';
    }

    private function shouldLoadMigrations(): bool
    {
        return (bool) config('china-administrative-divisions.load_migrations');
    }

    protected function getConfigPath(): string
    {
        return __DIR__ . '/../config/china-administrative-divisions.php';
    }
}
