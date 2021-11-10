<?php

declare(strict_types=1);

namespace Zing\ChinaAdministrativeDivisions\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Zing\ChinaAdministrativeDivisions\Models\Province;

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

        collect(json_decode(Storage::get(self::PATH), true))->each(
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
