<?php

declare(strict_types=1);

namespace Zing\ChinaAdministrativeDivisions\Concerns;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Zing\ChinaAdministrativeDivisions\Models\City;

/**
 * @property-read \Zing\ChinaAdministrativeDivisions\Models\City|null $auction
 *
 * @method static static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder whereCityCode($id)
 * @method static static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder whereCityCodeNot($id)
 */
trait BelongsToCity
{
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, $this->getCityCodeName(), 'code');
    }

    public function getCityCodeName(): string
    {
        return 'city_code';
    }

    public function getCityCode(): ?string
    {
        return $this->getAttribute($this->getCityCodeName());
    }

    public function getQualifiedCityCodeName(): string
    {
        return $this->qualifyColumn($this->getCityCodeName());
    }

    /**
     * @param static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query
     * @param mixed $code
     *
     * @return static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeWhereCityCode($query, $code)
    {
        if (\is_array($code)) {
            return $query->whereIn($this->getQualifiedCityCodeName(), $code);
        }

        if ($code instanceof Arrayable) {
            return $query->whereIn($this->getQualifiedCityCodeName(), $code);
        }

        return $query->where($this->getQualifiedCityCodeName(), '=', $code);
    }

    /**
     * @param static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query
     * @param mixed $code
     *
     * @return static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeWhereCityCodeNot($query, $code)
    {
        if (\is_array($code)) {
            return $query->whereNotIn($this->getQualifiedCityCodeName(), $code);
        }

        if ($code instanceof Arrayable) {
            return $query->whereNotIn($this->getQualifiedCityCodeName(), $code);
        }

        return $query->where($this->getQualifiedCityCodeName(), '!=', $code);
    }
}
