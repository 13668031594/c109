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

    $day = 'asd';
    $day = (int)$day;

    if (empty($day)) $date = date('Y-m-d 00:00:00');
    else $date = date('Y-m-d 00:00:00', strtotime('-' . ($day - 1) . ' day'));

    return $date;
});