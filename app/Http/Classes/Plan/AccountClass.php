<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/27
 * Time: 下午5:35
 */

namespace App\Http\Classes\Plan;

use App\Models\Member\MemberModel;
use App\Models\Member\MemberWalletModel;
use App\Models\Order\MatchOrderModel;
use function GuzzleHttp\Psr7\str;

class AccountClass extends PlanClass
{
    public function __construct()
    {
        parent::__construct();

        //满足注册不排单封号的
        $reg_ids = self::reg_ids();

        //满足后台激活不排单封号的
        $act_ids = self::act_ids();

        //满足防撞长时间不排单的
        $mode_10_ids = self::mode_10_ids();

        //满足未防撞长时间不排单的
        $mode_20_ids = self::mode_20_ids();

        //超时未付款封号
        $not_pay_ids = self::not_pay();

        //所有id
        $stop_ids = array_merge($reg_ids, $act_ids, $mode_10_ids, $mode_20_ids, $not_pay_ids);

        //没有需要封号的
        if (count($stop_ids) <= 0) return;

        //去除重复的
        $stop_ids = array_unique($stop_ids);

        $date = date('Y-m-d H:i:s', strtotime('-1 day'));

        //修改状态
        $model = new MemberModel();
        /*$model->whereIn('uid', $stop_ids)->where(function ($query) use ($date) {

            $query->where('young_status_time', '<', $date)->orWhere('young_status_time', '=', null);
        })->update(['young_status' => '30', 'young_status_time' => DATE]);*/
        $members = $model->whereIn('uid', $stop_ids)->where(function ($query) use ($date) {

            $query->where('young_status_time', '<', $date)->orWhere('young_status_time', '=', null);
        })->get();

        $mr = new MemberWalletModel();
        foreach ($members as $v) {

            //最后一次封停扣除手续费
            $last_end = $mr->where('uid', '=', $v->uid)
                ->where('young_type', '=', '22')
                ->orderBy('created_at', 'desc')
                ->first();

            $where = [
                ['young_type', '=', 21],
            ];

            //时间筛选
            if (!is_null($last_end)) {

                $where[] = ['created_at', '>', $last_end->created_at];
            }

            $diff = $mr->where('uid', '=', $v->uid)
                ->where($where)
                ->sum('young_poundage');

            if ($diff > 0) {

                $v->young_poundage -= $diff;

                $change = ['poundage' => (0 - $diff)];
                $record = '因账号封停，扣除累计赠送的『' . $this->set['walletPoundage'] . '』' . $diff;
                $mr->store_record($v, $change, 22, $record);
            };
            $v->young_status = '30';
            $v->young_status_time = DATE;
            $v->save();
        }
    }

    //寻找自主注册，且打到封号标准的会员
    private function reg_ids()
    {
        if ($this->set['deleteIndexRegSwitch'] == 'off') return [];

        if (empty($this->set['deleteIndexRegTime'])) $date = DATE;
        else $date = date('Y-m-d H:i:s', strtotime('-' . $this->set['deleteIndexRegTime'] . ' day'));

        $model = new MemberModel();
        $ids = $model->where('created_at', '<', $date)
            ->where('young_first_buy_time', '=', null)
            ->where('young_status', '<>', '30')
            ->get(['uid'])
            ->pluck('uid')
            ->toArray();

        return $ids;
    }

    //后台激活，未排单的
    private function act_ids()
    {
        if ($this->set['deleteAdminActSwitch'] == 'off') return [];

        if (empty($this->set['deleteAdminActTime'])) $date = DATE;
        else $date = date('Y-m-d H:i:s', strtotime('-' . $this->set['deleteAdminActTime'] . ' day'));

        $model = new MemberModel();
        $ids = $model->where('young_act_time', '<', $date)
            ->where('young_first_buy_time', '=', null)
            ->where('young_status', '<>', '30')
            ->where('young_act_from', '=', '30')
            ->get(['uid'])
            ->pluck('uid')
            ->toArray();

        return $ids;
    }

    //防撞
    private function mode_10_ids()
    {
        if (empty($this->set['deleteType0'])) $date = DATE;
        else $date = date('Y-m-d H:i:s', strtotime('-' . $this->set['deleteType0'] . ' day'));

        $sql = "SELECT m.uid FROM young_member_models AS m,young_buy_order_models AS b 
WHERE m.uid = b.uid 
AND m.young_last_buy_time = b.created_at 
AND b.young_abn = 10 
AND b.young_status >= 70 
AND m.young_last_buy_time < '{$date}' 
AND m.young_status <> 30 
AND m.young_mode = 10";

        $result = \DB::select($sql);

        $ids = array_pluck($result, 'uid');

        return $ids;
    }

    //未防撞
    private function mode_20_ids()
    {
        if (empty($this->set['deleteType1'])) $date = DATE;
        else $date = date('Y-m-d H:i:s', strtotime('-' . $this->set['deleteType1'] . ' day'));

        /*$model = new MemberModel();
        $ids = $model->where('young_last_buy_time', '<', $date)
            ->where('young_status', '<>', '30')
            ->where('young_mode', '=', '20')
            ->get(['uid'])
            ->pluck('uid')
            ->toArray();*/

        $sql = "SELECT m.uid FROM young_member_models AS m,young_buy_order_models AS b 
WHERE m.uid = b.uid 
AND m.young_last_buy_time = b.created_at 
AND b.young_abn = 10 
AND b.young_status >= 40 
AND m.young_last_buy_time < '{$date}' 
AND m.young_status <> 30 
AND m.young_mode = 20";

        $result = \DB::select($sql);

        $ids = array_pluck($result, 'uid');

        return $ids;
    }

    //超时未付款
    public function not_pay()
    {
        $end = parent::set_time($this->set['payEnd']);

        if (time() < $end) return [];

        $date = date('Y-m-d 00:00:00');

//        $update = date('Y-m-d H:i:s', strtotime('-1 hours'));

        $match = new MatchOrderModel();
        return $match->where('created_at', '<', $date)
            ->where('young_abn', '=', '10')
            ->where('young_status', '=', '10')
//            ->where('updated_at', '<', $update)
            ->get(['young_buy_uid'])
            ->pluck('young_buy_uid')
            ->toArray();
    }
}