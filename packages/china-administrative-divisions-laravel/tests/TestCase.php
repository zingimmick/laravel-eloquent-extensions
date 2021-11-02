<?php

declare(strict_types=1);

namespace Zing\ChinaAdministrativeDivisions\Tests;

use Zing\ChinaAdministrativeDivisions\ChinaAdministrativeDivisionsServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
    }

    protected function getEnvironmentSetUp($app): void
    {
        config([
            'database.default' => 'testing',
        ]);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array<class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected function getPackageProviders($app)
    {
        return [ChinaAdministrativeDivisionsServiceProvider::class];
    }
}
