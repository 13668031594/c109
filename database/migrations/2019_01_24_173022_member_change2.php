<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MemberChange2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_models', function (Blueprint $table) {
            $table->char('young_auto_buy', 2)->default('20')->comment('自动购买');
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
            $table->dropColumn('young_auto_buy');
        });
    }
}
