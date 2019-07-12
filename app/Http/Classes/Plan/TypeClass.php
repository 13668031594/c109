<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/27
 * Time: 下午5:35
 */

namespace App\Http\Classes\Plan;

use App\Models\Member\MemberModel;
use App\Models\Member\MemberRecordModel;

class TypeClass extends PlanClass
{
    public function __construct()
    {
        parent::__construct();

        $this->keyword = 'typeChange';

        if (parent::test_plan()) return;

        //时间节点
        $date = parent::return_date($this->set['type10']);

        $members = MemberModel::whereYoungType(10)->where('created_at', '<=', $date)->get();

        foreach ($members as $v) {

            $child = \DB::table('buy_order_models as b')
                ->leftJoin('member_models as u', 'b.uid', '=', 'u.uid')
                ->where('u.young_referee_id', '=', $v->uid)
                ->where('u.young_formal', '=', '20')
                ->where('b.young_total', '>=', $this->set['type01'])
                ->get(['b.*'])
                ->groupBy('uid')
                ->count();

            $child_number = 30 * $child;
            if ($child_number > 0) {

                $test = strtotime("+{$child_number} day", strtotime($v->created_at));
                if ($test > strtotime($date)) continue;
            }

            $v->young_type = 20;
            $v->young_type_time = DATE;
            $v->save();

            $record = new MemberRecordModel();
            $record->store_record($v, 20, '因长时间未推荐会员，收益状态转为静态');
        }

//        $date = date('Y-m-d H:i:s');
        //不用修改为静态的人
//        $member = new MemberModel();
//        $member = $member->where('young_formal_time', '>=', $date)->get(['young_referee_id'])->pluck('young_referee_id')->toArray();

        //不用被修改为静态的人
//        $member = array_unique($member);

        //老会员，动态的，不在排除范围内的，修改为静态
        /*MemberModel::whereYoungGrade('20')
//            ->whereNotIn('uid', $member)
            ->where('young_type', '=', '10')
            ->where('young_formal_time', '<=', $date)
            ->update(['young_type' => '20', 'young_type_time' => DATE]);*/

        $record = '操作成功';
        parent::store_plan($record);
    }
}