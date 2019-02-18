<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/21
 * Time: 下午4:28
 */

namespace App\Http\Classes\Index\Team;

use App\Http\Classes\Index\IndexClass;
use App\Http\Classes\Set\SetClass;
use App\Models\Member\MemberActModel;
use App\Models\Member\MemberModel;
use App\Models\Member\MemberSmsModel;
use App\Models\Member\MemberWalletModel;
use Hamcrest\Core\Set;
use Illuminate\Http\Request;

class TeamClass extends IndexClass
{
    //团队，1级
    public function team($member_id)
    {
        //结果数组
        $result = [
            'number' => 0,
            'team' => [],
        ];

        $orderBy = [
            'young_status' => 'desc',
            'created_at' => 'asc',
        ];

        //获取下级信息
        $other = [
            'where' => [
                ['young_referee_id', '=', $member_id]
            ],
            'orderBy' => $orderBy,
            'select' => ['uid', 'young_nickname', 'young_status', 'young_hosting', 'young_phone', 'young_last_buy_time', 'created_at', 'young_act'],
        ];

        $team = parent::list_all('member', $other);

        //没有下级
        if (count($team) <= 0) return $result;

        $result['team'] = $team;
        $result['number'] = count($team);//下级总数

        return $result;
    }

    //读取会员信息
    public function read($uid)
    {
        $member = MemberModel::whereUid($uid)->first();

        return parent::delete_prefix($member->toArray());
    }

    //团队，所有
    public function child($member_id)
    {
        $member = parent::get_member();

        $number = new MemberModel();
        $number = $number->where('young_families', 'like', '%' . $member['uid'] . ',%')
            ->orWhere('young_referee_id', '=', $member['uid'])
            ->count();

        //结果数组
        $result = [
            'number' => $number,
            'team' => [],
        ];

        //获取下级信息
        $other = [
            'where' => [
                ['young_families', 'like', '%' . $member_id . '%']
            ],
            'orWhere' => [
                ['young_referee_id', '=', $member_id]
            ],
            'select' => ['uid', 'young_nickname', 'young_referee_id', 'young_status'],
        ];

        $team = parent::list_all('member', $other);

        //没有下级
        if (count($team) <= 0) return $result;

        //下级结果数组
        $fathers = [];

        foreach ($team as $v) {

            $fathers[$v['referee_id']][] = $v;
        }

        $result['team'] = self::get_tree($member_id, $fathers);

        return $result;
    }

    //下级信息格式组合
    public function get_tree($father_id, $team)
    {
        if (!isset($team[$father_id])) return [];

        $result = [];

        foreach ($team[$father_id] as $k => $v) {

            $result[$k]['uid'] = $v['uid'];
            $result[$k]['nickname'] = $v['nickname'];
            $result[$k]['status'] = $v['status'];
            $result[$k]['children'] = isset($team[$v['uid']]) ? '1' : '0';
        }

        return $result;
    }

    //抢激活
    public function act($uid)
    {
        //激活开关
        if ($this->set['accountActSwitch'] != 'on') parent::error_json('暂时无法激活账号');

        //抢激活时间
        if ((time() < parent::set_time($this->set['accountActStart'])) ||
            (time() > parent::set_time($this->set['accountActEnd']))
        ) parent::error_json('请在每天 ' . $this->set['accountActStart'] . ' 至 ' . $this->set['accountActEnd'] . ' 抢激活');

        //本人数据
        $self = parent::get_member();

        //激活会员数据
        $member = MemberModel::whereUid($uid)->first();

        //会员不存在，报错
        if (is_null($member)) parent::error_json('会员不存在');

        //会员已经激活，报错
        if ($member->young_act != '10') parent::error_json('请勿重复申请激活');

        //会员不是自己的下级，报错
        if ($member->young_referee_id != $self['uid']) parent::error_json('只能激活自己的下级');

        //关闭负债激活且激活手续费大于0，进行手续费余额判断
        if (($this->set['accountActPoundageNone'] == 'off') && ($this->set['accountActPoundage'] > 0)) {

            //获取今日抢激活数量
            $all_number = new MemberActModel();
            $all_number = $all_number->where('young_referee_id', '=', $self['uid'])->where('young_status', '=', '10')->count();

            //判断手续费是否足够支持全部激活
            if ($self['poundage'] < ($all_number * $this->set['accountActPoundage'])) parent::error_json($this->set['walletGxd'] . '不足');
        }

        //添加抢激活记录
        $model = new MemberActModel();
        $model->uid = $uid;
        $model->young_referee_id = $self['uid'];
        $model->save();

        //会员状态变更为激活中
        $member->young_act = '20';
        $member->save();

        return $member->young_act;
    }


}