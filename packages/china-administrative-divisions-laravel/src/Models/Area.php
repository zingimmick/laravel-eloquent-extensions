<?php

declare(strict_types=1);

namespace Zing\ChinaAdministrativeDivisions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Zing\ChinaAdministrativeDivisions\Concerns\BelongsToCity;
use Zing\ChinaAdministrativeDivisions\Concerns\BelongsToProvince;

/**
 * @property int $id
 * @property string $code 编码
 * @property string $name 名称
 * @property string $city_code 地级编码
 * @property string $province_code 省级编码
 * @property-read \Zing\ChinaAdministrativeDivisions\Models\City $city
 * @property-read \Zing\ChinaAdministrativeDivisions\Models\Province $province
 * @property-read \Illuminate\Database\Eloquent\Collection|\Zing\ChinaAdministrativeDivisions\Models\Street[] $streets
 * @property-read int|null $streets_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Zing\ChinaAdministrativeDivisions\Models\Village[] $villages
 * @property-read int|null $villages_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Area newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Area newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Area query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Area whereCityCode($code)
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Area whereCityCodeNot($code)
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Area whereProvinceCode($code)
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Area whereProvinceCodeNot($code)
 */
class Area extends Model
{
    use BelongsToCity;
    use BelongsToProvince;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = ['code', 'name', 'province_code', 'city_code'];

    public function getTable()
    {
        return config('china-administrative-divisions.table_names.areas', parent::getTable());
    }

    public function streets(): HasMany
    {
        return $this->hasMany(Street::class, 'area_code', 'code');
    }

    public function villages(): HasMany
    {
        return $this->hasMany(Village::class, 'area_code', 'code');
    }
}
