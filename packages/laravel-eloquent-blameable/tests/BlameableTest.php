<?php

declare(strict_types=1);

namespace Zing\LaravelEloquentBlameable\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Zing\LaravelEloquentBlameable\Tests\Models\Content;
use Zing\LaravelEloquentBlameable\Tests\Models\ContentWithCreator;
use Zing\LaravelEloquentBlameable\Tests\Models\ContentWithUpdater;
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
            'title' => $this->faker->sentence(),
        ]);
        $this->assertDatabaseHas(Content::class, [
            $content->getKeyName() => $content->getKey(),
            $content->getCreatorKeyName() => $creator->getKey(),
            $content->getUpdaterKeyName() => $creator->getKey(),
        ]);
        $updater = User::query()->create();
        Auth::setUser($updater);
        $content->title = $this->faker->sentence();
        $content->save();
        $this->assertDatabaseHas(Content::class, [
            $content->getKeyName() => $content->getKey(),
            $content->getCreatorKeyName() => $creator->getKey(),
            $content->getUpdaterKeyName() => $updater->getKey(),
        ]);
    }

    public function testContentWithCreator(): void
    {
        $creator = User::query()->create();
        Auth::setUser($creator);

        /** @var \Zing\LaravelEloquentBlameable\Tests\Models\ContentWithCreator $content */
        $content = ContentWithCreator::query()->create([
            'title' => $this->faker->sentence(),
        ]);
        $this->assertDatabaseHas(ContentWithCreator::class, [
            $content->getKeyName() => $content->getKey(),
            $content->getCreatorKeyName() => $creator->getKey(),
        ]);
        $updater = User::query()->create();
        Auth::setUser($updater);
        $content->title = $this->faker->sentence();
        $content->save();
        $this->assertDatabaseHas(ContentWithCreator::class, [
            $content->getKeyName() => $content->getKey(),
            $content->getCreatorKeyName() => $creator->getKey(),
        ]);
    }

    public function testContentWithUpdater(): void
    {
        $creator = User::query()->create();
        Auth::setUser($creator);

        /** @var \Zing\LaravelEloquentBlameable\Tests\Models\ContentWithUpdater $content */
        $content = ContentWithUpdater::query()->create([
            'title' => $this->faker->sentence(),
        ]);
        $this->assertDatabaseHas(ContentWithUpdater::class, [
            $content->getKeyName() => $content->getKey(),
            $content->getUpdaterKeyName() => $creator->getKey(),
        ]);
        $updater = User::query()->create();
        Auth::setUser($updater);
        $content->title = $this->faker->sentence();
        $content->save();
        $this->assertDatabaseHas(ContentWithUpdater::class, [
            $content->getKeyName() => $content->getKey(),
            $content->getUpdaterKeyName() => $updater->getKey(),
        ]);
    }
}
