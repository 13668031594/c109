<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BuyOrderChange2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buy_order_models', function (Blueprint $table) {
            $table->char('young_abn', 2)->default('10')->comment('异常');
            $table->decimal('young_tail_complete', 18,2)->default(0)->comment('已经匹配尾款');
        });
        Schema::table('match_order_models', function (Blueprint $table) {
            $table->char('young_abn', 2)->default('10')->comment('异常');
            $table->char('young_type', 2)->default('10')->comment('类型');
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
            $table->dropColumn('young_abn');
            $table->dropColumn('young_tail_complete');
        });

        Schema::table('match_order_models', function (Blueprint $table) {
            $table->dropColumn('young_abn');
            $table->dropColumn('young_type');
        });
    }
}
