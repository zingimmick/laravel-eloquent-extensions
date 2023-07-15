<?php

declare(strict_types=1);

namespace Zing\LaravelEloquentBlameable\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * @before
     */
    protected function setUpDatabaseMigrations(): void
    {
        $this->afterApplicationCreated(static function (): void {
            Schema::create(
                'users',
                static function (Blueprint $table): void {
                    $table->bigIncrements('id');
                    $table->timestamps();
                }
            );
            Schema::create(
                'contents',
                static function (Blueprint $table): void {
                    $table->bigIncrements('id');
                    $table->string('title')
                        ->default('');
                    $table->unsignedBigInteger('creator_id')
                        ->nullable();
                    $table->unsignedBigInteger('updater_id')
                        ->nullable();
                    $table->timestamps();
                }
            );
            Schema::create(
                'custom_contents',
                static function (Blueprint $table): void {
                    $table->bigIncrements('id');
                    $table->string('title')
                        ->default('');
                    $table->unsignedBigInteger('created_by')
                        ->nullable();
                    $table->unsignedBigInteger('updated_by')
                        ->nullable();
                    $table->timestamps();
                }
            );
        });
    }

    protected function tearDown(): void
    {
        Schema::drop('users');
        Schema::drop('contents');

        parent::tearDown();
    }

    protected function getEnvironmentSetUp($app): void
    {
        config([
            'database.default' => 'testing',
        ]);
    }
}
