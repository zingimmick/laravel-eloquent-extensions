<?php

declare(strict_types=1);

namespace Zing\LaravelEloquentBlameable\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Zing\LaravelEloquentBlameable\Blameable;

/**
 * @property string $title
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\LaravelEloquentBlameable\Tests\Models\Content newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\LaravelEloquentBlameable\Tests\Models\Content newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Zing\LaravelEloquentBlameable\Tests\Models\Content query()
 */
class Content extends Model
{
    use Blameable;

    protected $fillable = ['title'];
}
