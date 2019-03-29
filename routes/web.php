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

    $freeze = new \App\Models\Order\RewardFreezeModels();

    //将上次的分佣解冻
    $freeze->thaw('B375592');

    DB::commit();

    dd('ok');
});