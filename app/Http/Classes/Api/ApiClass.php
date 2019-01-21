<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/21
 * Time: 下午2:10
 */

namespace App\Http\Classes\Api;

use App\Http\Classes\Classes;

class ApiClass extends Classes
{
    private $member = null;

    //获取管理员信息
    public function get_member()
    {
        if (is_null($this->member)) {

            $member = auth('api')->user();

            $this->member = parent::delete_prefix($member->toArray());
        }

        return $this->member;
    }
}