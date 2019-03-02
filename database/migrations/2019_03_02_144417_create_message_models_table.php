<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_models', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->comment('会员uid');
            $table->char('young_status',2)->default(10)->comment('状态');
            $table->char('young_type',2)->default(10)->comment('消息类型');
            $table->string('young_message')->comment('消息内容');
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
        Schema::dropIfExists('message_models');
    }
}
