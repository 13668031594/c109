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

//    $date = date('Ymd');
//    $a = \Earnp\Getui\Getui::getUserDataByDate($date);
//    $a = \Earnp\Getui\Getui::getUserStatus();
//    dd($a);
//    return view('test');

    $template = "IGtTransmissionTemplate";
    $data = "a";
    $config = array("type" => "HIGH", "title" => "你有一条新消息", "body" => "你有一个3000元的订单需要申请","logo"=>"","logourl"=>"");
    $CID = "06d66ba1adc320ecf966a13a1fee32fd";
    $test = \Earnp\Getui\Getui::pushMessageToSingle($template,$config,$data,$CID);
    dd($test);
});

Route::post('test/{id}','Api\Order\BuyController@pay');

Route::get('plan', 'Plan\PlanController@index');
