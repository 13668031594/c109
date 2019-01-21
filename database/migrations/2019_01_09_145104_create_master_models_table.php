<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_models', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('mid');
            $table->string('young_nickname')->comment('昵称');//昵称
            $table->string('young_account')->comment('账号');//账号
            $table->string('password')->comment('密码');//密码
            $table->char('young_phone', 11)->nullable()->comment('联系电话');//电话
            $table->integer('young_login_times')->default(0)->comment('登录次数');//登录次数
            $table->timestamp('young_last_login_time')->nullable()->comment('上次登录时间');//上次登录时间
            $table->timestamp('young_this_login_time')->nullable()->comment('本次登录时间');//本次登录时间
            $table->string('young_last_login_ip')->nullable()->comment('上次登录ip');//上次登录IP
            $table->string('young_this_login_ip')->nullable()->comment('本次登录ip');//本次登录IP
            $table->integer('young_power_id')->comment('权限组id');//部门ID
            $table->string('young_power_name')->comment('权限组名称');//部门名称
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
        Schema::dropIfExists('master_models');
    }
}
