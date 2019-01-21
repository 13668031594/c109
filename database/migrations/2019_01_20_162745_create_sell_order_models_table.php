<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellOrderModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_order_models', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('young_order')->comment('订单号');
            $table->integer('uid')->comment('卖家id');
            $table->char('young_status', 2)->default('10')->comment('状态');

            $table->decimal('young_total', 18, 2)->comment('总金额');
            $table->decimal('young_remind')->comment('剩余金额');

            //银行信息
            $table->integer('young_bank_id')->nullable()->comment('银行id');
            $table->string('young_bank_name')->nullable()->comment('银行名称');
            $table->string('young_bank_address')->nullable()->comment('支行');
            $table->string('young_bank_no')->nullable()->comment('银行卡号');
            $table->string('young_bank_man')->nullable()->comment('收款人姓名');
            $table->string('young_alipay')->nullable()->comment('支付宝');
            $table->string('young_note')->nullable()->comment('备注');

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
        Schema::dropIfExists('sell_order_models');
    }
}
