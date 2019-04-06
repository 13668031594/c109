<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MemberChange20190406 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_models', function (Blueprint $table) {
            $table->string('young_qq')->nullable()->comment('QQ号');
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
            $table->dropColumn('young_qq');
        });
    }
}
