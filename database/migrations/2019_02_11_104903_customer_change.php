<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomerChange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_models', function (Blueprint $table) {
            $table->char('young_switch', 2)->default(10)->comment('随机分配开关');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_models', function (Blueprint $table) {
            $table->dropColumn('young_switch');
        });
    }
}
