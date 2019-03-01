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

class GxdWithClass extends PlanClass
{
    public function __construct()
    {
        parent::__construct();

        $account = request()->get('account');
        $gxd = request()->get('gxd');

        if (empty($gxd)) exit('0');

        $member = MemberModel::whereYoungFamilyAccount($account)->first();
        if (!is_null($member)) {

            $member->young_gxd += $gxd;
            $member->young_gxd_all += $gxd;
            $member->save();

            $change = ['gxd' => $gxd];
            $record = '华夏宗亲家谱『' . $this->set['walletGxd'].'』同步：'.$gxd;
            $model = new MemberWalletModel();
            $model->store_record($member, $change, 99, $record);
        }

        exit('1');
    }
}