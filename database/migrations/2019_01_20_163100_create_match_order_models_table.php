<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchOrderModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match_order_models', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            //基础
            $table->char('young_status', 2)->default('10')->comment('状态');
            $table->decimal('young_total', 18, 2)->comment('金额');
            $table->char('young_abn', 2)->default('10')->comment('异常');

            //买家信息
            $table->integer('young_buy_id')->comment('购买订单id');
            $table->string('young_buy_order')->comment('购买订单的订单号');
            $table->integer('young_buy_uid')->comment('购买人id');
            $table->string('young_buy_nickname')->comment('购买人昵称');

            //卖家信息
            $table->integer('young_sell_id')->comment('出售订单id');
            $table->string('young_sell_order')->comment('出售订单的订单号');
            $table->integer('young_sell_uid')->comment('出售人id');
            $table->string('young_sell_nickname')->comment('出售人昵称');

            //银行相关
            $table->integer('young_bank_id')->nullable()->comment('银行id');
            $table->string('young_bank_name')->nullable()->comment('银行名称');
            $table->string('young_bank_address')->nullable()->comment('支行');
            $table->string('young_bank_no')->nullable()->comment('银行卡号');
            $table->string('young_bank_man')->nullable()->comment('收款人姓名');
            $table->string('young_alipay')->nullable()->comment('支付宝');
            $table->string('young_note')->nullable()->comment('备注');

            //付款信息
            $table->string('young_pay')->nullable()->comment('付款凭证');

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
        Schema::dropIfExists('match_order_models');
    }
}
