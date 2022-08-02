<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            config('china-administrative-divisions.table_names.areas'),
            static function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->string('code')
                    ->unique()
                    ->comment('编码');
                $table->string('name')
                    ->default('')
                    ->comment('名称');
                $table->string('city_code')
                    ->index()
                    ->comment('地级编码');
                $table->string('province_code')
                    ->index()
                    ->comment('省级编码');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areas');
    }
}
