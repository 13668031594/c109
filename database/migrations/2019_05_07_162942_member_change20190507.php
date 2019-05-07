<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MemberChange20190507 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_models', function (Blueprint $table) {
            $table->decimal('young_wage', 18, 2)->default(0)->comment('工资');
            $table->decimal('young_wage_all', 18, 2)->default(0)->comment('累计工资');
        });

        Schema::table('member_wallet_models', function (Blueprint $table) {
            $table->decimal('young_wage', 18, 2)->default(0)->comment('变动工资');
            $table->decimal('young_wage_now', 18, 2)->default(0)->comment('当前工资');
            $table->decimal('young_wage_all', 18, 2)->default(0)->comment('累计工资');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_models', function (Blueprint $table) {
            $table->dropColumn('young_wage');
            $table->dropColumn('young_wage_all');
        });

        Schema::table('member_wallet_models', function (Blueprint $table) {
            $table->dropColumn('young_wage');
            $table->dropColumn('young_wage_now');
            $table->dropColumn('young_wage_all');
        });
    }
}
