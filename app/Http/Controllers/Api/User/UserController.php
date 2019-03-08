<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Classes\Index\SmsClass;
use App\Http\Classes\Index\User\SignClass;
use App\Http\Classes\Index\User\UserClass;
use App\Http\Controllers\Api\ApiController;
use App\Models\Member\MemberWalletModel;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    private $classes;

    public function __construct()
    {
        $this->classes = new UserClass();
    }

    //修改密码短信
    public function sms()
    {
        $member = $this->classes->get_member();

        $class = new SmsClass();

        $end = $class->send($member['phone'], 'reset');

        //反馈
        return parent::success(['time' => $end]);
    }

    //修改密码
    public function password(Request $request)
    {
        //验证短信
        $this->classes->validator_phone($request);

        $this->classes->validator_password($request);

        $this->classes->password($request);

        return parent::success();
    }

    //修改下单模式
    public function mode()
    {
        $this->classes->mode();

        return parent::success();
    }

    //修改托管模式
    public function hosting()
    {
        $this->classes->hosting();

        return parent::success();
    }

    //修改自动买单模式
    public function auto()
    {
        $this->classes->auto();

        return parent::success();
    }

    //记录页面
    public function wallet()
    {
        $model = new MemberWalletModel();

        $type = $model->type;

        return parent::success(['type' => $type]);
    }

    //记录数据
    public function wallet_table(Request $request)
    {
        $member = $this->classes->get_member();

        $request->request->add(['id' => $member['uid']]);

        $result = $this->classes->record_table($request);

        return parent::success($result);
    }

    //绑定家谱账号
    public function family_binding(Request $request)
    {
        $this->classes->family_binding($request);

        return parent::success();
    }

    //领取每日红包
    public function sign()
    {
        //签到类
        $class = new SignClass();

        //判断是否在签到允许的时间内
        $class->validator_time();

        //判断今天是否签到
        $class->validator_today();

        //领取今日收益
        $in = $class->today_in();

        //反馈结果
        return parent::success(['number' => $in, 'message' => '可领收益：' . $in]);
    }

    public function signing()
    {
        //签到类
        $class = new SignClass();

        //判断是否在签到允许的时间内
        $class->validator_time();

        //判断今天是否签到
        $class->validator_today();

        //领取今日收益
        $in = $class->today_in();

        //添加今日签到记录
        $class->created_sign();

        //反馈结果
        return parent::success(['number' => $in, 'message' => '签到成功，领取收益：' . $in]);
    }
}
