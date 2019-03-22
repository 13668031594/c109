<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRewardFreezeModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reward_freeze_models', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->comment('会员id');
            $table->string('young_order')->comment('来源订单号');
            $table->decimal('young_freeze', 18, 2)->comment('冻结金额');
            $table->char('young_status', 2)->default(10)->comment('状态 10未解冻，20已解冻');
            $table->timestamp('young_thaw')->nullable()->comment('解冻时间');
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
        Schema::dropIfExists('reward_freeze_models');
    }
}
