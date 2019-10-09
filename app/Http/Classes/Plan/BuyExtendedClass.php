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
use App\Models\Order\BuyOrderModel;
use App\Models\RestDayModel;

class BuyExtendedClass extends PlanClass
{
    public function __construct()
    {
        parent::__construct();

        $this->keyword = 'buyExtended';

        if (parent::test_plan()) return;

        $rest_day = new RestDayModel();
        $rest_day = $rest_day->where('young_begin', '<=', DATE)
            ->where('young_end', '>', DATE)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!is_null($rest_day)) self::rest_day($rest_day);
        else self::status();
    }

    /**
     * 因封号延长
     */
    public function rest_day(RestDayModel $restDayModel)
    {
        $sql = "SELECT * FROM young_buy_order_models WHERE young_in_over >= {date('Y-m-d 00:00:00')}";

        $order = \DB::select($sql);

        $record_model = new MemberRecordModel();

        foreach ($order as $v) {

            if (!is_null($v->young_in_over)) {

                $o = BuyOrderModel::find($v->id);
                $after = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($o->young_in_over)));
                $re = '订单号：' . $o->young_order . '，的订单，休息日：' . $restDayModel->young_name . '，收益完结时间推迟一天(' . $o->young_in_over . '->' . $after . ')';

                $o->young_in_over = $after;
                $o->save();

                $member = MemberModel::find($v->uid);
                $record_model->store_record($member, 40, $re, $o->young_order);
            }
        }

        $record = '共有' . count($order) . '个订单因休息日：' . $restDayModel->young_name . '被延长收益时间';

        parent::store_plan($record);
    }

    /**
     * 因封号延长
     */
    public function status()
    {
        $sql = "SELECT b.* FROM young_buy_order_models as b,young_member_models as m 
WHERE b.young_in_over >= {date('Y-m-d 00:00:00')} 
AND m.young_status <> 10
AND b.uid = m.uid 
";

        $order = \DB::select($sql);

        $record_model = new MemberRecordModel();

        foreach ($order as $v) {

            if (!is_null($v->young_in_over)) {

                $o = BuyOrderModel::find($v->id);
                $after = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($o->young_in_over)));
                $re = '订单号：' . $o->young_order . '，的订单，因账号异常，收益完结时间推迟一天(' . $o->young_in_over . '->' . $after . ')';

                $o->young_in_over = $after;
                $o->save();

                $member = MemberModel::find($v->uid);
                $record_model->store_record($member, 40, $re, $o->young_order);
            }
        }

        $record = '共有' . count($order) . '个订单因账号异常被延长收益时间';

        parent::store_plan($record);
    }
}