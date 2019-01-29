<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/27
 * Time: 下午5:35
 */

namespace App\Http\Classes\Plan;

use App\Models\Member\MemberModel;

class AccountClass extends PlanClass
{
    public function __construct()
    {
        parent::__construct();

        //满足注册不排单封号的
        $reg_ids = self::reg_ids();

        //满足后台激活不排单封号的
        $act_ids = self::act_ids();

        //所有id
        $stop_ids = array_merge($reg_ids, $act_ids);

        //没有需要封号的
        if (count($stop_ids) <= 0) return;

        //去除重复的
        $stop_ids = array_unique($stop_ids);

        //修改状态
        $model = new MemberModel();
        $model->whereIn('uid', $stop_ids)->update(['young_status' => '30', 'young_status_time' => DATE]);
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
}