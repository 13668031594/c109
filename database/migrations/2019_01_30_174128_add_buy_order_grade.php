<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBuyOrderGrade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buy_order_models', function (Blueprint $table) {
            $table->char('young_grade', 2)->default('10')->comment('会员下单时候的身份');
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
            $table->dropColumn('young_grade');
        });

    }
}
