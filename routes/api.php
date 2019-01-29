<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['namespace' => 'Login'], function () {

    Route::get('captcha', 'LoginController@captcha');
    Route::post('login', 'LoginController@login');
});

Route::group(['middleware' => 'auth:api'], function () {

    Route::group(['namespace' => 'Login'], function () {

        Route::get('user', 'LoginController@get_member');//会员资料
        Route::get('logout', 'LoginController@logout');//登出
    });

    Route::group(['namespace' => 'User'], function () {

        Route::get('password', 'UserController@sms');//发送短信
        Route::post('password', 'UserController@password');//修改登录密码
        Route::get('mode', 'UserController@mode');//切换下单模式
        Route::get('hosting', 'UserController@hosting');//切换托管模式
//        Route::get('auto', 'UserController@auto');//切换自动买单模式
//        Route::get('wallet-type', 'UserController@wallet');//钱包变动类型
        Route::get('wallet', 'UserController@wallet_table');//钱包变更
    });

    Route::group(['namespace' => 'Team'], function () {

        Route::get('team', 'TeamController@team');//直系下级
        Route::get('tree/{uid}', 'TeamController@tree');//无限级展开
        Route::get('banks', 'TeamController@banks');//获取银行列表
        Route::get('reg/{phone}', 'TeamController@sms');//短信验证
        Route::post('reg', 'TeamController@reg');//添加新的账号
        Route::get('act/{uid}', 'TeamController@act');//抢激活
    });

    Route::group(['namespace' => 'Order'], function () {

        Route::get('buy-list', 'BuyController@index');//买单列表
        Route::get('withdraw/{id}', 'BuyController@withdraw_post');//买单列表
        Route::get('buy-list', 'BuyController@index');//买单列表
        Route::get('buy/{id}', 'BuyController@show');//订单详情
        Route::get('buy', 'BuyController@create');//买单设置
        Route::post('buy', 'BuyController@store');//下购买订单
        Route::get('auto', 'BuyController@auto_index');//自主排单设置
        Route::post('auto', 'BuyController@auto_change');//修改自主排单设置
        Route::post('pay/{id}', 'BuyController@pay');//订单付款

        Route::get('sell-list', 'SellController@index');//卖单列表
        Route::get('sell/{id}', 'SellController@show');//订单详情
        Route::get('sell', 'SellController@create');//卖单设置
        Route::post('sell', 'SellController@store');//下挂卖订单
        Route::get('pay/{id}', 'SellController@confirm');//确认付款
        Route::get('abn/{id}', 'SellController@abn');//报告收款异常

        Route::get('rob', 'RobController@index');//抢单申请列表
        Route::post('rob', 'RobController@store');//发送抢单申请
    });

    Route::group(['namespace' => 'Trad'], function () {

        Route::get('trad', 'TradController@index');//列表
        Route::post('trad', 'TradController@sell');//卖出
        Route::get('trad-buy/{id}', 'TradController@buy');//认购
        Route::post('trad-buy/{id}', 'TradController@pay');//支付
        Route::get('trad/{id}', 'TradController@over');//确认


    });
});
