<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticeModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notice_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('young_title')->comment('标题');
            $table->string('young_content')->comment('内容');
            $table->string('young_man')->comment('发布人');
            $table->integer('young_sort')->comment('排序');
            $table->char('young_status')->default('10')->comment('状态');
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
        Schema::dropIfExists('notice_models');
    }
}
