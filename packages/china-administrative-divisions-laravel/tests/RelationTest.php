<?php

declare(strict_types=1);

namespace Zing\ChinaAdministrativeDivisions\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use Zing\ChinaAdministrativeDivisions\Models\Area;
use Zing\ChinaAdministrativeDivisions\Models\City;
use Zing\ChinaAdministrativeDivisions\Models\Province;
use Zing\ChinaAdministrativeDivisions\Models\Street;
use Zing\ChinaAdministrativeDivisions\Models\Village;

class RelationTest extends TestCase
{
    use WithFaker;

    public function testRelation(): void
    {
        $province = Province::query()->create(
            [
                'code' => $this->faker->numberBetween(),
                'name' => $this->faker->name,
            ]
        );
        collect(range(1, $this->faker->numberBetween(2, 5)))
            ->each(
                function () use ($province): void {
                    $city = City::query()->create(
                        [
                            'code' => $this->faker->numberBetween(),
                            'name' => $this->faker->name,
                            'province_code' => $province->code,
                        ]
                    );
                    collect(range(1, $this->faker->numberBetween(2, 5)))
                        ->each(
                            function () use ($city): void {
                                $area = Area::query()->create(
                                    [
                                        'code' => $this->faker->numberBetween(),
                                        'name' => $this->faker->name,
                                        'province_code' => $city->province_code,
                                        'city_code' => $city->code,
                                    ]
                                );

                                collect(range(1, $this->faker->numberBetween(2, 5)))
                                    ->each(
                                        function () use ($area): void {
                                            $street = Street::query()->create(
                                                [
                                                    'code' => $this->faker->numberBetween(),
                                                    'name' => $this->faker->name,
                                                    'province_code' => $area->province_code,
                                                    'city_code' => $area->city_code,
                                                    'area_code' => $area->code,
                                                ]
                                            );

                                            collect(range(1, $this->faker->numberBetween(2, 5)))
                                                ->each(
                                                    function () use ($street): void {
                                                        Village::query()->create(
                                                            [
                                                                'code' => $this->faker->numberBetween(),
                                                                'name' => $this->faker->name,
                                                                'province_code' => $street->province_code,
                                                                'city_code' => $street->city_code,
                                                                'area_code' => $street->area_code,
                                                                'street_code' => $street->code,
                                                            ]
                                                        );
                                                    }
                                                );
                                        }
                                    );
                            }
                        );
                }
            );
        self::assertTrue($province->cities()->exists());
        self::assertTrue($province->areas()->exists());
        self::assertTrue($province->streets()->exists());
        self::assertTrue($province->villages()->exists());
        self::assertTrue(City::query()->whereProvinceCodeNot($this->faker->randomElements())->exists());
        self::assertTrue(City::query()->whereProvinceCodeNot($this->faker->name)->exists());
        self::assertTrue(City::query()->whereProvinceCode($province->code)->exists());
        self::assertTrue(City::query()->whereProvinceCode([$province->code])->exists());
        $city = City::query()->whereProvinceCode($province->code)->firstOrFail();
        self::assertTrue($city->province->is($province));
        self::assertSame($city->{$city->getProvinceCodeName()}, $city->getProvinceCode());

        self::assertTrue($city->areas()->exists());
        self::assertTrue($city->streets()->exists());
        self::assertTrue($city->villages()->exists());
        self::assertTrue(Area::query()->whereCityCodeNot($this->faker->randomElements())->exists());
        self::assertTrue(Area::query()->whereCityCodeNot($this->faker->name)->exists());
        self::assertTrue(Area::query()->whereCityCode($city->code)->exists());
        self::assertTrue(Area::query()->whereCityCode([$city->code])->exists());
        $area = Area::query()->whereCityCode($city->code)->firstOrFail();
        self::assertTrue($area->city->is($city));
        self::assertSame($area->{$area->getCityCodeName()}, $area->getCityCode());

        self::assertTrue($area->streets()->exists());
        self::assertTrue($area->villages()->exists());
        self::assertTrue(Street::query()->whereAreaCodeNot($this->faker->randomElements())->exists());
        self::assertTrue(Street::query()->whereAreaCodeNot($this->faker->name)->exists());
        self::assertTrue(Street::query()->whereAreaCode($area->code)->exists());
        self::assertTrue(Street::query()->whereAreaCode([$area->code])->exists());
        $street = Street::query()->whereAreaCode($area->code)->firstOrFail();
        self::assertTrue($street->area->is($area));
        self::assertSame($street->{$street->getAreaCodeName()}, $street->getAreaCode());

        self::assertTrue($street->villages()->exists());
        self::assertTrue(Village::query()->whereStreetCodeNot($this->faker->randomElements())->exists());
        self::assertTrue(Village::query()->whereStreetCodeNot($this->faker->name)->exists());
        self::assertTrue(Village::query()->whereStreetCode($street->code)->exists());
        self::assertTrue(Village::query()->whereStreetCode([$street->code])->exists());
        $village = Village::query()->whereStreetCode($street->code)->firstOrFail();
        self::assertTrue($village->street->is($street));
        self::assertSame($village->{$village->getStreetCodeName()}, $village->getStreetCode());
    }
}
