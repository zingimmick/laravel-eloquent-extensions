<?php

declare(strict_types=1);

namespace Zing\ChinaAdministrativeDivisions\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use Zing\ChinaAdministrativeDivisions\Models\Area;
use Zing\ChinaAdministrativeDivisions\Models\City;
use Zing\ChinaAdministrativeDivisions\Models\Province;
use Zing\ChinaAdministrativeDivisions\Models\Street;
use Zing\ChinaAdministrativeDivisions\Models\Village;

/**
 * @internal
 */
final class RelationTest extends TestCase
{
    use WithFaker;

    public function testRelation(): void
    {
        $province = Province::query()->create(
            [
                'code' => $this->faker->numberBetween(),
                'name' => $this->faker->name(),
            ]
        );
        collect(range(1, $this->faker->numberBetween(2, 5)))
            ->each(
                function () use ($province): void {
                    $city = City::query()->create(
                        [
                            'code' => $this->faker->numberBetween(),
                            'name' => $this->faker->name(),
                            'province_code' => $province->code,
                        ]
                    );
                    collect(range(1, $this->faker->numberBetween(2, 5)))
                        ->each(
                            function () use ($city): void {
                                $area = Area::query()->create(
                                    [
                                        'code' => $this->faker->numberBetween(),
                                        'name' => $this->faker->name(),
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
                                                    'name' => $this->faker->name(),
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
                                                                'name' => $this->faker->name(),
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
        $this->assertTrue($province->cities()->exists());
        $this->assertTrue($province->areas()->exists());
        $this->assertTrue($province->streets()->exists());
        $this->assertTrue($province->villages()->exists());
        $this->assertTrue(City::query()->whereProvinceCodeNot($this->faker->randomElements())->exists());
        $this->assertTrue(City::query()->whereProvinceCodeNot(collect($this->faker->randomElements()))->exists());
        $this->assertTrue(City::query()->whereProvinceCodeNot($this->faker->name())->exists());
        $this->assertTrue(City::query()->whereProvinceCode($province->code)->exists());
        $this->assertTrue(City::query()->whereProvinceCode([$province->code])->exists());
        $this->assertTrue(City::query()->whereProvinceCode(collect([$province->code]))->exists());
        $city = City::query()->whereProvinceCode($province->code)->firstOrFail();
        $this->assertTrue($city->province->is($province));
        $this->assertSame($city->{$city->getProvinceCodeName()}, $city->getProvinceCode());

        $this->assertTrue($city->areas()->exists());
        $this->assertTrue($city->streets()->exists());
        $this->assertTrue($city->villages()->exists());
        $this->assertTrue(Area::query()->whereCityCodeNot($this->faker->randomElements())->exists());
        $this->assertTrue(Area::query()->whereCityCodeNot(collect($this->faker->randomElements()))->exists());
        $this->assertTrue(Area::query()->whereCityCodeNot($this->faker->name())->exists());
        $this->assertTrue(Area::query()->whereCityCode($city->code)->exists());
        $this->assertTrue(Area::query()->whereCityCode([$city->code])->exists());
        $this->assertTrue(Area::query()->whereCityCode(collect([$city->code]))->exists());
        $area = Area::query()->whereCityCode($city->code)->firstOrFail();
        $this->assertTrue($area->city->is($city));
        $this->assertSame($area->{$area->getCityCodeName()}, $area->getCityCode());

        $this->assertTrue($area->streets()->exists());
        $this->assertTrue($area->villages()->exists());
        $this->assertTrue(Street::query()->whereAreaCodeNot($this->faker->randomElements())->exists());
        $this->assertTrue(Street::query()->whereAreaCodeNot(collect($this->faker->randomElements()))->exists());
        $this->assertTrue(Street::query()->whereAreaCodeNot($this->faker->name())->exists());
        $this->assertTrue(Street::query()->whereAreaCode($area->code)->exists());
        $this->assertTrue(Street::query()->whereAreaCode([$area->code])->exists());
        $this->assertTrue(Street::query()->whereAreaCode(collect([$area->code]))->exists());
        $street = Street::query()->whereAreaCode($area->code)->firstOrFail();
        $this->assertTrue($street->area->is($area));
        $this->assertSame($street->{$street->getAreaCodeName()}, $street->getAreaCode());

        $this->assertTrue($street->villages()->exists());
        $this->assertTrue(Village::query()->whereStreetCodeNot($this->faker->randomElements())->exists());
        $this->assertTrue(Village::query()->whereStreetCodeNot(collect($this->faker->randomElements()))->exists());
        $this->assertTrue(Village::query()->whereStreetCodeNot($this->faker->name())->exists());
        $this->assertTrue(Village::query()->whereStreetCode($street->code)->exists());
        $this->assertTrue(Village::query()->whereStreetCode([$street->code])->exists());
        $this->assertTrue(Village::query()->whereStreetCode(collect([$street->code]))->exists());
        $village = Village::query()->whereStreetCode($street->code)->firstOrFail();
        $this->assertTrue($village->street->is($street));
        $this->assertSame($village->{$village->getStreetCodeName()}, $village->getStreetCode());
    }
}
