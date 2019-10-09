<?php

namespace App\Http\Controllers\Web;

use App\Http\Classes\Index\IndexClass;
use App\Http\Classes\Index\Trad\TradClass;
use App\Models\Trad\TradModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MarketController extends WebController
{
    protected $view_dir = 'Market.';

    public function index()
    {
        $class = new IndexClass();

        return parent::views('market', ['set' => $class->set]);
    }

    public function trad_index()
    {
        $index = self::trad();

        return parent::tables($index);
    }

    public function trad_sell()
    {
        $index = self::trad('1');


        return parent::tables($index);
    }

    public function trad_buy()
    {
        $index = self::trad('0');

        return parent::tables($index);
    }

    private function trad($type = null)
    {
        \request()->request->add(['type' => $type]);

        $class = new TradClass();

        $index = $class->index();

        $status = new TradModel();
        $status = $status->status;

        foreach ($index['message'] as &$v) {

            $v['status_name'] = $status[$v['status']];
            $v['amount'] = number_format($v['amount'], 2, '.', '');
            $v['details'] = '<a href="/trad_details?id=' . $v['id'] . '">查看详情</a>';
        }

        return $index;
    }

    public function sell()
    {

        return parent::views('popup4');
    }

    public function details()
    {
        $class = new TradClass();

        $status = new TradModel();
        $status = $status->status;

        $result = [
            'order' => $class->show(\request()->get('id')),
            'status' => $status,
            'member' => $class->get_member(),
        ];

        $result['order']['url'] = empty($result['order']['pay']) ? '' : 'http://' . \request()->getHost() . $result['order']['pay'];

        return parent::views('details', $result);
    }
}
