<?php

namespace App\Http\Controllers\Api\Trad;

use App\Http\Classes\Index\Trad\TradClass;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TradController extends ApiController
{
    private $classes;

    public function __construct()
    {
        $this->classes = new TradClass();
    }

    public function index()
    {
        $result = $this->classes->index();

        return parent::success($result);
    }

    //卖出
    public function sell(Request $request)
    {
        $this->classes->store($request);

        return parent::success();
    }

    //认购
    public function buy($id)
    {
        $this->classes->buy($id);

        return parent::success();
    }

    //支付
    public function pay($id, Request $request)
    {
        $this->classes->pay($id, $request);

        return parent::success();
    }

    //确认
    public function over($id)
    {
        $this->classes->over($id);

        return parent::success();
    }
}
