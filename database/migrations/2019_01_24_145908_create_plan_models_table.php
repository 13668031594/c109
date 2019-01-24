<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('young_type')->comment('任务类型');
            $table->string('young_status')->comment('执行情况');
            $table->string('young_record')->comment('文字记录');
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
        Schema::dropIfExists('plan_models');
    }
}
