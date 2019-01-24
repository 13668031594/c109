<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/24
 * Time: 下午3:03
 */

namespace App\Http\Traits;


trait TimeTrait
{
    //生成配置中的时间格式
    protected function set_time($date)
    {
        return strtotime(date('Y-m-d '). $date . ':00');
    }
}