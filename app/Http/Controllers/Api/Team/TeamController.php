<?php

namespace App\Http\Controllers\Api\Team;

use App\Http\Classes\Index\SmsClass;
use App\Http\Classes\Index\Team\TeamClass;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamController extends AdminController
{
    private $classes;

    public function __construct()
    {
        $this->classes = new TeamClass();
    }

    public function banks()
    {
        $banks = $this->classes->banks();

        return parent::success(['banks' => $banks]);
    }

    //添加新的账号
    public function reg(Request $request)
    {
        //验证短信验证码
        $class = new SmsClass();
        $class->validator_phone($request);

        $this->classes->validator_reg($request);

        $member = $this->classes->reg($request);

        return parent::success(['member' => $member]);
    }


    //查看下级
    public function team(Request $request)
    {
        $member = $this->classes->get_member();

        $id = $request->get('id') ?? $member['uid'];

        $result = $this->classes->team($id);

        $result['member'] = $this->classes->read($id);

        return parent::success($result);
    }

    //下级展开
    public function tree($uid)
    {
        $result = $this->classes->team($uid, 1);

        return parent::success($result);
    }

    //注册短信
    public function sms($phone)
    {
        $this->classes->validator_sms($phone);

        $class = new SmsClass();

        $end = $class->send($phone);

        //反馈
        return parent::success(['time' => $end]);
    }
}
