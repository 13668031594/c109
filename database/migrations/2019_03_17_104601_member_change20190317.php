<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MemberChange20190317 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_models', function (Blueprint $table) {
            $table->char('young_special_type', 2)->default('10')->comment('特殊类型');
            $table->char('young_special_level', 2)->default('10')->comment('特殊等级');
            $table->integer('young_special_customer')->default('0')->comment('特殊客服');
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
            $table->dropColumn('young_special_type');
            $table->dropColumn('young_special_level');
            $table->dropColumn('young_special_customer');
        });
    }
}
