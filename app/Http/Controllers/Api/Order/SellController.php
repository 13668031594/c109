<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Classes\Index\Order\PayClass;
use App\Http\Classes\Index\Order\SellClass;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellController extends ApiController
{
    private $classes;

    public function __construct()
    {
        $this->classes = new SellClass();
    }

    //购买订单列表
    public function index()
    {
        $result = $this->classes->index();

        return parent::success($result);
    }

    //购买订单详情
    public function show($id)
    {
        $match = $this->classes->match($id);

//        $record = $this->classes->record($id);

        $result = [
            'existAmount' => $this->classes->existAmount($id),
            'match' => $match,
//            'record' => $record,
        ];

        return parent::success($result);
    }

    //排单设置
    public function create()
    {
        $set = $this->classes->member_set();

        return parent::success($set);
    }

    public function store(Request $request)
    {
        $this->classes->validator_store($request);

        \DB::beginTransaction();

        $this->classes->store($request);

        \DB::commit();

        return parent::success();
    }

    public function confirm($id)
    {
        $class = new PayClass();

        $class->confirm($id);

        return parent::success();
    }

    public function abn($id)
    {
        $class = new PayClass();

        $class->abn($id);

        return parent::success();
    }
}
