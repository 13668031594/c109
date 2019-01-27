<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyOrderModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_order_models', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('young_order')->comment('订单号');
            $table->integer('uid')->comment('买家id');
            $table->char('young_status', 2)->default('10')->comment('状态');

            //收益相关
            $table->decimal('young_total', 18, 2)->comment('总金额');
            $table->integer('young_days')->comment('收益时间');
            $table->decimal('young_in_pro', 4, 2)->comment('利率');
            $table->decimal('young_in', 18, 2)->comment('实际收益');
            $table->timestamp('young_in_over')->nullable()->comment('收益完结时间');

            //商品信息
            $table->decimal('young_amount', 18, 2)->comment('商品单价');
            $table->integer('young_number')->comment('商品数量');
            $table->string('young_name')->comment('商品名称');

            //首付款
            $table->timestamp('young_first_match')->nullable()->comment('首付款匹配时间');
            $table->timestamp('young_first_end')->nullable()->comment('首付款完结时间');
            $table->decimal('young_first_total', 18, 2)->comment('首付款金额');
            $table->decimal('young_first_pro', 18, 2)->comment('首付款比例');

            //尾款
            $table->timestamp('young_tail_match')->nullable()->comment('尾款匹配时间');
            $table->timestamp('young_tail_end')->nullable()->comment('尾款完结时间');
            $table->decimal('young_tail_total', 18, 2)->comment('尾款金额');

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
        Schema::dropIfExists('buy_order_models');
    }
}
