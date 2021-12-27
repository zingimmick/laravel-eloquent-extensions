<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvincesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            config('china-administrative-divisions.table_names.provinces'),
            function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->string('code')
                    ->unique()
                    ->comment('编码');
                $table->string('name')
                    ->default('')
                    ->comment('名称');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provinces');
    }
}
