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

    public function sell(Request $request)
    {
        $this->classes->store($request);

        return parent::success();
    }

    public function buy($id)
    {
        $this->classes->buy($id);

        return parent::success();
    }
}
