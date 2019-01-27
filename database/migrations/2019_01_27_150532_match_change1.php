<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MatchChange1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('match_order_models', function (Blueprint $table) {
            $table->timestamp('young_pay_time')->nullable()->comment('打款时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('match_order_models', function (Blueprint $table) {
            $table->dropColumn('young_pay_time');
        });
    }
}
