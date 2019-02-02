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
Route::get('/', function () {

    $date = date('Ymd');
    $a = \Earnp\Getui\Getui::getUserDataByDate($date);
//    $a = \Earnp\Getui\Getui::getUserStatus();
    dd($a);
//    return view('test');
});

Route::post('test/{id}','Api\Order\BuyController@pay');

Route::get('plan', 'Plan\PlanController@index');
