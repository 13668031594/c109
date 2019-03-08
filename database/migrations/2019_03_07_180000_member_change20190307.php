<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MemberChange20190307 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_models', function (Blueprint $table) {
            $table->char('young_match_level', 2)->default('20')->comment('匹配优先级');
            $table->string('young_idcard_name')->nullable()->comment('身份证姓名');
            $table->string('young_idcard_no')->nullable()->comment('身份证号');
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
            $table->dropColumn('young_match_level');
            $table->dropColumn('young_idcard_name');
            $table->dropColumn('young_idcard_no');
        });
    }
}
