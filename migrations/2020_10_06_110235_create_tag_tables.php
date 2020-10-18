<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(
            config('eloquent-tags.table_names.tags'),
            function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->string('name');
                $table->timestamps();
            }
        );

        Schema::create(
            config('eloquent-tags.table_names.model_has_tags'),
            function (Blueprint $table): void {
                $table->unsignedBigInteger('tag_id');
                $table->morphs('taggable');

                $table->primary(['tag_id', config('eloquent-tags.column_names.taggable_morph_key'), 'taggable_type']);

                $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(config('eloquent-tags.table_names.model_has_tags'));
        Schema::dropIfExists(config('eloquent-tags.table_names.tags'));
    }
}
