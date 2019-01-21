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

    public function password(Request $request)
    {
        $this->classes->validator_password($request);

        $this->classes->password($request);

        return parent::success();
    }

    public function team(Request $request)
    {
        $member = $this->classes->get_member();

        $id = $request->get('id') ?? $member['uid'];

        $result = $this->classes->team($id);

        $result['member'] = $this->classes->read($id);

        return parent::success($result);
    }

    public function tree($uid)
    {
        $result = $this->classes->team($uid,1);

        return parent::success($result);
    }
}
