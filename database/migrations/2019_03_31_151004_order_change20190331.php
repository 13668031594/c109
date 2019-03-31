<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderChange20190331 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buy_order_models', function (Blueprint $table) {
            $table->char('young_fast_order',1)->default('0')->comment('是否为快速订单');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buy_order_models', function (Blueprint $table) {
            $table->dropColumn('young_fast_order');
        });

    }
}
