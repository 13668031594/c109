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

    $uid = '29';
    $model = new \App\Models\Member\MemberWalletModel();
    $poundage = $model->where('uid','=',$uid)
        ->where('created_at','>','2019-03-05 22:00:00')
        ->where('created_at','<=','2019-03-05 23:59:59')
        ->where('young_type','=',51)
        ->sum('young_poundage');

    $gxd = $model->where('uid','=',$uid)
        ->where('created_at','>','2019-03-05 22:00:00')
        ->where('created_at','<=','2019-03-05 23:59:59')
        ->where('young_type','=',51)
        ->sum('young_gxd');

    dd($gxd,$poundage);
});