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
            $table->decimal('young_poundage',18,2)->default(0)->comment('手续费');
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
            $table->dropColumn('young_poundage');
        });
    }
}
