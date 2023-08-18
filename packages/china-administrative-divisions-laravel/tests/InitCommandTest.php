<?php

declare(strict_types=1);

namespace Zing\ChinaAdministrativeDivisions\Tests;

use Illuminate\Support\Facades\Storage;
use Zing\ChinaAdministrativeDivisions\Console\InitCommand;
use Zing\ChinaAdministrativeDivisions\Models\Area;
use Zing\ChinaAdministrativeDivisions\Models\City;
use Zing\ChinaAdministrativeDivisions\Models\Province;

/**
 * @internal
 */
final class InitCommandTest extends TestCase
{
    public function testHandle(): void
    {
        Storage::delete('pca-code.json');
        $this->artisan(InitCommand::class);
        $this->assertTrue(Province::query()->exists());
        $this->assertTrue(City::query()->exists());
        $this->assertTrue(Area::query()->exists());
    }
}
