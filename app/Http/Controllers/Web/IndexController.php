<?php

namespace App\Http\Controllers\Web;

use App\Http\Classes\Index\IndexClass;
use App\Http\Classes\Index\Login\ApiLoginClass;
use App\Models\Member\MemberModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends WebController
{
    protected $view_dir = 'Index.';

    //框架首页
    public function index()
    {
        $class = new ApiLoginClass();

        $member = $class->get_member();

        $customer = $class->customer(empty($member['special_customer']) ? $member['customer'] : $member['special_customer']);

        $result = [
            'member' => $member,
            'customer' => $customer,
        ];

        return parent::views('index', $result);
    }

    //个人资料
    public function self()
    {
        $class = new ApiLoginClass();

        $member = $class->get_member();

        $model = new MemberModel();

        $result = [
            'member' => $member,
            'contrast' => array_merge($model->arrays(), $class->contrast()),
        ];

        return parent::views('personal', $result);
    }

    //修改密码
    public function password()
    {
        return parent::views('mima');
    }
}
