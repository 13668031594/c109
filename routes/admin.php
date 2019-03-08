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

Route::post('/test', 'Member\MemberController@post_wallet')->name('login.login');
Route::get('/test');

//登录与首页
Route::group(['namespace' => 'Login'], function () {

    Route::get('/login', 'LoginController@login')->name('login.login');//登录
    Route::post('/login', 'LoginController@auth')->name('login.login');//登录
    Route::get('/logout', 'LoginController@logout')->name('login.logout');//登出

    Route::get('/', 'LoginController@index')->name('login.index');//首页
    Route::get('', 'LoginController@index')->name('login.index');//首页

    Route::post('/fwb-image', 'FwbController@images')->name('login.index');//富文本编辑器上传文件处
});

//管理员
Route::group(['namespace' => 'Master'], function () {

    Route::get('/master/index', 'MasterController@index')->name('master.index');//管理员首页
    Route::get('/master/table', 'MasterController@table')->name('master.index');//管理员列表
    Route::get('/master/create', 'MasterController@create')->name('master.create');//管理员添加
    Route::post('/master/store', 'MasterController@store')->name('master.create');//管理员添加
    Route::get('/master/edit', 'MasterController@edit')->name('master.edit');//管理员编辑
    Route::post('/master/update/{id}', 'MasterController@update')->name('master.edit');//管理员编辑
    Route::get('/master/delete', 'MasterController@destroy')->name('master.destroy');//管理员删除
});

//系统设置
Route::group(['namespace' => 'Set'], function () {

    Route::get('/set', 'SetController@index')->name('set.index');//设置页面
    Route::post('/set', 'SetController@update')->name('set.edit');//设置编辑
    Route::post('/set/goods', 'SetController@goods_cover')->name('set.edit');//商品封面
});

//提示文字
Route::group(['namespace' => 'Prompt'], function () {

    Route::get('/prompt/index', 'PromptController@index')->name('prompt.index');//提示文字首页
    Route::get('/prompt/table', 'PromptController@table')->name('prompt.index');//提示文字列表
    Route::get('/prompt/create', 'PromptController@create')->name('prompt.create');//提示文字添加
    Route::post('/prompt/store', 'PromptController@store')->name('prompt.create');//提示文字添加
    Route::get('/prompt/edit', 'PromptController@edit')->name('prompt.edit');//提示文字编辑
    Route::post('/prompt/update/{id}', 'PromptController@update')->name('prompt.edit');//提示文字编辑
    Route::get('/prompt/delete', 'PromptController@destroy')->name('prompt.destroy');//提示文字删除
});

//公告文字
Route::group(['namespace' => 'Notice'], function () {

    Route::get('/notice/index', 'NoticeController@index')->name('notice.index');//公告首页
    Route::get('/notice/table', 'NoticeController@table')->name('notice.index');//公告列表
    Route::get('/notice/create', 'NoticeController@create')->name('notice.create');//公告添加
    Route::post('/notice/store', 'NoticeController@store')->name('notice.create');//公告添加
    Route::get('/notice/edit', 'NoticeController@edit')->name('notice.edit');//公告编辑
    Route::post('/notice/update/{id}', 'NoticeController@update')->name('notice.edit');//公告编辑
    Route::get('/notice/delete', 'NoticeController@destroy')->name('notice.destroy');//公告删除
});

//银行列表
Route::group(['namespace' => 'Bank'], function () {

    Route::get('/bank/index', 'BankController@index')->name('bank.index');//银行首页
    Route::get('/bank/table', 'BankController@table')->name('bank.index');//银行列表
    Route::get('/bank/create', 'BankController@create')->name('bank.create');//银行添加
    Route::post('/bank/store', 'BankController@store')->name('bank.create');//银行添加
    Route::get('/bank/edit', 'BankController@edit')->name('bank.edit');//银行编辑
    Route::post('/bank/update/{id}', 'BankController@update')->name('bank.edit');//银行编辑
    Route::get('/bank/delete', 'BankController@destroy')->name('bank.destroy');//银行删除
});

//会员列表
Route::group(['namespace' => 'Member'], function () {

    Route::get('/member/index', 'MemberController@index')->name('member.index');//会员首页
    Route::get('/member/table', 'MemberController@table')->name('member.index');//会员列表
    Route::get('/member/create', 'MemberController@create')->name('member.create');//会员添加
    Route::post('/member/store', 'MemberController@store')->name('member.create');//会员添加
    Route::get('/member/edit', 'MemberController@edit')->name('member.edit');//会员编辑
    Route::post('/member/update/{id}', 'MemberController@update')->name('member.edit');//会员编辑
    Route::get('/member/delete', 'MemberController@destroy')->name('member.destroy');//会员删除
    Route::get('/member/team','MemberController@team')->name('member.index');//会员团队

    Route::get('/member/act', 'MemberController@act')->name('member.act');//后台激活会员

    Route::get('/member/wallet', 'MemberController@wallet')->name('member.wallet');//钱包详情
    Route::post('/member/wallet', 'MemberController@post_wallet')->name('member.wallet_change');//钱包充值
    Route::get('/member/wallet-record', 'MemberController@wallet_record')->name('member.wallet');//记录页面
    Route::get('/member/wallet-record-table', 'MemberController@wallet_record_table')->name('member.wallet');//记录数据
    Route::get('/member/wallet-record-delete', 'MemberController@wallet_record_delete')->name('member.wallet_destroy');//删除记录

    Route::get('/member/record', 'MemberController@record')->name('member.record');//记录页面
    Route::get('/member/record-table', 'MemberController@record_table')->name('member.record');//记录数据
    Route::get('/member/record-delete', 'MemberController@record_delete')->name('member.record_destroy');//删除记录

    Route::get('/rank/index', 'RankController@index')->name('rank.index');//等级首页
    Route::get('/rank/table', 'RankController@table')->name('rank.index');//等级列表
    Route::get('/rank/create', 'RankController@create')->name('rank.create');//等级添加
    Route::post('/rank/store', 'RankController@store')->name('rank.create');//等级添加
    Route::get('/rank/edit', 'RankController@edit')->name('rank.edit');//等级编辑
    Route::post('/rank/update/{id}', 'RankController@update')->name('rank.edit');//等级编辑
    Route::get('/rank/delete', 'RankController@destroy')->name('rank.destroy');//等级删除

    Route::get('/liq', 'MemberController@liq')->name('member.liq');
    Route::post('/liq', 'MemberController@liq_post')->name('member.liq');
});

//客服
Route::group(['namespace' => 'Customer'], function () {

    Route::get('/customer/index', 'CustomerController@index')->name('customer.index');//客服首页
    Route::get('/customer/table', 'CustomerController@table')->name('customer.index');//客服列表
    Route::get('/customer/create', 'CustomerController@create')->name('customer.create');//客服添加
    Route::post('/customer/store', 'CustomerController@store')->name('customer.create');//客服添加
    Route::get('/customer/edit', 'CustomerController@edit')->name('customer.edit');//客服编辑
    Route::post('/customer/update/{id}', 'CustomerController@update')->name('customer.edit');//客服编辑
    Route::get('/customer/delete', 'CustomerController@destroy')->name('customer.destroy');//客服删除
});

//订单
Route::group(['namespace' => 'Order'], function () {

    Route::get('/buy/index', 'BuyController@index')->name('buy.index');//采集列表
    Route::get('/buy/table', 'BuyController@table')->name('buy.index');//采集数据
    Route::get('/buy/show', 'BuyController@show')->name('buy.index');//采集详情
    Route::get('/buy/abn', 'BuyController@abn')->name('buy.abn');//清除异常
    Route::get('/buy/edit', 'BuyController@edit')->name('buy.edit');//订单编辑
    Route::post('/buy/update/{id}', 'BuyController@update')->name('buy.edit');//订单编辑

    Route::get('/sell/index', 'SellController@index')->name('sell.index');//寄售列表
    Route::get('/sell/table', 'SellController@table')->name('sell.index');//寄售数据
    Route::get('/sell/show', 'SellController@show')->name('sell.index');//寄售详情
    Route::get('/sell/edit', 'SellController@edit')->name('sell.edit');//订单编辑
    Route::post('/sell/update/{id}', 'SellController@update')->name('sell.edit');//订单编辑

    Route::get('match/index', 'MatchController@index')->name('match.index');//匹配列表
    Route::get('match/table', 'MatchController@table')->name('match.index');//匹配数据
    Route::get('match/show', 'MatchController@show')->name('match.index');//匹配详情
    Route::get('match/edit', 'MatchController@edit')->name('match.edit');//订单编辑
    Route::post('/match/update/{id}', 'MatchController@update')->name('match.edit');//订单编辑
});

//订单
Route::group(['namespace' => 'Trad'], function () {

    Route::get('/trad/index', 'TradController@index')->name('trad.index');//挂售列表
    Route::get('/trad/table', 'TradController@table')->name('trad.index');//挂售数据
    Route::get('/trad/show', 'TradController@show')->name('trad.index');//挂售详情
    Route::get('/trad/edit', 'TradController@edit')->name('trad.edit');//订单编辑
    Route::post('/trad/update/{id}', 'TradController@update')->name('trad.edit');//订单编辑
});

//统计
Route::group(['namespace' => 'Bill'], function () {

    Route::get('/bill/index', 'BillController@index')->name('bill.index');//统计列表
    Route::get('/bill/table', 'BillController@table')->name('bill.index');//统计数据
    Route::get('/match-simu/index', 'MatchSimuController@index')->name('bill.match-simu');//预匹配数据
    Route::get('/match-simu/table', 'MatchSimuController@table')->name('bill.match-simu');//预匹配数据
});

