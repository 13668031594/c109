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

    foreach ($freeze as $v) {

        $wallets = \App\Models\Member\MemberWalletModel::whereUid($v->uid)->where('young_keyword', '=', $v->young_order)->where('young_reward', '<>', 0)->where('young_type', '80')->first();

        if (is_null($wallets)) continue;

        $member = \App\Models\Member\MemberModel::whereUid($v->uid)->first();
        if ($v->young_status == 20) {

            \App\Models\Member\MemberWalletModel::whereUid($v->uid)->where('young_keyword', '=', $v->young_order)->where('young_reward', '<>', 0)->where('young_type', '81')->delete();
            \App\Models\Member\MemberWalletModel::whereUid($v->uid)->where('young_keyword', '=', $v->young_order)->where('young_reward', '=', 0)->where('young_type', '20')->delete();

            $member->young_reward -= $v->young_freeze;
            $member->young_reward_all -= $v->young_freeze;
        }else{

            $member->young_reward_freeze -= $v->young_freeze;
            $member->young_reward_freeze_all -= $v->young_freeze;
        }

        $member->save();

        $v->delete();
    }

    DB::commit();
});