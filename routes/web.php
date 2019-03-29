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

    $freeze = \App\Models\Order\RewardFreezeModels::all();

    $result = [];

    foreach ($freeze as $v) {

        $wallets = \App\Models\Member\MemberWalletModel::whereUid($v->uid)->where('young_keyword', '=', $v->young_order)->where('young_reward', '<>', 0)->where('young_type', '80')->first();

        if (is_null($wallets)) continue;

        if (!isset($result[$v->uid])) $result[$v->uid] = ['total' => 0, 'number' => 0];

        if ($v->young_status == 20) {

            \App\Models\Member\MemberWalletModel::whereUid($v->uid)->where('young_keyword', '=', $v->young_order)->where('young_reward', '<>', 0)->where('young_type', '81')->delete();
            \App\Models\Member\MemberWalletModel::whereUid($v->uid)->where('young_keyword', '=', $v->young_order)->where('young_reward', '=', 0)->where('young_type', '20')->delete();

            $result[$v->uid]['total'] += $v->young_freeze;
            $result[$v->uid]['number'] ++;
        }


        $v->delete();
    }

    dd($result);

    DB::rollBack();
});