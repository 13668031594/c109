<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberRankModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_rank_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('young_name')->comment('名称');
            $table->integer('young_sort')->comment('排序');
            $table->integer('young_child')->comment('升级所需的下级数');
            $table->decimal('young_discount', 5, 2)->comment('充值折扣');
            $table->decimal('young_wage', 5, 2)->comment('工资占比');
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
        Schema::dropIfExists('member_rank_models');
    }
}
