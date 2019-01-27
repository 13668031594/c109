<?php

namespace App\Http\Controllers\Api\Login;

use App\Http\Classes\Index\Login\ApiLoginClass;
use App\Http\Classes\Set\SetClass;
use App\Http\Controllers\Api\ApiController;
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
        if (!is_null($request->refresh_token)) {

            //使用刷新令牌获取新的令牌
            $result = $this->class->refresh_token_login($request);
        } else {

            //使用账号密码获取新的令牌
            $result = $this->class->account_number_login($request);
        }

        //清空失败次数
        $this->class->fails_add(-1);

        $class = new SetClass();
        $result['set'] = $class->index();

        $result['contrast'] = $this->class->contrast();

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

        return parent::success(['member' => $member]);
    }
}
