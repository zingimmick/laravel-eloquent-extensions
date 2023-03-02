<?php

declare(strict_types=1);

namespace Zing\LaravelEloquentBlameable\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Zing\LaravelEloquentBlameable\Tests\Models\Content;
use Zing\LaravelEloquentBlameable\Tests\Models\User;

/**
 * @internal
 */
final class BlameableTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testContentWithCreatorAndUpdater(): void
    {
        $creator = User::query()->create();
        Auth::setUser($creator);

        /** @var \Zing\LaravelEloquentBlameable\Tests\Models\Content $content */
        $content = Content::query()->create([
            'title' => $this->faker->title(),
        ]);
        $this->assertDatabaseHas(Content::class, [
            $content->getKeyName() => $content->getKey(),
            $content->getCreatorKeyName() => $creator->getKey(),
            $content->getUpdaterKeyName() => $creator->getKey(),
        ]);
        $updater = User::query()->create();
        Auth::setUser($updater);
        $content->title = $this->faker->title();
        $content->save();
        $this->assertDatabaseHas(Content::class, [
            $content->getKeyName() => $content->getKey(),
            $content->getCreatorKeyName() => $creator->getKey(),
            $content->getUpdaterKeyName() => $updater->getKey(),
        ]);
    }
}
