<?php

declare(strict_types=1);

namespace Zing\ChinaAdministrativeDivisions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Zing\ChinaAdministrativeDivisions\Concerns\BelongsToArea;
use Zing\ChinaAdministrativeDivisions\Concerns\BelongsToCity;
use Zing\ChinaAdministrativeDivisions\Concerns\BelongsToProvince;

/**
 * @property int $id
 * @property string $code 编码
 * @property string $name 名称
 * @property string $area_code 县级编码
 * @property string $city_code 地级编码
 * @property string $province_code 省级编码
 * @property-read \Zing\ChinaAdministrativeDivisions\Models\Area $area
 * @property-read \Zing\ChinaAdministrativeDivisions\Models\City $city
 * @property-read \Zing\ChinaAdministrativeDivisions\Models\Province $province
 * @property-read \Illuminate\Database\Eloquent\Collection|\Zing\ChinaAdministrativeDivisions\Models\Village[] $villages
 * @property-read int|null $villages_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Street newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Street newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Street query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Street whereAreaCode($code)
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Street whereAreaCodeNot($code)
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Street whereCityCode($code)
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Street whereCityCodeNot($code)
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Street whereProvinceCode($code)
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Street whereProvinceCodeNot($code)
 */
class Street extends Model
{
    use BelongsToArea;
    use BelongsToCity;
    use BelongsToProvince;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = ['code', 'name', 'province_code', 'city_code', 'area_code'];

    public function getTable(): string
    {
        return config('china-administrative-divisions.table_names.streets', parent::getTable());
    }

    public function villages(): HasMany
    {
        return $this->hasMany(Village::class, 'street_code', 'code');
    }
}
