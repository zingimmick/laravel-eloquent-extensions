<?php

declare(strict_types=1);

namespace Zing\ChinaAdministrativeDivisions\Concerns;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Zing\ChinaAdministrativeDivisions\Models\Province;

/**
 * @property-read \Zing\ChinaAdministrativeDivisions\Models\Province|null $auction
 *
 * @method static static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder whereProvinceCode($id)
 * @method static static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder whereProvinceCodeNot($id)
 */
trait BelongsToProvince
{
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, $this->getProvinceCodeName(), 'code');
    }

    public function getProvinceCodeName(): string
    {
        return 'province_code';
    }

    public function getProvinceCode(): ?string
    {
        return $this->getAttribute($this->getProvinceCodeName());
    }

    public function getQualifiedProvinceCodeName(): string
    {
        return $this->qualifyColumn($this->getProvinceCodeName());
    }

    /**
     * @phpstan-param static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query
     */
    public function scopeWhereProvinceCode(
        mixed $query,
        mixed $code
    ): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|static {
        if (\is_array($code)) {
            return $query->whereIn($this->getQualifiedProvinceCodeName(), $code);
        }

        if ($code instanceof Arrayable) {
            return $query->whereIn($this->getQualifiedProvinceCodeName(), $code);
        }

        return $query->where($this->getQualifiedProvinceCodeName(), '=', $code);
    }

    /**
     * @phpstan-param static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query
     */
    public function scopeWhereProvinceCodeNot(
        mixed $query,
        mixed $code
    ): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|static {
        if (\is_array($code)) {
            return $query->whereNotIn($this->getQualifiedProvinceCodeName(), $code);
        }

        if ($code instanceof Arrayable) {
            return $query->whereNotIn($this->getQualifiedProvinceCodeName(), $code);
        }

        return $query->where($this->getQualifiedProvinceCodeName(), '!=', $code);
    }
}
