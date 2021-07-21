<?php

declare(strict_types=1);

namespace Zing\ChinaAdministrativeDivisions\Tests;

use Zing\ChinaAdministrativeDivisions\Console\InitCommand;
use Zing\ChinaAdministrativeDivisions\Models\Area;
use Zing\ChinaAdministrativeDivisions\Models\City;
use Zing\ChinaAdministrativeDivisions\Models\Province;

class InitCommandTest extends TestCase
{
    public function testHandle(): void
    {
        $this->artisan(InitCommand::class);
        self::assertTrue(Province::query()->exists());
        self::assertTrue(City::query()->exists());
        self::assertTrue(Area::query()->exists());
    }
}
