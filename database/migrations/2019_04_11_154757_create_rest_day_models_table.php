<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestDayModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rest_day_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('young_name')->comment('休息原因');
            $table->timestamp('young_begin')->nullable()->comment('休息开始时间');
            $table->timestamp('young_end')->nullable()->comment('休息结束时间');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rest_day_models');
    }
}
