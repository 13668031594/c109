<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/2/2
 * Time: 下午2:35
 */

namespace App\Http\Traits;

trait GetuiTrait
{
    /**
     * 推送消息
     *
     * @param $cid
     * @param string $body
     * @param string $title
     */
    public function pushSms($cid, $body = "", $title = "你有一条新消息")
    {
        $template = "IGtNotificationTemplate";
        $data = "a";
        $config = array("type" => "HIGH", "title" => $title, "body" => $body, "logo" => "", "logourl" => "");
        $test = \Earnp\Getui\Getui::pushMessageToSingle($template, $config, $data, $cid);
    }
}