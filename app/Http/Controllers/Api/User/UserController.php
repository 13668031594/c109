<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Classes\Index\User\UserClass;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    private $classes;

    public function __construct()
    {
        $this->classes = new UserClass();
    }

    //修改密码
    public function password(Request $request)
    {
        $this->classes->validator_password($request);

        $this->classes->password($request);

        return parent::success();
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
}
