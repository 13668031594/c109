<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MemberChange20190322 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_models', function (Blueprint $table) {
            $table->decimal('young_reward_freeze', 18, 2)->default(0)->comment('奖励账户冻结资金');
            $table->decimal('young_reward_freeze_all', 18, 2)->default(0)->comment('累计奖励账户冻结资金');
        });

        Schema::table('member_wallet_models', function (Blueprint $table) {
            $table->decimal('young_reward_freeze', 18, 2)->default(0)->comment('变动奖励账户冻结资金');
            $table->decimal('young_reward_freeze_now', 18, 2)->default(0)->comment('当前奖励账户冻结资金');
            $table->decimal('young_reward_freeze_all', 18, 2)->default(0)->comment('累计奖励账户冻结资金');
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
            $table->dropColumn('young_reward_freeze');
            $table->dropColumn('young_reward_freeze_all');
        });

        Schema::table('member_wallet_models', function (Blueprint $table) {
            $table->dropColumn('young_reward_freeze');
            $table->dropColumn('young_reward_freeze_now');
            $table->dropColumn('young_reward_freeze_all');
        });
    }
}
