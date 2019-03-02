<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/2/2
 * Time: 下午2:35
 */

namespace App\Http\Traits;

use App\Models\Message\MessageModel;

trait MessageTrait
{
    /**
     * 保存系统消息
     *
     * @param $uid
     * @param $type
     * @param $message
     */
    public function sendMessage($uid, $type, $message)
    {
        $model = new MessageModel();
        $model->uid = $uid;
        $model->young_type = $type;
        $model->young_message = $message;
        $model->save();
    }
}