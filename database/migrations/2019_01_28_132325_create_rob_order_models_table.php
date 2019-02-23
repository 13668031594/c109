<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRobOrderModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rob_models', function (Blueprint $table) {
            $table->decimal('young_total', 18, 2)->comment('总价');
            $table->decimal('young_amount', 18, 2)->comment('商品单价');
            $table->decimal('young_poundage', 18, 2)->comment('星伙');
            $table->decimal('young_in_pro', 18, 2)->comment('收益率');
            $table->integer('young_number')->comment('采集数量');
            $table->integer('young_time')->comment('收益时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rob_models', function (Blueprint $table) {
            $table->dropColumn('young_total');
            $table->dropColumn('young_amount');
            $table->dropColumn('young_poundage');
            $table->dropColumn('young_in_pro');
            $table->dropColumn('young_number');
            $table->dropColumn('young_time');
        });
    }
}
