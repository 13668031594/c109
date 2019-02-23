<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TradChange1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trad_models', function (Blueprint $table) {
            $table->string('young_pay')->nullable()->comment('支付凭证');
            $table->decimal('young_poundage',18,2)->default(0)->comment('星伙');
            //银行相关
            $table->integer('young_bank_id')->nullable()->comment('银行id');
            $table->string('young_bank_name')->nullable()->comment('银行名称');
            $table->string('young_bank_address')->nullable()->comment('支行');
            $table->string('young_bank_no')->nullable()->comment('银行卡号');
            $table->string('young_bank_man')->nullable()->comment('收款人姓名');
            $table->string('young_alipay')->nullable()->comment('支付宝');
            $table->string('young_note')->nullable()->comment('备注');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trad_models', function (Blueprint $table) {
            $table->dropColumn('young_pay');
            $table->dropColumn('young_poundage');
            $table->dropColumn('young_bank_id');
            $table->dropColumn('young_bank_name');
            $table->dropColumn('young_bank_address');
            $table->dropColumn('young_bank_no');
            $table->dropColumn('young_bank_man');
            $table->dropColumn('young_alipay');
            $table->dropColumn('young_note');
        });
    }
}
