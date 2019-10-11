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

Route::get('plan', 'Plan\PlanController@index');
Route::get('c104', 'Plan\PlanController@gxd_with');


//网页端文件夹
Route::group(['middleware' => ['authWeb']], function () {

    Route::group(['namespace' => 'Web'], function () {

        //登录
        Route::get('login', 'LoginController@to_login')->name('web.login');
        Route::post('login', 'LoginController@login')->name('web.login');

        //首页
        Route::get('', 'IndexController@index')->name('web.index');
        Route::get('/', 'IndexController@index')->name('web.index');

        //注销
        Route::get('logout', 'LoginController@logout')->name('web.index');

        //个人资料
        Route::get('self', 'IndexController@self')->name('web.self');
        Route::get('mima', 'indexController@password')->name('web.self');

        //桌面
        Route::get('homepage', 'HomeController@index')->name('web.home');
        Route::get('buy-list', 'HomeController@buy_list')->name('web.home');
        Route::get('sell-list', 'HomeController@sell_list')->name('web.home');
        Route::get('notice', 'HomeController@notice')->name('web.notice');
        Route::get('prompt', 'HomeController@prompt')->name('web.notice');

        //购入推广权
        Route::get('popup', 'HomeController@popup')->name('web.home');

        //卖出
        Route::get('popup2', 'HomeController@popup2')->name('web.home');

        //自动预约
        Route::get('popup3', 'HomeController@popup3')->name('web.home');

        //交易市场
        Route::get('market', 'MarketController@index')->name('web.market');
        Route::get('trad_index', 'MarketController@trad_index')->name('web.market');//寄售列表
        Route::get('trad_sell', 'MarketController@trad_sell')->name('web.market');//我的寄售
        Route::get('trad_buy', 'MarketController@trad_buy')->name('web.market');//我的交易
        Route::get('popup4', 'MarketController@sell')->name('web.market');//卖出
        Route::get('trad_details', 'MarketController@details')->name('web.market');//详情

        //钱包首页
        Route::get('wallet', 'WalletController@index')->name('web.wallet');
        Route::get('wallet-record', 'WalletController@record')->name('web.wallet');//钱包记录
        Route::get('wallet-table', 'WalletController@wallet_table')->name('web.wallet');//钱包数据

        Route::get('team', 'TeamController@index')->name('web.team');//团队展示
        Route::post('hosting', 'TeamController@hosting')->name('web.team');//切换会员

        Route::get('register', 'RegisterController@register')->name('web.register');//新增推广员
    });

    Route::group(['namespace' => 'Api'], function () {

        Route::post('pay/{id}', 'Order\BuyController@pay')->name('web.home');//订单付款
        Route::get('pay/{id}', 'Order\SellController@confirm')->name('web.home');//确认付款
        Route::get('back/{id}', 'Order\SellController@confirm')->name('web.home');//确认付款
        Route::post('buy', 'Order\BuyController@store')->name('web.home')->middleware('apiStatus20');//下购买订单
        Route::post('auto', 'Order\BuyController@auto_change')->name('web.home')->middleware('apiStatus20');//修改自主排单设置
        Route::post('sell', 'Order\SellController@store')->name('web.home')->middleware('apiStatus20');//下挂卖订单

        Route::get('sms/{phone}', 'Team\TeamController@sms')->name('web.home')->middleware('apiStatus20');//注册短信
        Route::post('register', 'Team\TeamController@reg')->name('web.home')->middleware('apiStatus20');//注册账号

        Route::post('trad', 'Trad\TradController@sell')->name('web.market')->middleware('apiStatus20');//卖出贡献点
        Route::get('trad_buy/{id}', 'Trad\TradController@buy')->name('web.market')->middleware('apiStatus20');//认购贡献点
        Route::post('trad_pay/{id}', 'Trad\TradController@pay')->name('web.market')->middleware('apiStatus20');//贡献点付款凭证上传
        Route::get('trad_back/{id}', 'Trad\TradController@back')->name('web.market')->middleware('apiStatus20');//撤销贡献点挂售
        Route::get('trad_over/{id}', 'Trad\TradController@over')->name('web.market')->middleware('apiStatus20');//确认收款

        Route::post('turn', 'Team\TeamController@turn')->name('web.turn')->middleware('apiStatus20');//转账给下级;
    });
});

