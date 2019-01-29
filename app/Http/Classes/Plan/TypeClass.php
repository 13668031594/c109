<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/27
 * Time: 下午5:35
 */

namespace App\Http\Classes\Plan;

use App\Models\Member\MemberModel;

class TypeClass extends PlanClass
{
    public function __construct()
    {
        parent::__construct();

        //时间节点
        $days = $this->set['type10'];
        $date = date('Y-m-d H:i:s', strtotime('-' . $days . ' day'));

        //不用修改为静态的人
        $member = new MemberModel();
        $member = $member->where('young_formal_time', '>=', $date)->get(['young_referee_id'])->pluck('young_referee_id')->toArray();

        //不用被修改为静态的人
        $member = array_unique($member);

        //老会员，动态的，不在排除范围内的，修改为静态
        MemberModel::whereYoungGrade('20')
            ->whereNotIn('uid', $member)
            ->where('young_type', '=', '10')
            ->update(['young_type' => '20', 'young_type_time' => DATE]);
    }
}