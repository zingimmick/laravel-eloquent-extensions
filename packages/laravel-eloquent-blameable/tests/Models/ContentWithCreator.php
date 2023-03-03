<?php

declare(strict_types=1);

namespace Zing\LaravelEloquentBlameable\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Zing\LaravelEloquentBlameable\Blameable;

/**
 * @property string $title
 */
class ContentWithCreator extends Model
{
    use Blameable;

    protected $table = 'contents';

    protected $fillable = ['title'];

    public function getUpdaterKeyName(): ?string
    {
        return null;
    }
}
