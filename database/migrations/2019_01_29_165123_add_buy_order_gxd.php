<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBuyOrderGxd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buy_order_models', function (Blueprint $table) {
            $table->decimal('young_gxd_pro', 4, 2)->default(0)->comment('收益贡献点比例');
            $table->decimal('young_gxd', 18, 2)->default(0)->comment('收益贡献点');
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
            $table->dropColumn('young_gxd_pro');
            $table->dropColumn('young_gxd');
        });

    }
}
