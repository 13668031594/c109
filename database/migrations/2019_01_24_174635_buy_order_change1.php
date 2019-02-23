<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BuyOrderChange1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buy_order_models', function (Blueprint $table) {
            $table->char('young_from', 2)->default('10')->comment('来源');
            $table->decimal('young_poundage', 18, 2)->comment('星伙');
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
            $table->dropColumn('young_from');
            $table->dropColumn('young_poundage');
        });
    }
}
