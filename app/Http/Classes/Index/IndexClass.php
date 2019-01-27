<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/21
 * Time: 下午2:10
 */

namespace App\Http\Classes\Index;

use App\Http\Classes\Classes;
use App\Http\Classes\Set\SetClass;
use App\Http\Traits\TimeTrait;

class IndexClass extends Classes
{
    use TimeTrait;

    private $member = null;
    public $set = null;

    public function __construct()
    {
        $class = new SetClass();
        $this->set = $class->index();
    }

    //获取管理员信息
    public function get_member()
    {
        if (is_null($this->member)) {

            $member = auth('api')->user() ?? auth('web')->user();

            $this->member = parent::delete_prefix($member->toArray());
        }

        return $this->member;
    }


}