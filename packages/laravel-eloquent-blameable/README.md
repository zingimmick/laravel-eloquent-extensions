# Laravel Eloquent Blameable

[![Latest Stable Version](https://poser.pugx.org/zing/laravel-eloquent-blameable/v/stable.svg)](https://packagist.org/packages/zing/laravel-eloquent-blameable)
[![Total Downloads](https://poser.pugx.org/zing/laravel-eloquent-blameable/downloads)](https://packagist.org/packages/zing/laravel-eloquent-blameable)
[![Latest Unstable Version](https://poser.pugx.org/zing/laravel-eloquent-blameable/v/unstable.svg)](https://packagist.org/packages/zing/laravel-eloquent-blameable)
[![License](https://poser.pugx.org/zing/laravel-eloquent-blameable/license)](https://packagist.org/packages/zing/laravel-eloquent-blameable)

### Requirements

- [PHP 8.0+](https://php.net/releases/)
- [Composer](https://getcomposer.org)
- [Laravel 8.0+](https://laravel.com/docs/releases)

Require Laravel Eloquent Blameable using [Composer](https://getcomposer.org):

```bash
composer require zing/laravel-eloquent-blameable
```

## Usage

```php
<?php

use Illuminate\Database\Eloquent\Model;
use Zing\LaravelEloquentBlameable\Blameable;

class Content extends Model
{
    use Blameable;
}
```

### Custom creator key name or updater key name

```php
<?php

use Illuminate\Database\Eloquent\Model;
use Zing\LaravelEloquentBlameable\Blameable;

class Content extends Model
{
    use Blameable;

    public function getCreatorKeyName(): string
    {
        return 'created_by';
    }

    public function getUpdaterKeyName(): string
    {
        return 'updated_by';
    }
}
```

### Model without updater

```php
<?php

use Illuminate\Database\Eloquent\Model;
use Zing\LaravelEloquentBlameable\Blameable;

class Content extends Model
{
    use Blameable;

    public function getCreatorKeyName(): string
    {
        return 'created_by';
    }

    public function getUpdaterKeyName(): ?string
    {
        return null;
    }
}
```

## License

Laravel Eloquent Blameable is an open-sourced software licensed under the [MIT license](LICENSE).
