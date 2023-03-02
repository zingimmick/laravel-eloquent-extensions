<?php

declare(strict_types=1);

namespace Zing\LaravelEloquentBlameable;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait Blameable
{
    public static function bootBlameable(): void
    {
        static::creating(static function ($model): void {
            $model->{$model->getCreatorKeyName()} ??= Auth::id();
            $model->{$model->getUpdaterKeyName()} ??= Auth::id();
        });
        static::updating(static function ($model): void {
            $model->{$model->getUpdaterKeyName()} = Auth::id();
        });
    }

    public function getCreatorKeyName(): string
    {
        return 'creator_id';
    }

    /**
     * @return mixed
     */
    public function getCreatorKey()
    {
        return $this->getAttribute($this->getCreatorKeyName());
    }

    public function getQualifiedCreatorKeyName(): string
    {
        return $this->qualifyColumn($this->getCreatorKeyName());
    }

    public function scopeWhereCreatorKey(Builder $query, mixed $id): Builder
    {
        if (\is_array($id) || $id instanceof Arrayable) {
            return $query->whereIn($this->getQualifiedCreatorKeyName(), $id);
        }

        return $query->where($this->getQualifiedCreatorKeyName(), '=', $id);
    }

    public function scopeWhereCreatorKeyNot(Builder $query, mixed $id): Builder
    {
        if (\is_array($id) || $id instanceof Arrayable) {
            return $query->whereNotIn($this->getQualifiedCreatorKeyName(), $id);
        }

        return $query->where($this->getQualifiedCreatorKeyName(), '!=', $id);
    }

    public function getUpdaterKeyName(): string
    {
        return 'updater_id';
    }

    /**
     * @return mixed
     */
    public function getUpdaterKey()
    {
        return $this->getAttribute($this->getUpdaterKeyName());
    }

    public function getQualifiedUpdaterKeyName(): string
    {
        return $this->qualifyColumn($this->getUpdaterKeyName());
    }

    public function scopeWhereUpdaterKey(Builder $query, mixed $id): Builder
    {
        if (\is_array($id) || $id instanceof Arrayable) {
            return $query->whereIn($this->getQualifiedUpdaterKeyName(), $id);
        }

        return $query->where($this->getQualifiedUpdaterKeyName(), '=', $id);
    }

    public function scopeWhereUpdaterKeyNot(Builder $query, mixed $id): Builder
    {
        if (\is_array($id) || $id instanceof Arrayable) {
            return $query->whereNotIn($this->getQualifiedUpdaterKeyName(), $id);
        }

        return $query->where($this->getQualifiedUpdaterKeyName(), '!=', $id);
    }
}
