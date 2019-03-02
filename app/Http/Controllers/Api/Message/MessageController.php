<?php

namespace App\Http\Controllers\Api\Message;

use App\Http\Classes\Index\Message\MessageClass;
use App\Http\Controllers\Api\ApiController;

class MessageController extends ApiController
{
    private  $classes;

    public function __construct()
    {
        $this->classes = new MessageClass();
    }

    //消息列表
    public function index()
    {
        $result = $this->classes->index();

        return parent::success($result);
    }

    //读取消息
    public function read($id)
    {
        $this->classes->read($id);

        return parent::success();
    }

    //是否有新消息
    public function news()
    {
        $number = $this->classes->news();

        return parent::success(['number' => $number]);
    }
}
