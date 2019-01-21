<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/11
 * Time: 下午2:30
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;

interface ListInterface
{
    //初始化模型
    public function __construct();

    //列表页面
    public function index();

    //列表数据
    public function table();

    //详情页面
    public function show(Request $request);

    //添加页面
    public function create();

    //保存数据
    public function store(Request $request);

    //编辑页面
    public function edit(Request $request);

    //更新数据
    public function update($id, Request $request);

    //删除数据
    public function destroy(Request $request);
}