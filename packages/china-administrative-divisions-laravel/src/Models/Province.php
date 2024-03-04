<?php

declare(strict_types=1);

namespace Zing\ChinaAdministrativeDivisions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $code 编码
 * @property string $name 名称
 * @property-read \Illuminate\Database\Eloquent\Collection|\Zing\ChinaAdministrativeDivisions\Models\Area[] $areas
 * @property-read int|null $areas_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Zing\ChinaAdministrativeDivisions\Models\City[] $cities
 * @property-read int|null $cities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Zing\ChinaAdministrativeDivisions\Models\Street[] $streets
 * @property-read int|null $streets_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Zing\ChinaAdministrativeDivisions\Models\Village[] $villages
 * @property-read int|null $villages_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Province newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Province newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\ChinaAdministrativeDivisions\Models\Province query()
 */
class Province extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = ['code', 'name'];

    public function getTable(): string
    {
        return config('china-administrative-divisions.table_names.provinces', parent::getTable());
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class, 'province_code', 'code');
    }

    public function areas(): HasMany
    {
        return $this->hasMany(Area::class, 'province_code', 'code');
    }

    public function streets(): HasMany
    {
        return $this->hasMany(Street::class, 'province_code', 'code');
    }

    public function villages(): HasMany
    {
        return $this->hasMany(Village::class, 'province_code', 'code');
    }
}
