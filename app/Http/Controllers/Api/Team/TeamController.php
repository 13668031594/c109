<?php

namespace App\Http\Controllers\Api\Team;

use App\Http\Classes\Index\SmsClass;
use App\Http\Classes\Index\Team\HostingClass;
use App\Http\Classes\Index\Team\RegClass;
use App\Http\Classes\Index\Team\TeamClass;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;

class TeamController extends ApiController
{
    //查看下级
    public function team(Request $request)
    {
        $class = new TeamClass();

        $member = $class->get_member();

        $id = $request->get('id') ?? $member['uid'];

        $result = $class->team($id);

        $result['member'] = $class->read($id);

        return parent::success($result);
    }

    //下级展开
    public function tree($uid)
    {
        $class = new TeamClass();

        $result = $class->child($uid);

        return parent::success($result);
    }

    //申请激活
    public function act($uid)
    {
        $class = new TeamClass();

        $status = $class->act($uid);

        return parent::success(['status' => $status]);
    }

    public function banks()
    {
        $class = new RegClass();

        $banks = $class->banks();

        return parent::success(['banks' => $banks]);
    }


    //添加新的账号
    public function reg(Request $request)
    {
        $reg = new RegClass();

        //验证短信验证码
        $class = new SmsClass();
        $class->validator_phone($request);

        $reg->validator_reg($request);

        $member = $reg->reg($request);

        return parent::success(['member' => $member]);
    }

    //注册短信
    public function sms($phone)
    {
        $reg = new RegClass();

        $reg->validator_sms($phone);

        $class = new SmsClass();

        $end = $class->send($phone);

        //反馈
        return parent::success(['time' => $end]);
    }

    //切换到会员
    public function hosting(Request $request)
    {
        //初始化托管类
        $class = new HostingClass();

        //验证托管资格
        $member = $class->test($request);

        //删除同一个人的其他令牌
        $class->delete_token($member);

        //发放托管令牌
        $token = $class->access_token($member);

        //返回托管令牌
        return parent::success(['access_token' => $token]);

    }
}
