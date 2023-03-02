<?php

declare(strict_types=1);

namespace Zing\LaravelEloquentBlameable\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Zing\LaravelEloquentBlameable\Blameable;

/**
 * @property string $title
 */
class Content extends Model
{
    use Blameable;

    protected $fillable = ['title'];
}
