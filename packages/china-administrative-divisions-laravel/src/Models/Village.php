<?php

declare(strict_types=1);

namespace Zing\ChinaAdministrativeDivisions\Models;

use Illuminate\Database\Eloquent\Model;
use Zing\ChinaAdministrativeDivisions\Concerns\BelongsToArea;
use Zing\ChinaAdministrativeDivisions\Concerns\BelongsToCity;
use Zing\ChinaAdministrativeDivisions\Concerns\BelongsToProvince;
use Zing\ChinaAdministrativeDivisions\Concerns\BelongsToStreet;

/**
 * @property int $id
 * @property string $code 编码
 * @property string $name 名称
 * @property string $street_code 乡级编码
 * @property string $area_code 县级编码
 * @property string $city_code 地级编码
 * @property string $province_code 省级编码
 * @property-read \Zing\ChinaAdministrativeDivisions\Models\Area $area
 * @property-read \Zing\ChinaAdministrativeDivisions\Models\City $city
 * @property-read \Zing\ChinaAdministrativeDivisions\Models\Province $province
 * @property-read \Zing\ChinaAdministrativeDivisions\Models\Street $street
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Village newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Village newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Village query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Village whereAreaCode($code)
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Village whereAreaCodeNot($code)
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Village whereCityCode($code)
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Village whereCityCodeNot($code)
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Village whereProvinceCode($code)
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Village whereProvinceCodeNot($code)
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Village whereStreetCode($code)
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Village whereStreetCodeNot($code)
 */
class Village extends Model
{
    use BelongsToProvince;

    use BelongsToCity;

    use BelongsToArea;

    use BelongsToStreet;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = ['code', 'name', 'province_code', 'city_code', 'area_code', 'street_code'];

    public function getTable()
    {
        return config('china-administrative-divisions.table_names.villages', parent::getTable());
    }
}
