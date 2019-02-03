<?php

namespace App\Http\Controllers\Admin\Bill;


use App\Http\Classes\Admin\Bill\BillClass;
use App\Http\Controllers\Admin\AdminController;

class BillController extends AdminController
{
    public $class;
    protected $view_dir = 'Bill.';

    public function __construct()
    {
        $this->class = new BillClass();
    }

    public function index()
    {
        $result = $this->class->all_bill();

        return parent::views('bill', $result);
    }

    public function getOne()
    {
        $this->class->time_type_2();

        switch (input('one')) {
            case 'order_number':
                $result = $this->class->order_number();
                break;
            case 'order_total':
                $result = $this->class->order_total();
                break;
            case 'express_number':
                $result = $this->class->express_number();
                break;
            case 'express_total':
                $result = $this->class->express_total();
                break;
            case 'goods_number':
                $result = $this->class->goods_number();
                break;
            case 'goods_total':
                $result = $this->class->goods_total();
                break;
            case 'new_member':
                $result = $this->class->new_member();
                break;
            case 'buy_grade_number':
                $result = $this->class->buy_grade_number();
                break;
            case 'buy_grade_total':
                $result = $this->class->buy_grade_total();
                break;
            default:
                $result = $this->class->recharge();
                break;
        }

        $a = [
            'status' => 'success',
            'message' => $result
        ];

        return json($a);
    }
}
