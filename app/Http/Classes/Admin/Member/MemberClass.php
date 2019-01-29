<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/18
 * Time: 下午4:12
 */

namespace App\Http\Classes\Member;


use App\Http\Classes\Admin\AdminClass;
use App\Http\Classes\ListInterface;
use App\Models\Member\MemberAccountModel;
use App\Models\Member\MemberActModel;
use App\Models\Member\MemberModel;
use App\Models\Member\MemberRecordModel;
use App\Models\Member\MemberWalletModel;
use Illuminate\Http\Request;

class MemberClass extends AdminClass implements ListInterface
{
    public function index()
    {
        $orderBy = [
            'uid' => 'desc',
        ];

        $where = [

        ];

        $other = [
            'orderBy' => $orderBy,
            'where' => $where,
        ];

        $result = parent::list_page('member', $other);

        foreach ($result['message'] as &$v) $v['id'] = $v['uid'];

        return $result;
    }

    public function show($id)
    {
        // TODO: Implement show() method.
    }

    public function create()
    {
        $model = new MemberModel();

        $result = $model->arrays();

        $bank = self::banks();

        $result['bank'] = $bank;

        return $result;
    }

    public function store(Request $request)
    {
        \DB::beginTransaction();

        $model = new MemberModel();

        //添加客服信息
        $model = $model->rand_customer($model);
        //添加银行卡信息
        $model = $model->change_bank($model, $request);
        //添加推荐人信息
        $model = $model->referee($model, $request->post('referee'));
        //添加基础信息
        $model->young_account = 'hold';
        $model->young_phone = $request->post('phone');
        $model->young_email = $request->post('email');
        $model->password = \Hash::make($request->post('password'));
//        $model->young_pay_pass = \Hash::make($request->post('pay_pass'));
        $model->young_pay_pass = \Hash::make($request->post('password'));
        $model->young_nickname = $request->post('nickname');
        $model->young_status = $request->post('status');
        $model->young_type = $request->post('type');
        $model->young_mode = $request->post('mode');
        $model->young_grade = $request->post('grade');
        $model->save();
        //添加账号信息
        $model->new_account($model);

        \DB::commit();
    }

    public function edit($id)
    {
        $model = MemberModel::whereUid($id)->first();

        return parent::delete_prefix($model->toArray());
    }

    public function update($id, Request $request)
    {
        \DB::beginTransaction();

        $model = MemberModel::whereUid($id)->first();

        //添加银行卡信息
        $model = $model->change_bank($model, $request);
        //添加基础信息
        $model->young_phone = $request->post('phone');
        $model->young_email = $request->post('email');
        if ($request->post('password') != 'sba___duia') $model->password = \Hash::make($request->post('password'));
//        if ($request->post('pay_pass') != 'sba___duia') $model->young_pay_pass = \Hash::make($request->post('pay_pass'));
        $model->young_nickname = $request->post('nickname');
        if ($request->post('status') != $model->young_status) {

            $model->young_status = $request->post('status');
            $model->young_status_time = DATE;
        }
        if ($request->post('type') != $model->young_type) {

            $model->young_type = $request->post('type');
            $model->young_type_time = DATE;
        }
        if ($request->post('mode') != $model->young_mode) {

            $model->young_mode = $request->post('mode');
            $model->young_mode_time = DATE;
        }
        if ($request->post('grade') != $model->young_grade) {

            $model->young_grade = $request->post('grade');
            $model->young_grade_time = DATE;
        }
        $model->save();

        $model->referee_nickname($model);

        \DB::commit();
    }

    public function destroy($id)
    {
        MemberModel::destroy($id);

        $account = new MemberAccountModel();
        $account->whereIn('uid', $id)->update(['uid' => null]);
    }

    public function validator_store(Request $request)
    {
        $model = new MemberModel();
        $arrays = $model->arrays();

        $term = [
            'referee|推荐号' => 'nullable|exists:member_models,young_account',
            'phone|手机号' => 'required|string|regex:/^1[3456789]\d{9}$/|unique:member_models,young_phone',
            'email|邮箱' => 'required|string|max:30|regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/|unique:member_models,young_email',
            'nickname|昵称' => 'required|string|between:1,10',
            'password|密码' => 'required|string|between:6,24',
//            'pay_pass|支付密码' => 'required|string|between:6,24',
            'bank_id|收款银行' => 'nullable|exists:bank_models,id',
            'bank_address|支行' => 'nullable|max:30',
            'bank_man|收款人' => 'nullable|max:30',
            'bank_no|收款账号' => 'nullable|max:30',
            'alipay|支付宝' => 'nullable|max:30',
            'note|备注' => 'nullable|max:40',
            'status|状态' => 'required|in:' . implode(',', array_keys($arrays['status'])),
            'mode|排单模式' => 'required|in:' . implode(',', array_keys($arrays['mode'])),
            'type|收益模式' => 'required|in:' . implode(',', array_keys($arrays['type'])),
            'grade|身份' => 'required|in:' . implode(',', array_keys($arrays['grade'])),
        ];

        parent::validators_json($request->post(), $term);
    }

    public function validator_update($id, Request $request)
    {
        $model = new MemberModel();
        $arrays = $model->arrays();

        $term = [
            'phone|手机号' => 'required|string|regex:/^1[3456789]\d{9}$/|unique:member_models,young_phone,' . $id . ',uid',
            'email|邮箱' => 'required|string|max:30|regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/|unique:member_models,young_email,' . $id . ',uid',
            'password|密码' => 'required|string|between:6,24',
//            'pay_pass|支付密码' => 'required|string|between:6,24',
            'bank_id|收款银行' => 'nullable|exists:bank_models,id',
            'bank_address|支行' => 'nullable|max:30',
            'bank_man|收款人' => 'nullable|max:30',
            'bank_no|收款账号' => 'nullable|max:30',
            'alipay|支付宝' => 'nullable|max:30',
            'note|备注' => 'nullable|max:40',
            'status|状态' => 'required|in:' . implode(',', array_keys($arrays['status'])),
            'mode|排单模式' => 'required|in:' . implode(',', array_keys($arrays['mode'])),
            'type|收益模式' => 'required|in:' . implode(',', array_keys($arrays['type'])),
            'grade|身份' => 'required|in:' . implode(',', array_keys($arrays['grade'])),
        ];

        parent::validators_json($request->post(), $term);
    }

    public function validator_delete($id)
    {
        $model = new MemberModel();
        $test = $model->where('young_status', '<>', 40)->whereIn('uid', $id)->first();
        if (!is_null($test)) parent::error_json('只能删除封停状态的会员');
    }

    public function banks()
    {
        $other = [
            'orderBy' => [
                'young_sort' => 'asc'
            ]
        ];

        return parent::list_all('bank', $other);
    }

    //激活会员
    public function act($uid)
    {
        $member = MemberModel::whereUid($uid)->first();

        if (is_null($member)) exit('会员不存在');

        $member->young_act = 30;
        $member->young_act_from = 30;
        $member->young_act_time = DATE;
        $member->save();

        $wallet = new MemberRecordModel();
        $wallet->store_record($member, 10, '管理员激活了您的账号');

        //作废这个会员之前所有的激活记录
        MemberActModel::whereUid($uid)->update(['young_status' => '40']);
    }

    //记录数据
    public function record_table(Request $request)
    {
        $where = [];

        $where[] = ['uid', '=', $request->get('id')];

        $startTime = $request->get('startTime');
        $endTime = $request->get('endTime');
        $type = $request->get('type');

        if (!empty($startTime)) {
            $where[] = ['created_at', '>=', $startTime];
        }
        if (!empty($endTime)) {
            $where[] = ['created_at', '<', $endTime];
        }
        if (!empty($type)) {
            $where[] = ['young_type', '=', $type];
        }

        return parent::list_page('member_record', ['where' => $where]);
    }

    public function record_delete($ids)
    {
        MemberRecordModel::destroy($ids);
    }
}