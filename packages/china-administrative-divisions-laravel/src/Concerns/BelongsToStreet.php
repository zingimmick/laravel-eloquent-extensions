<?php

declare(strict_types=1);

namespace Zing\ChinaAdministrativeDivisions\Concerns;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Zing\ChinaAdministrativeDivisions\Models\Street;

/**
 * @property-read \Zing\ChinaAdministrativeDivisions\Models\Street|null $auction
 *
 * @method static static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder whereStreetCode($id)
 * @method static static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder whereStreetCodeNot($id)
 */
trait BelongsToStreet
{
    public function street(): BelongsTo
    {
        return $this->belongsTo(Street::class, $this->getStreetCodeName(), 'code');
    }

    public function getStreetCodeName(): string
    {
        return 'street_code';
    }

    public function getStreetCode(): ?string
    {
        return $this->getAttribute($this->getStreetCodeName());
    }

    public function getQualifiedStreetCodeName(): string
    {
        return $this->qualifyColumn($this->getStreetCodeName());
    }

    /**
     * @phpstan-param static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query
     */
    public function scopeWhereStreetCode(
        mixed $query,
        mixed $code
    ): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|static {
        if (\is_array($code)) {
            return $query->whereIn($this->getQualifiedStreetCodeName(), $code);
        }

        if ($code instanceof Arrayable) {
            return $query->whereIn($this->getQualifiedStreetCodeName(), $code);
        }

        return $query->where($this->getQualifiedStreetCodeName(), '=', $code);
    }

    /**
     * @phpstan-param static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query
     */
    public function scopeWhereStreetCodeNot(
        mixed $query,
        mixed $code
    ): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|static {
        if (\is_array($code)) {
            return $query->whereNotIn($this->getQualifiedStreetCodeName(), $code);
        }

        if ($code instanceof Arrayable) {
            return $query->whereNotIn($this->getQualifiedStreetCodeName(), $code);
        }

        return $query->where($this->getQualifiedStreetCodeName(), '!=', $code);
    }
}
