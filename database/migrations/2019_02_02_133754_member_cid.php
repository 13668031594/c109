<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MemberCid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_models', function (Blueprint $table) {
            $table->string('young_cid')->nullable()->comment('推送cid');
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
            $table->dropColumn('young_cid');
        });
    }
}
