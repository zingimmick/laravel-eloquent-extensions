<?php

declare(strict_types=1);

namespace Zing\LaravelEloquentImages\Tests;

/**
 * @internal
 */
final class ServiceProviderTest extends TestCase
{
    public function testConfig(): void
    {
        $this->assertIsArray(config('eloquent-images'));
    }
}
