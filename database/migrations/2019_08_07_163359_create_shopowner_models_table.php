<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopownerModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopowner_models', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('uid')->comment('会员id');
            $table->decimal('young_reward')->default(0)->comment('奖励百分比');
            $table->decimal('young_reward_all')->default(0)->comment('累计奖励');
            $table->string('young_status')->default(10)->comment('状态，10正常，20停用');
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
        Schema::dropIfExists('shopowner_models');
    }
}
