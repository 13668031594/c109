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
use App\Models\Plan\PlanModel;

class PlanClass
{
    use TimeTrait, ModelTrait;

    public $set;
    protected $keyword = 'unknow';

    public function __construct()
    {
        $set = new SetClass();
        $this->set = $set->index();
    }

    protected function return_date($day)
    {
        $day = (int)$day;
        $day = $day - 1;

        if (empty($day) || ($day <= 0)) $date = date('Y-m-d 00:00:00');
        else $date = date('Y-m-d 00:00:00', strtotime('-' . $day . ' day'));

        return $date;
    }

    protected function test_plan()
    {
        //判断今天是否成功发放了激活码
        $test = new PlanModel();
        $test = $test->where('young_type', '=', $this->keyword)
            ->where('young_status', '=', '10')
            ->where('created_at', '>=', date('Y-m-d 00:00:00'))
            ->first();

        return $test;
    }

    //添加本次激活记录
    protected function store_plan($record, $status = 10)
    {
        $plan = new PlanModel();
        $plan->store_plan($this->keyword, $record, $status);
    }


}