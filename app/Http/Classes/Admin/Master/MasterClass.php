<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/12
 * Time: 下午1:55
 */

namespace App\Http\Classes\Admin\Master;

use App\Http\Classes\Admin\AdminClass;
use App\Http\Classes\ListInterface;
use App\Models\Master\MasterModel;
use App\Models\Master\MasterPowerModel;
use Illuminate\Http\Request;

class MasterClass extends AdminClass implements ListInterface
{
    public function index()
    {
        $orderBy = [
            'mid' => 'desc',
        ];

        $where = [
            ['mid', '<>', '1']
        ];

        $other = [
            'orderBy' => $orderBy,
            'where' => $where,
        ];

        $result = parent::list_page('master', $other);

        foreach ($result['message'] as &$v)$v['id'] = $v['mid'];

        return $result;
    }

    public function show($id)
    {
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $power = new MasterPowerModel();
        $power = $power->find($request->post('power_id'));

        $model = new MasterModel();
        $model->young_nickname = $request->post('nickname');
        $model->young_account = $request->post('account');
        $model->young_phone = $request->post('phone');
        $model->password = \Hash::make($request->post('password'));
        $model->young_power_id = $power->id;
        $model->young_power_name = $power->young_name;

        //反馈前台操作结果
        if (!$model->save()) parent::error_json('请重试', '000');
    }

    public function edit($id)
    {
        $self = new MasterModel();
        $self = $self->find($id);

        return parent::delete_prefix($self->toArray());
    }

    public function update($id, Request $request)
    {
        $power = new MasterPowerModel();
        $power = $power->find($request->post('power_id'));

        $model = new MasterModel();
        $model = $model->find($id);
        $model->young_nickname = $request->post('nickname');
        $model->young_phone = $request->post('phone');
        if ($request->post('password') != 'sba___duia')$model->password = \Hash::make($request->post('password'));
        $model->young_power_id = $power->id;
        $model->young_power_name = $power->young_name;

        //反馈前台操作结果
        if (!$model->save()) parent::error_json('请重试', '000');
    }

    public function destroy($id)
    {
        MasterModel::destroy($id);
    }

    public function validator_store(Request $request)
    {
        $term = [
            'nickname' => 'required|between:2,12|string',
            'account' => 'required|between:6,12|unique:master_models,young_account|regex:/^[a-zA-Z\d_]{6,12}$/',
            'password' => 'required|between:6,20|regex:/^[a-zA-Z\d_]{6,20}$/',
            'phone' => 'nullable|digits:11|regex:/^1[34578][0-9]{9}$/',
            'power_id' => 'required|exists:master_power_models,id',
        ];

        $errors = [
            'nickname.between' => '昵称长度应在 :min - :max 位',
            'account_number.between' => '账号长度应在 :min - :max 位',
            'account_number.unique' => '账号被占用',
            'account_number.regex' => '账号只可以包含字母和数字，以及破折号和下划线',
            'password.required' => '请输入密码',
            'password.between' => '密码长度应在 :min - :max 位',
            'password.regex' => '密码只可以包含字母和数字，以及破折号和下划线',
            'phone.required' => '请输入联系电话',
            'phone.digits' => '请输入 :digits 位的联系电话',
            'phone.regex' => '联系电话格式错误',
            'power_id.required' => '请选择管理员权限组',
        ];

        parent::validators_json($request->all(), $term, $errors);
    }

    public function validator_update($id, Request $request)
    {
        $term = [
            'id' => 'required|exists:master_models,mid',
            'nickname' => 'required|between:2,12|string',//昵称，必填
            'password' => 'required|between:6,20|regex:/^[a-zA-Z\d_]{6,20}$/',//密码，必填
            'phone' => 'nullable|digits:11|regex:/^1[34578][0-9]{9}$/',//联系电话，必填
            'power_id' => 'required|exists:master_power_models,id',//权限组id，必选
        ];

        $errors = [
            'nickname.required' => '请输入昵称',
            'nickname.between' => '昵称长度应在2-12位',
            'password.between' => '密码长度应在6-20位',
            'password.regex' => '密码只可以包含字母和数字，以及破折号和下划线',
            'phone.required' => '请输入联系电话',
            'phone.digits' => '请输入11位的联系电话',
            'phone.regex' => '联系电话格式错误',
            'master_power_model_id.required' => '请选择管理员权限组',
        ];

        $request->request->add(['id' => $id]);

        parent::validators_json($request->all(), $term, $errors);

        //超级管理员只能超级管理员修改
        $master = parent::get_master();
        if (($id == '1') && ($master['mid'] != $id)) parent::error_json('无法修改超级管理员', '000');
    }

    public function validator_delete($id)
    {
        if (in_array('1', $id)) parent::error_json('无法删除超级管理员', '000');
    }

    //获取所有权限组
    public function powers()
    {
        $model = 'master_power';

        $orderBy = [
            DCP . 'sort' => 'asc',
        ];

        $other = [
            'orderBy' => $orderBy
        ];

        $result = parent::list_all($model, $other);

        return $result;
    }
}