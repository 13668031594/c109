<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trad_models', function (Blueprint $table) {
            $table->increments('id');

            //基础
            $table->string('young_order')->comment('订单号');
            $table->char('young_status', 2)->default('10')->comment('状态');
            $table->decimal('young_gxd', 18, 2)->comment('卖出贡献点');
            $table->decimal('young_balance', 18, 2)->comment('收入余额');
            $table->decimal('young_amount', 18, 8)->comment('单价');

            //买家信息
            $table->integer('young_buy_uid')->nullable()->comment('购买人id');
            $table->string('young_buy_nickname')->nullable()->comment('购买人昵称');

            //卖家信息
            $table->integer('young_sell_uid')->comment('出售人id');
            $table->string('young_sell_nickname')->comment('出售人昵称');

            //卖出时间
            $table->timestamp('young_pay_time')->nullable()->comment('交易时间');

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
        Schema::dropIfExists('trad_models');
    }
}
