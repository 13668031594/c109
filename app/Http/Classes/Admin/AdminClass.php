<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/11
 * Time: 下午3:03
 */

namespace App\Http\Classes\Admin;

use App\Exceptions\JsonException;
use App\Http\Classes\Classes;

class AdminClass extends Classes
{
    private $master = null;

    //获取管理员信息
    public function get_master()
    {
        if (is_null($this->master)) {

            $master = auth('master')->user();

            $this->master = parent::delete_prefix($master->toArray());
        }

        return $this->master;
    }
}