<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::post('test/{id}', 'Api\Order\BuyController@pay');

Route::get('plan', 'Plan\PlanController@index');
Route::get('c104', 'Plan\PlanController@gxd_with');

Route::get('test', function () {

    DB::beginTransaction();

    $freeze = \App\Models\Order\RewardFreezeModels::whereYoungStatus(20)->all();

    $result = [];
    $number = [];

    foreach ($freeze as $v) {

        $wallets = \App\Models\Member\MemberWalletModel::whereUid($v->uid)->where('young_keyword', '=', $v->young_order)->where('young_reward', '<>', 0)->where('young_type', '80')->first();

        if (is_null($wallets)) continue;

        if (!isset($result[$v->uid])) $result[$v->uid] = 0;
        if (!isset($number[$v->uid])) $number[$v->uid] = 0;

        $result[$v->uid] += $wallets->young_reward;
        $number[$v->uid]++;

    }
    foreach ($result as $k => $v) {

        $member = \App\Models\Member\MemberModel::whereUid($k)->first();

        dump($k . '-' . $member->young_nickname . '重复收益：' . $number[$k] . '单，合计重复收益：' . $v);
    }


    DB::rollBack();
});