<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterPowerModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_power_models', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('young_name')->comment('名称');//名称
            $table->string('young_note')->nullable()->comment('备注');//备注
            $table->integer('young_sort')->default(0)->comment('排序');//排序
            $table->text('young_content')->nullable()->comment('包含权限');//包含权限
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
        Schema::dropIfExists('master_power_models');
    }
}
