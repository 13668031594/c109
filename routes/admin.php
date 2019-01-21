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

    Route::get('/member/act', 'MemberController@act')->name('member.act');//后台激活会员

    Route::get('/member/wallet', 'MemberController@wallet')->name('member.index');//钱包详情
    Route::post('/member/wallet', 'MemberController@post_wallet')->name('member.wallet');//钱包充值
    Route::get('/member/wallet-record', 'MemberController@wallet_record')->name('member.index');//记录页面
    Route::get('/member/wallet-record-table', 'MemberController@wallet_record_table')->name('member.index');//记录数据
    Route::get('/member/wallet-record-delete', 'MemberController@wallet_record_delete')->name('member.wallet');//删除记录

    Route::get('/member/record', 'MemberController@record')->name('member.index');//记录页面
    Route::get('/member/record-table', 'MemberController@record_table')->name('member.index');//记录数据
    Route::get('/member/record-delete', 'MemberController@record_delete')->name('member.record_delete');//删除记录
});

