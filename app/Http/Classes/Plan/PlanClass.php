<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/24
 * Time: 下午2:46
 */

namespace App\Http\Classes\Plan;

use App\Http\Classes\Set\SetClass;
use App\Http\Traits\ModelTrait;
use App\Http\Traits\TimeTrait;

class PlanClass
{
    use TimeTrait, ModelTrait;

    public $set;

    public function __construct()
    {
        $set = new SetClass();
        $this->set = $set->index();
    }
}