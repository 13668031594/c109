<?php

namespace App\Http\Controllers\Api\Login;

use App\Http\Classes\Index\Login\ApiLoginClass;
use App\Http\Classes\Index\Login\PromptClass;
use App\Http\Classes\Index\Message\MessageClass;
use App\Http\Classes\Set\SetClass;
use App\Http\Controllers\Api\ApiController;
use App\Models\Member\MemberModel;
use App\Models\Message\MessageModel;
use Illuminate\Http\Request;

class LoginController extends ApiController
{
    private $class;

    public function __construct()
    {
        $this->class = new ApiLoginClass();
    }

    /**
     * 后台验证码获取路由
     *
     * @return string
     */
    public function captcha()
    {
        //失败次数
        $fails_times = $this->class->fails_times();

        //验证码
        $captcha = ($fails_times >= 3) ? $this->class->captcha() : null;

        //结果集
        $result = [
            'fails_times' => $fails_times,
            'captcha' => $captcha,
        ];

        //验证码图片
        return parent::success($result);
    }

    /**
     * 管理员登录入口,返回令牌
     *
     * @param Request $request
     * @return string
     */
    public function login(Request $request)
    {
        $this->class->validator_time();

        if (!is_null($request->refresh_token)) {

            //使用刷新令牌获取新的令牌
            $result = $this->class->refresh_token_login($request);
        } else {

            //使用账号密码获取新的令牌
            $result = $this->class->account_number_login($request);
        }

        //清空失败次数
        $this->class->fails_add(-1);

        $result['set'] = $this->class->set();

        $result['contrast'] = array_merge($result['contrast'], $this->class->contrast());

        $result['customer'] = $this->class->customer(empty($result['member']['special_customer']) ? $result['member']['customer'] : $result['member']['special_customer']);

        $result['number'] = MessageModel::whereYoungStatus(10)->where('uid', '=', $result['member']['uid'])->count();

        //返回状态码
        return parent::success($result);
    }

    public function logout()
    {
        $this->class->logout();

        return parent::success();
    }

    public function get_member()
    {
        $member = $this->class->get_member();

        $member = $this->class->referee($member);

        $model = new MemberModel();

        $result = [
            'member' => $member,
            'set' => $this->class->set(),
            'contrast' => $model->arrays(),
            'customer' => $this->class->customer(empty($member['special_customer']) ? $member['customer'] : $member['special_customer'])
        ];

        $result['contrast'] = array_merge($result['contrast'], $this->class->contrast());

        return parent::success($result);
    }

    public function version()
    {
        $version = $this->class->version();

        return parent::success(['version' => $version]);
    }

    public function get_wallet()
    {
        $member = $this->class->get_member();

        $result = [
            'balance' => $member['balance'],
            'balance_all' => $member['balance_all'],
            'poundage' => $member['poundage'],
            'poundage_all' => $member['poundage_all'],
            'gxd' => $member['gxd'],
            'gxd_all' => $member['gxd_all'],
            'reward' => $member['reward'],
            'reward_all' => $member['reward_all'],
            'incite' => $member['incite'],
            'incite_all' => $member['incite_all'],
        ];

        return parent::success($result);
    }

    public function prompt($keyword)
    {
        $class = new PromptClass();

        $content = $class->prompt($keyword);

        $result = [
            'text' => $content
        ];

        return parent::success($result);
    }
}
