<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MemberChange5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_models', function (Blueprint $table) {
            $table->decimal('young_incite', 18, 2)->default(0)->comment('鼓励账户');
            $table->decimal('young_incite_all', 18, 2)->default(0)->comment('累计鼓励账户');
            $table->string('young_incite_note')->nullable()->comment('鼓励账户备注');
        });

        Schema::table('member_wallet_models', function (Blueprint $table) {
            $table->decimal('young_incite', 18, 2)->default(0)->comment('变动鼓励账户');
            $table->decimal('young_incite_now', 18, 2)->default(0)->comment('当前鼓励账户');
            $table->decimal('young_incite_all', 18, 2)->default(0)->comment('累计鼓励账户');
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
            $table->dropColumn('young_incite');
            $table->dropColumn('young_incite_all');
            $table->dropColumn('young_incite_note');
        });

        Schema::table('member_wallet_models', function (Blueprint $table) {
            $table->decimal('young_incite', 18, 2);
            $table->decimal('young_incite_now', 18, 2);
            $table->decimal('young_incite_all', 18, 2);
        });
    }
}
