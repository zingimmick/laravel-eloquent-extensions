<?php

declare(strict_types=1);

namespace Zing\ChinaAdministrativeDivisions\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Zing\ChinaAdministrativeDivisions\Models\Province;

/**
 * @phpstan-type AreaArray array{code: string, name: string, children: null}
 * @phpstan-type CityArray array{code: string, name: string, children: iterable<int, \Zing\ChinaAdministrativeDivisions\Console\AreaArray>}
 * @phpstan-type ProvinceArray array{code: string, name: string, children: iterable<int, \Zing\ChinaAdministrativeDivisions\Console\CityArray>}
 */
class InitCommand extends Command
{
    /**
     * @var string
     */
    private const PATH = 'pca-code.json';

    /**
     * @var string
     */
    protected $name = 'china-administrative-divisions:init';

    /**
     * @var string
     */
    protected $description = 'init administrative divisions of china';

    public function handle(): void
    {
        if (! Storage::exists(self::PATH)) {
            $content = file_get_contents(__DIR__ . '/../../pca-code.json');
            if ($content !== false) {
                Storage::put(self::PATH, $content);
            }
        }

        $contents = Storage::get(self::PATH);
        if ($contents === null) {
            return;
        }

        /** @var iterable<int, \Zing\ChinaAdministrativeDivisions\Console\ProvinceArray> $data */
        $data = json_decode($contents, true);
        collect($data)
            ->each(
                /** @phpstan-param \Zing\ChinaAdministrativeDivisions\Console\ProvinceArray $item */
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
                        /** @phpstan-param \Zing\ChinaAdministrativeDivisions\Console\CityArray $item */
                        function ($item) use ($province): void {
                            $city = $province->cities()
                                ->updateOrCreate([
                                    'code' => $item['code'],
                                ], [
                                    'name' => $item['name'],
                                ]);

                            collect($item['children'])->each(
                                /** @phpstan-param \Zing\ChinaAdministrativeDivisions\Console\AreaArray $item */
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
