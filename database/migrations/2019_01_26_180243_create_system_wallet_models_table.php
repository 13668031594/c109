<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemWalletModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_wallet_models', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->decimal('young_gxd', 18, 2)->default(0)->comment('变动贡献点');
            $table->decimal('young_reward', 18, 2)->default(0)->comment('变动奖励账户');
            $table->decimal('young_balance', 18, 2)->default(0)->comment('变动余额');
            $table->decimal('young_poundage', 18, 2)->default(0)->comment('变动星伙');
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
        Schema::dropIfExists('system_wallet_models');
    }
}
