<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/27
 * Time: 下午3:26
 */

namespace App\Http\Classes\Index\Order;

use App\Http\Classes\Index\IndexClass;

class RobClass extends IndexClass
{
    //开始抢单
    public function store()
    {
        $member = parent::get_member();//会员参数


        $set = $this->set;//配置文件

        if ($set['buySwitch'] != 'on') parent::error_json('暂时无法抢单');//手动排单开关
    }
}