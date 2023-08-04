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
     * @phpstan-param static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query
     */
    public function scopeWhereCityCode(
        mixed $query,
        mixed $code
    ): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|static {
        if (\is_array($code)) {
            return $query->whereIn($this->getQualifiedCityCodeName(), $code);
        }

        if ($code instanceof Arrayable) {
            return $query->whereIn($this->getQualifiedCityCodeName(), $code);
        }

        return $query->where($this->getQualifiedCityCodeName(), '=', $code);
    }

    /**
     * @phpstan-param static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query
     */
    public function scopeWhereCityCodeNot(
        mixed $query,
        mixed $code
    ): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|static {
        if (\is_array($code)) {
            return $query->whereNotIn($this->getQualifiedCityCodeName(), $code);
        }

        if ($code instanceof Arrayable) {
            return $query->whereNotIn($this->getQualifiedCityCodeName(), $code);
        }

        return $query->where($this->getQualifiedCityCodeName(), '!=', $code);
    }
}
