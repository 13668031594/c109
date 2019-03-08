<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/18
 * Time: 下午4:12
 */

namespace App\Http\Classes\Admin\Bill;

use App\Http\Classes\Admin\AdminClass;

class MatchSimuClass extends AdminClass
{
    public function index()
    {
        $where = [['young_type','=','match_simu']];

        $orderBy = [
            'id' => 'desc',
        ];

        $other = [
            'orderBy' => $orderBy,
            'where' => $where,
        ];

        $result = parent::list_page('plan', $other);

        return $result;
    }
}