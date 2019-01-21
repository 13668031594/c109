<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberWalletModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_wallet_models', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('uid')->comment('会员id');
            $table->decimal('young_gxd', 18, 2)->default(0)->comment('变动贡献点');
            $table->decimal('young_gxd_now', 18, 2)->default(0)->comment('当前贡献点');
            $table->decimal('young_gxd_all', 18, 2)->default(0)->comment('累计贡献点');
            $table->decimal('young_reward', 18, 2)->default(0)->comment('变动奖励账户');
            $table->decimal('young_reward_now', 18, 2)->default(0)->comment('当前奖励账户');
            $table->decimal('young_reward_all', 18, 2)->default(0)->comment('累计奖励账户');
            $table->decimal('young_balance', 18, 2)->default(0)->comment('变动余额');
            $table->decimal('young_balance_now', 18, 2)->default(0)->comment('当前余额');
            $table->decimal('young_balance_all', 18, 2)->default(0)->comment('累计余额');
            $table->decimal('young_poundage', 18, 2)->default(0)->comment('变动手续费');
            $table->decimal('young_poundage_now', 18, 2)->default(0)->comment('当前手续费');
            $table->decimal('young_poundage_all', 18, 2)->default(0)->comment('累计手续费');
            $table->string('young_record')->comment('文字记录');
            $table->string('young_type')->comment('变更类型');
            $table->string('young_keyword')->comment('关键字');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_wallet_models');
    }
}
