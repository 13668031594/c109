<?php

namespace App\Http\Controllers\Api\Notice;

use App\Http\Classes\Index\Login\ApiLoginClass;
use App\Http\Classes\Index\Login\PromptClass;
use App\Http\Classes\Index\Message\MessageClass;
use App\Http\Classes\Index\Notice\NoticeClass;
use App\Http\Classes\Set\SetClass;
use App\Http\Controllers\Api\ApiController;
use App\Models\Member\MemberModel;
use App\Models\Message\MessageModel;
use Illuminate\Http\Request;

class NoticeController extends ApiController
{
    private $classes;

    public function __construct()
    {
        $this->classes = new NoticeClass();
    }

    public function index()
    {
        $result = $this->classes->index();

        return parent::success($result);
    }

    public function show($id)
    {
        $content = $this->classes->show($id);

        $result = [
            'text' => $content
        ];

        return parent::success($result);
    }
}
