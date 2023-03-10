<?php

declare(strict_types=1);

namespace Zing\LaravelEloquentBlameable\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Zing\LaravelEloquentBlameable\Tests\Models\Content;
use Zing\LaravelEloquentBlameable\Tests\Models\ContentWithCreator;
use Zing\LaravelEloquentBlameable\Tests\Models\ContentWithUpdater;
use Zing\LaravelEloquentBlameable\Tests\Models\CustomContent;
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
        $this->assertDatabaseHas('contents', [
            $content->getKeyName() => $content->getKey(),
            $content->getCreatorKeyName() => $creator->getKey(),
            $content->getUpdaterKeyName() => $creator->getKey(),
        ]);
        $updater = User::query()->create();
        Auth::setUser($updater);
        $content->title = $this->faker->sentence();
        $content->save();
        $this->assertDatabaseHas('contents', [
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
        $this->assertDatabaseHas('contents', [
            $content->getKeyName() => $content->getKey(),
            $content->getCreatorKeyName() => $creator->getKey(),
        ]);
        $updater = User::query()->create();
        Auth::setUser($updater);
        $content->title = $this->faker->sentence();
        $content->save();
        $this->assertDatabaseHas('contents', [
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
        $this->assertDatabaseHas('contents', [
            $content->getKeyName() => $content->getKey(),
            $content->getUpdaterKeyName() => $creator->getKey(),
        ]);
        $updater = User::query()->create();
        Auth::setUser($updater);
        $content->title = $this->faker->sentence();
        $content->save();
        $this->assertDatabaseHas('contents', [
            $content->getKeyName() => $content->getKey(),
            $content->getUpdaterKeyName() => $updater->getKey(),
        ]);
    }

    public function testContentScope(): void
    {
        $creator = User::query()->create();
        Auth::setUser($creator);

        /** @var \Zing\LaravelEloquentBlameable\Tests\Models\Content $content */
        $content = Content::query()->create([
            'title' => $this->faker->sentence(),
        ]);
        self::assertSame($content->getCreatorKey(), $creator->getKey());
        self::assertSame(1, Content::query()->whereCreatorKey($creator->getKey())->count());
        self::assertSame(0, Content::query()->whereCreatorKeyNot($creator->getKey())->count());
        self::assertSame(1, Content::query()->whereCreatorKey([$creator->getKey()])->count());
        self::assertSame(0, Content::query()->whereCreatorKeyNot([$creator->getKey()])->count());
        $updater = User::query()->create();
        Auth::setUser($updater);
        $content->title = $this->faker->sentence();
        $content->save();
        self::assertSame($content->getUpdaterKey(), $updater->getKey());
        self::assertSame(1, Content::query()->whereUpdaterKey($updater->getKey())->count());
        self::assertSame(0, Content::query()->whereUpdaterKeyNot($updater->getKey())->count());
        self::assertSame(1, Content::query()->whereUpdaterKey([$updater->getKey()])->count());
        self::assertSame(0, Content::query()->whereUpdaterKeyNot([$updater->getKey()])->count());
    }

    public function testCustomContentWithCreatorAndUpdater(): void
    {
        $creator = User::query()->create();
        Auth::setUser($creator);

        /** @var \Zing\LaravelEloquentBlameable\Tests\Models\CustomContent $content */
        $content = CustomContent::query()->create([
            'title' => $this->faker->sentence(),
        ]);
        $this->assertDatabaseHas('custom_contents', [
            $content->getKeyName() => $content->getKey(),
            $content->getCreatorKeyName() => $creator->getKey(),
            $content->getUpdaterKeyName() => $creator->getKey(),
        ]);
        self::assertSame($content->getCreatorKey(), $creator->getKey());
        self::assertSame(1, CustomContent::query()->whereCreatorKey($creator->getKey())->count());
        self::assertSame(0, CustomContent::query()->whereCreatorKeyNot($creator->getKey())->count());
        self::assertSame(1, CustomContent::query()->whereCreatorKey([$creator->getKey()])->count());
        self::assertSame(0, CustomContent::query()->whereCreatorKeyNot([$creator->getKey()])->count());
        $updater = User::query()->create();
        Auth::setUser($updater);
        $content->title = $this->faker->sentence();
        $content->save();
        $this->assertDatabaseHas('custom_contents', [
            $content->getKeyName() => $content->getKey(),
            $content->getCreatorKeyName() => $creator->getKey(),
            $content->getUpdaterKeyName() => $updater->getKey(),
        ]);
        self::assertSame($content->getUpdaterKey(), $updater->getKey());
        self::assertSame(1, CustomContent::query()->whereUpdaterKey($updater->getKey())->count());
        self::assertSame(0, CustomContent::query()->whereUpdaterKeyNot($updater->getKey())->count());
        self::assertSame(1, CustomContent::query()->whereUpdaterKey([$updater->getKey()])->count());
        self::assertSame(0, CustomContent::query()->whereUpdaterKeyNot([$updater->getKey()])->count());
    }
}
