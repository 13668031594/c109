<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRobModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rob_models', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->comment('需要激活的会员id');
            $table->char('young_status', 2)->default('10')->comment('状态');
            $table->string('young_order')->nullable()->comment('下单的订单号');
            $table->string('young_order_id')->nullable()->comment('下单的id');
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
        Schema::dropIfExists('rob_models');
    }
}
