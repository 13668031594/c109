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

    Route::get('version', 'LoginController@version');
    Route::get('captcha', 'LoginController@captcha');
    Route::post('login', 'LoginController@login');
});

Route::group(['middleware' => ['auth:api', 'apiWebClose', 'apiAct30', 'apiStatus30']], function () {

    Route::group(['namespace' => 'Login'], function () {

        Route::get('user', 'LoginController@get_member');//会员资料
        Route::get('user-wallet', 'LoginController@get_wallet');//获取钱包信息
        Route::get('logout', 'LoginController@logout');//登出
        Route::get('prompt/{keyword}', 'LoginController@prompt');//提示文字
    });

    Route::group(['namespace' => 'User'], function () {

        Route::get('password', 'UserController@sms');//发送短信
        Route::post('password', 'UserController@password')->middleware('apiStatus20');//修改登录密码
        Route::get('mode', 'UserController@mode')->middleware('apiStatus20');//切换下单模式
        Route::get('hosting', 'UserController@hosting')->middleware('apiStatus20');//切换托管模式
//        Route::get('auto', 'UserController@auto');//切换自动买单模式
//        Route::get('wallet-type', 'UserController@wallet');//钱包变动类型
        Route::get('wallet', 'UserController@wallet_table');//钱包变更
        Route::post('family', 'UserController@family_binding')->middleware('apiStatus20');//家谱绑定
        Route::get('sign', 'UserController@sign');//签到
        Route::post('sign', 'UserController@signing');//签到领取收益
    });

    Route::group(['namespace' => 'Team'], function () {

        Route::get('team', 'TeamController@team');//直系下级
        Route::get('tree/{uid}', 'TeamController@tree');//无限级展开
        Route::get('banks', 'TeamController@banks');//获取银行列表
        Route::get('reg/{phone}', 'TeamController@sms')->middleware('apiStatus20');//短信验证
        Route::post('reg', 'TeamController@reg')->middleware('apiStatus20');//添加新的账号
        Route::get('act/{uid}', 'TeamController@act')->middleware('apiStatus20');//抢激活
        Route::post('hosting', 'TeamController@hosting')->middleware('apiStatus20');//切换到会员
        Route::post('turn', 'TeamController@turn')->middleware('apiStatus20');//转账给下级;
    });

    Route::group(['namespace' => 'Order'], function () {

        Route::get('buy-list', 'BuyController@index');//买单列表
        Route::get('withdraw/{id}', 'BuyController@withdraw_post')->middleware('apiStatus20');//提现
        Route::get('buy/{id}', 'BuyController@show');//订单详情
        Route::get('buy', 'BuyController@create');//买单设置
        Route::post('buy', 'BuyController@store')->middleware('apiStatus20');//下购买订单
        Route::get('auto', 'BuyController@auto_index');//自主排单设置
        Route::post('auto', 'BuyController@auto_change')->middleware('apiStatus20');//修改自主排单设置
        Route::post('pay/{id}', 'BuyController@pay');//订单付款

        Route::get('sell-list', 'SellController@index');//卖单列表
        Route::get('sell/{id}', 'SellController@show');//订单详情
        Route::get('sell', 'SellController@create');//卖单设置
        Route::post('sell', 'SellController@store')->middleware('apiStatus20');//下挂卖订单
        Route::get('pay/{id}', 'SellController@confirm');//确认付款
        Route::get('abn/{id}', 'SellController@abn')->middleware('apiStatus20');//报告收款异常

        Route::get('rob', 'RobController@index');//抢单申请列表
        Route::post('rob', 'RobController@store')->middleware('apiStatus20');//发送抢单申请
    });

    Route::group(['namespace' => 'Trad'], function () {

        Route::get('trad', 'TradController@index');//列表
        Route::post('trad', 'TradController@sell')->middleware('apiStatus20');//卖出
        Route::get('trad-back/{id}', 'TradController@back');//撤回
        Route::get('trad-buy/{id}', 'TradController@buy')->middleware('apiStatus20');//认购
        Route::post('trad-buy/{id}', 'TradController@pay');//支付
        Route::get('trad/{id}', 'TradController@over');//确认
    });
});