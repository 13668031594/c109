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

    $match = new \App\Models\Order\MatchOrderModel();

    $order = new \App\Models\Order\BuyOrderModel();

    $orders = $order->whereIn('young_status',[70,75])->get();

    foreach ($orders as $v){

        $member = \App\Models\Member\MemberModel::whereUid($v->uid)->first();

        if (is_null($member))continue;

        $test = \App\Models\Member\MemberWalletModel::whereUid($member->young_referee_id)
            ->where('young_reward','<>',0)
            ->where('young_keyword','=',$v->young_order)
            ->where('young_type','=',80)
            ->first();

        if (!is_null($test))continue;

        define('DDDATE',$v->young_tail_end);

        $match->reward($v);
    }
    DB::commit();

    dd('ok');
});