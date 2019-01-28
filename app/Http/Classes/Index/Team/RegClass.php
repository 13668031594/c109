<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/21
 * Time: 下午4:28
 */

namespace App\Http\Classes\Index\Team;

use App\Http\Classes\Index\IndexClass;
use App\Http\Classes\Set\SetClass;
use App\Models\Member\MemberActModel;
use App\Models\Member\MemberModel;
use App\Models\Member\MemberSmsModel;
use App\Models\Member\MemberWalletModel;
use Hamcrest\Core\Set;
use Illuminate\Http\Request;

class RegClass extends IndexClass
{
    //获取银行列表
    public function banks()
    {
        $other = [
            'orderBy' => [
                'young_sort' => 'asc'
            ]
        ];

        return parent::list_all('bank', $other);
    }

    //发送验证码前验证
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
        if ($this->set['accountRegSwitch'] != 'on') parent::error_json('暂时无法注册账号');

        if ($this->set['accountRegGxd'] > 0) {

            $self = parent::get_member();

            if ($self['gxd'] < $this->set['accountRegGxd']) parent::error_json($this->set['walletGxd'] . '不足');
        }

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
        $model->young_mode = $this->set['accountModeDefault'];
        $model->save();
        //添加账号信息
        $end = $model->new_account($model);

        \DB::commit();

        return parent::delete_prefix($end->toArray());
    }

    //注册账号消耗贡献点
    public function reg_gxd()
    {
        //不扣贡献点
        if ($this->set['accountRegGxd'] <= 0) return;

        $self = parent::get_member();

        $member = MemberModel::whereUid($self['uid'])->first();
        $member->young_gxd -= $this->set['accountRegGxd'];
        $member->save();

        $change = [
            'gxd' => (0 - $this->set['accountRegGxd']),
        ];

        $record = '注册账号，消耗『' . $this->set['walletGxd'] . '』' . $this->set['accountRegGxd'];

        $wallet = new MemberWalletModel();
        $wallet->store_record($member, $change, '20', $record);
    }
}