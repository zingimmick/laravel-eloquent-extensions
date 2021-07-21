<?php

declare(strict_types=1);

namespace Zing\ChinaAdministrativeDivisions\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Zing\ChinaAdministrativeDivisions\Models\Province;

class InitCommand extends Command
{
    protected $name = 'china-administrative-divisions:init';

    protected $description = 'init administrative divisions of china';

    public function handle(): void
    {
        $path = 'pca-code.json';
        if (! Storage::exists($path)) {
            $content = file_get_contents(__DIR__ . '/../../pca-code.json');
            if ($content !== false) {
                Storage::put($path, $content);
            }
        }

        collect(json_decode(Storage::get($path), true))->each(
            function ($item): void {
                $province = Province::query()->updateOrCreate(
                    [
                        'code' => $item['code'],
                    ],
                    [
                        'name' => $item['name'],
                    ]
                );
                collect($item['children'])->each(
                    function ($item) use ($province): void {
                        $city = $province->cities()
                            ->updateOrCreate([
                                'code' => $item['code'],
                            ], [
                                'name' => $item['name'],
                            ]);

                        collect($item['children'])->each(
                            function ($item) use ($city): void {
                                $city->areas()
                                    ->updateOrCreate(
                                        [
                                            'code' => $item['code'],
                                        ],
                                        [
                                            'name' => $item['name'],
                                            'province_code' => $city->province_code,
                                        ]
                                    );
                            }
                        );
                    }
                );
            }
        );
    }
}
