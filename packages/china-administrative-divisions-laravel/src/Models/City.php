<?php

declare(strict_types=1);

namespace Zing\ChinaAdministrativeDivisions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Zing\ChinaAdministrativeDivisions\Concerns\BelongsToProvince;

/**
 * @property int $id
 * @property string $code 编码
 * @property string $name 名称
 * @property string $province_code 省级编码
 * @property-read \Illuminate\Database\Eloquent\Collection|\Zing\ChinaAdministrativeDivisions\Models\Area[] $areas
 * @property-read int|null $areas_count
 * @property-read \Zing\ChinaAdministrativeDivisions\Models\Province $province
 * @property-read \Illuminate\Database\Eloquent\Collection|\Zing\ChinaAdministrativeDivisions\Models\Street[] $streets
 * @property-read int|null $streets_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Zing\ChinaAdministrativeDivisions\Models\Village[] $villages
 * @property-read int|null $villages_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\City query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\City whereProvinceCode($code)
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\City whereProvinceCodeNot($code)
 */
class City extends Model
{
    use BelongsToProvince;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = ['code', 'name', 'province_code'];

    public function getTable()
    {
        return config('china-administrative-divisions.table_names.cities', parent::getTable());
    }

    public function areas(): HasMany
    {
        return $this->hasMany(Area::class, 'city_code', 'code');
    }

    public function streets(): HasMany
    {
        return $this->hasMany(Street::class, 'city_code', 'code');
    }

    public function villages(): HasMany
    {
        return $this->hasMany(Village::class, 'city_code', 'code');
    }
}
