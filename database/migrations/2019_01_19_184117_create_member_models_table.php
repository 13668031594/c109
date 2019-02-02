<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_models', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('uid');
            $table->string('young_account')->comment('账号');
            $table->char('young_phone', 11)->comment('联系电话');
            $table->string('young_email')->comment('联系邮箱');
            $table->string('password')->comment('密码');
            $table->string('young_pay_pass')->comment('支付密码');
            $table->string('young_nickname')->comment('昵称');

            //上级相关
            $table->string('young_level')->default(1)->comment('所在层级');
            $table->string('young_families')->default(0)->comment('上级缓存');
            $table->string('young_referee_id')->default(0)->comment('上级id');
            $table->string('young_referee_account')->default('无')->comment('上级账号');
            $table->string('young_referee_nickname')->default('君王战神')->comment('上级昵称');

            //家谱相关
            $table->string('young_family_account')->nullable()->comment('家谱绑定账号');
            $table->timestamp('young_family_binding')->nullable()->comment('绑定时间');

            //钱包
            $table->decimal('young_balance', 18, 2)->default(0)->comment('余额');
            $table->decimal('young_balance_all', 18, 2)->default(0)->comment('累计余额');
            $table->decimal('young_gxd', 18, 2)->default(0)->comment('贡献点');
            $table->decimal('young_gxd_all', 18, 2)->default(0)->comment('累计贡献点');
            $table->decimal('young_reward', 18, 2)->default(0)->comment('奖励账户');
            $table->decimal('young_reward_all', 18, 2)->default(0)->comment('累计奖励账户');
            $table->decimal('young_poundage', 18, 2)->default(0)->comment('手续费');
            $table->decimal('young_poundage_all', 18, 2)->default(0)->comment('累计手续费');

            //身份状态
            $table->char('young_status', 2)->default('10')->comment('账号状态');
            $table->timestamp('young_status_time')->nullable()->comment('账号状态变更时间');
            $table->char('young_mode', 2)->default('10')->comment('账号模式');
            $table->timestamp('young_mode_time')->nullable()->comment('账号模式变更时间');
            $table->char('young_type', 2)->default('10')->comment('收益模式');
            $table->timestamp('young_type_time')->nullable()->comment('收益模式变更时间');
            $table->char('young_liq', 2)->default('10')->comment('清算模式');
            $table->timestamp('young_liq_time')->nullable()->comment('清算模式变更时间');
            $table->char('young_grade', 2)->default('10')->comment('身份');
            $table->timestamp('young_grade_time')->nullable()->comment('身份变更时间');
            $table->char('young_act', 2)->default('10')->comment('激活');
            $table->timestamp('young_act_time')->nullable()->comment('激活时间');
            $table->char('young_act_from', 2)->default('10')->comment('激活方式');

            //排单相关
            $table->timestamp('young_first_buy_time')->nullable()->comment('首次排单时间');
            $table->decimal('young_first_buy_total', 18, 2)->default(0)->comment('首次排单金额');
            $table->timestamp('young_last_buy_time')->nullable()->comment('上次排单时间');
            $table->decimal('young_last_buy_total', 18, 2)->default(0)->comment('上次排单金额');
            $table->decimal('young_all_buy_total', 18, 2)->default(0)->comment('总排单金额');
            $table->decimal('young_all_in_total', 18, 2)->default(0)->comment('总收益金额');

            //卖单相关
            $table->timestamp('young_first_sell_time')->nullable()->comment('首次卖单时间');
            $table->decimal('young_first_sell_total', 18, 2)->default(0)->comment('首次卖单金额');
            $table->timestamp('young_last_sell_time')->nullable()->comment('上次卖单时间');
            $table->decimal('young_last_sell_total', 18, 2)->default(0)->comment('上次卖单金额');
            $table->decimal('young_all_sell_total', 18, 2)->default(0)->comment('总卖单金额');

            //银行相关
            $table->integer('young_bank_id')->nullable()->comment('银行id');
            $table->string('young_bank_name')->nullable()->comment('银行名称');
            $table->string('young_bank_address')->nullable()->comment('支行');
            $table->string('young_bank_no')->nullable()->comment('银行卡号');
            $table->string('young_bank_man')->nullable()->comment('收款人姓名');
            $table->string('young_alipay')->nullable()->comment('支付宝');
            $table->string('young_note')->nullable()->comment('备注');

            //登录
            $table->integer('young_login_times')->default(0)->comment('登录次数');
            $table->timestamp('young_last_login_time')->nullable()->comment('上次登录时间');
            $table->timestamp('young_this_login_time')->nullable()->comment('本次登录时间');
            $table->string('young_last_login_ip')->nullable()->comment('上次登录ip');
            $table->string('young_this_login_ip')->nullable()->comment('本次登录ip');

            //其他
            $table->rememberToken();
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
        Schema::dropIfExists('member_models');
    }
}
