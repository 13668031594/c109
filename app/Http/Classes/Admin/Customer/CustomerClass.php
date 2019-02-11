<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/12
 * Time: 下午1:55
 */

namespace App\Http\Classes\Admin\Customer;

use App\Http\Classes\Admin\AdminClass;
use App\Http\Classes\ListInterface;
use App\Models\Customer\CustomerModel;
use App\Models\Master\MasterModel;
use App\Models\Master\MasterPowerModel;
use App\Models\Member\MemberModel;
use Illuminate\Http\Request;

class CustomerClass extends AdminClass implements ListInterface
{
    public function index()
    {
        $orderBy = [
            'id' => 'desc',
        ];

        $where = [
        ];

        $other = [
            'orderBy' => $orderBy,
            'where' => $where,
        ];

        $result = parent::list_page('customer', $other);

        return $result;
    }

    public function show($id)
    {
    }

    public function create()
    {
        $model = new CustomerModel();

        $switch = $model->switch;

        return $switch;
    }

    public function store(Request $request)
    {
        $model = new CustomerModel();
        $model->young_nickname = $request->post('nickname');
        $model->young_text = $request->post('text');

        //反馈前台操作结果
        if (!$model->save()) parent::error_json('请重试', '000');
    }

    public function edit($id)
    {
        $self = CustomerModel::whereId($id)->first();

        return parent::delete_prefix($self->toArray());
    }

    public function update($id, Request $request)
    {
        $model = CustomerModel::whereId($id)->first();
        $model->young_nickname = $request->post('nickname');
        $model->young_text = $request->post('text');

        //反馈前台操作结果
        if (!$model->save()) parent::error_json('请重试', '000');
    }

    public function destroy($id)
    {
        CustomerModel::destroy($id);
    }

    public function validator_store(Request $request)
    {
        $model = new CustomerModel();
        $switch = $model->switch;

        $term = [
            'nickname|昵称' => 'required|between:2,12|string',
            'text|联系方式' => 'required|string|max:20',
            'switch|分配开关' => 'required|in:' . implode(',', array_keys($switch)),
        ];

        parent::validators_json($request->all(), $term);
    }

    public function validator_update($id, Request $request)
    {
        $model = new CustomerModel();
        $switch = $model->switch;

        $term = [
            'id' => 'required|exists:customer_models,id',
            'nickname|昵称' => 'required|between:2,12|string',
            'text|联系方式' => 'required|string|max:20',
            'switch|分配开关' => 'required|in:' . implode(',', array_keys($switch)),
        ];

        $request->request->add(['id' => $id]);

        parent::validators_json($request->all(), $term);
    }

    public function validator_delete($id)
    {
        $model = new MemberModel();
        $test = $model->whereIn('young_customer', $id)->first();

        if (!is_null($test)) parent::error_json('无法删除已经上任的客服');
    }
}