<?php

declare(strict_types=1);

namespace Zing\LaravelEloquentBlameable\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Zing\LaravelEloquentBlameable\Blameable;

/**
 * @property string $title
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\LaravelEloquentBlameable\Tests\Models\CustomContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\LaravelEloquentBlameable\Tests\Models\CustomContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\LaravelEloquentBlameable\Tests\Models\CustomContent query()
 */
class CustomContent extends Model
{
    use Blameable;

    protected $fillable = ['title'];

    public function getCreatorKeyName(): string
    {
        return 'created_by';
    }

    public function getUpdaterKeyName(): string
    {
        return 'updated_by';
    }
}
