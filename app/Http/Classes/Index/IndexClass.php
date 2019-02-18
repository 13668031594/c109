<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/21
 * Time: 下午2:10
 */

namespace App\Http\Classes\Index;

use App\Http\Classes\Classes;
use App\Http\Classes\Set\SetClass;
use App\Http\Traits\TimeTrait;
use Illuminate\Http\Request;

class IndexClass extends Classes
{
    use TimeTrait;

    private $member = null;
    public $set = null;

    public function __construct()
    {
        $class = new SetClass();
        $this->set = $class->index();
    }

    //获取管理员信息
    public function get_member()
    {
        if (is_null($this->member)) {

            $member = auth('api')->user() ?? auth('web')->user();

            $this->member = parent::delete_prefix($member->toArray());
        }

        return $this->member;
    }

    //记录数据
    public function record_table(Request $request)
    {
        $where = [];

        $where[] = ['uid', '=', $request->get('id')];

        $select = ['id', 'young_record as detail', 'young_type', 'created_at'];

        switch ($request->get('wallet')) {
            case '0':
                $where[] = ['young_balance', '<>', 0];
                $select[] = 'young_balance as amount';
                break;
            case '1':
                $where[] = ['young_poundage', '<>', 0];
                $select[] = 'young_poundage as amount';
                break;
            case '2':
                $where[] = ['young_reward', '<>', 0];
                $select[] = 'young_reward as amount';
                break;
            case '3':
                $where[] = ['young_gxd', '<>', 0];
                $select[] = 'young_gxd as amount';
                break;
            case '4':
                $where[] = ['young_incite', '<>', 0];
                $select[] = 'young_incite as amount';
                break;
            default:
                break;
        }

        $startTime = $request->get('startTime');
        $endTime = $request->get('endTime');
        $type = $request->get('type');

        if (!empty($startTime)) {
            $where[] = ['created_at', '>=', $startTime];
        }
        if (!empty($endTime)) {
            $where[] = ['created_at', '<', $endTime];
        }
        if (!empty($type)) {
            $where[] = ['young_type', '=', $type];
        }

        $orderBy = [
            'id' => 'desc'
        ];

        $other = [
            'where' => $where,
            'orderBy' => $orderBy,
            'select' => $select,
        ];

        return parent::list_page('member_wallet', $other);
    }
}