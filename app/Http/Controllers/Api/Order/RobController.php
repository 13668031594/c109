<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Classes\Index\Order\RobClass;
use App\Http\Controllers\Api\ApiController;
use App\Models\Order\RobModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RobController extends ApiController
{
    private $classes;

    public function __construct()
    {
        $this->classes = new RobClass();
    }

    public function index()
    {
        $result = $this->classes->index();

        return parent::success($result);
    }

    public function store()
    {
        $this->classes->store();

        return parent::success();
    }

    public function buy(Request $request)
    {
        $this->classes->validator_buy($request);

        \DB::beginTransaction();

        $this->classes->buy($request);

        \DB::commit();

        return parent::success();
    }
}
