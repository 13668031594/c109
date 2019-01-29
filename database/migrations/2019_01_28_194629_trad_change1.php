<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TradChange1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trad_models', function (Blueprint $table) {
            $table->string('young_pay')->nullable()->comment('支付凭证');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trad_models', function (Blueprint $table) {
            $table->dropColumn('young_pay');
        });
    }
}
