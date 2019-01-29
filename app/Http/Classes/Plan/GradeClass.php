<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/27
 * Time: 下午5:35
 */

namespace App\Http\Classes\Plan;

use App\Models\Member\MemberModel;

class GradeClass extends PlanClass
{
    public function __construct()
    {
        parent::__construct();

        //时间节点
        $days = $this->set['typeOld'];
        $date = date('Y-m-d H:i:s', strtotime('-' . $days . ' day'));

        $model = new MemberModel();
        $model->where('created_at','<=',$date)->update(['young_grade' => '20','young_grade_time' => DATE]);
    }


}