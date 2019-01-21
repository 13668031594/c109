<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2018/10/17
 * Time: 下午5:48
 */

namespace App\Http\Classes;

use Illuminate\Http\Request;

interface ListInterface
{
    //列表页面
    public function index();

    //详情页面
    public function show($id);

    //添加页面
    public function create();

    //保存数据
    public function store(Request $request);

    //编辑页面
    public function edit($id);

    //更新数据
    public function update($id, Request $request);

    //删除数据
    public function destroy($id);

    //保存数据验证
    public function validator_store(Request $request);

    //编辑数据验证
    public function validator_update($id, Request $request);

    //删除数据验证
    public function validator_delete($id);
}