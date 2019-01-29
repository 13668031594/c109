<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Classes\Index\SmsClass;
use App\Http\Classes\Index\User\UserClass;
use App\Http\Classes\Member\WalletClass;
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

    //注册短信
    public function sms()
    {
        $member = $this->classes->get_member();

        $class = new SmsClass();

        $end = $class->send($member['phone']);

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
}
