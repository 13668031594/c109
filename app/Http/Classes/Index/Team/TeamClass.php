<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/21
 * Time: 下午4:28
 */

namespace App\Http\Classes\Index\Team;

use App\Http\Classes\Index\IndexClass;
use App\Models\Member\MemberModel;
use App\Models\Member\MemberSmsModel;
use Illuminate\Http\Request;

class TeamClass extends IndexClass
{
    //团队，1级
    public function team($member_id, $tree = false)
    {
        //结果数组
        $result = [
            'number' => 0,
            'team' => json_encode([]),
        ];

        //获取下级信息
        $other = [
            'where' => [
                ['young_families', 'like', '%' . $member_id . '%']
            ],
        ];
        $team = parent::list_all('member', $other);

        //没有下级
        if (count($team) <= 0) return $result;

        //下级结果数组
        $fathers = [];

        foreach ($team as $v) {

            $fathers[$v['referee_id']][] = $v;
        }

        $result['team'] = self::get_tree($member_id, $fathers, $tree);
        $result['number'] = count($result['team']);//下级总数

        return $result;
    }

    //读取会员信息
    public function read($uid)
    {
        $member = MemberModel::whereUid($uid)->first();

        return parent::delete_prefix($member->toArray());
    }

    //下级信息格式组合
    public function get_tree($father_id, $team, $tree)
    {
        if (!isset($team[$father_id])) return [];

        $result = [];

        foreach ($team[$father_id] as $k => $v) {

            $result[$k]['uid'] = $v['uid'];
            $result[$k]['nickname'] = $v['nickname'];
            $result[$k]['status'] = $v['status'];

            if (!$tree) {

                $result[$k]['hosting'] = $v['hosting'];
                $result[$k]['phone'] = $v['phone'];
                $result[$k]['last_buy_time'] = $v['last_buy_time'];
                $result[$k]['created_at'] = $v['created_at'];
            } else {

                $result[$k]['children'] = isset($team[$v['uid']]) ? '1' : '0';
            }
        }

        return $result;
    }

    //获取银行列表
    public function banks()
    {
        $other = [
            'orderBy' => [
                'sort' => 'asc'
            ]
        ];

        return parent::list_all('bank', $other);
    }

    /**
     * 发送验证码前验证
     *
     * @param $phone
     * @param $time
     */
    public function validator_sms($phone)
    {
        $term = [
            'phone|电话' => 'required|regex:/^1[34578][0-9]{9}$/|unique:member_models,young_phone',//联系电话，必填
        ];

        //参数判断
        parent::validators_json(['phone' => $phone], $term);
    }

    //注册验证
    public function validator_reg(Request $request)
    {
        $term = [
            'phone|手机号' => 'required|string|regex:/^1[3456789]\d{9}$/|unique:member_models,young_phone',
            'email|邮箱' => 'required|string|max:30|regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/|unique:member_models,young_email',
            'nickname|昵称' => 'required|string|between:1,10',
            'password|密码' => 'required|string|between:6,24',
            'bank_id|收款银行' => 'required|exists:bank_models,id',
            'bank_address|支行' => 'required|max:30',
            'bank_man|收款人' => 'required|max:30',
            'bank_no|收款账号' => 'required|max:30',
            'alipay|支付宝' => 'required|max:30',
            'note|备注' => 'nullable|max:40',
        ];

        parent::validators_json($request->post(), $term);
    }

    //注册账号
    public function reg(Request $request)
    {
        \DB::beginTransaction();

        $member = parent::get_member();

        $model = new MemberModel();

        //添加银行卡信息
        $model = $model->change_bank($model, $request);
        //添加推荐人信息
        $model = $model->referee($model, $member['account']);
        //添加基础信息
        $model->young_account = 'hold';
        $model->young_phone = $request->post('phone');
        $model->young_email = $request->post('email');
        $model->password = \Hash::make($request->post('password'));
//        $model->young_pay_pass = \Hash::make($request->post('pay_pass'));
        $model->young_pay_pass = \Hash::make($request->post('password'));
        $model->young_nickname = $request->post('nickname');
        $model->save();
        //添加账号信息
        $end = $model->new_account($model);

        \DB::commit();

        return parent::delete_prefix($end->toArray());
    }
}