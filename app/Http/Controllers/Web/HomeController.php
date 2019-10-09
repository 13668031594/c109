<?php

namespace App\Http\Controllers\Web;

use App\Http\Classes\Index\IndexClass;
use App\Http\Classes\Index\Notice\NoticeClass;
use App\Http\Classes\Index\Order\AllClass;
use App\Http\Classes\Index\Order\BuyClass;
use App\Http\Classes\Index\Order\SellClass;
use App\Models\Member\MemberModel;
use App\Models\Order\BuyOrderModel;
use App\Models\Order\MatchOrderModel;
use App\Models\Order\SellOrderModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends WebController
{
    protected $view_dir = 'Home.';

    public function index()
    {
        //公告
        $notice_class = new NoticeClass();
        $notice = $notice_class->index();

        //身份
        $member = $notice_class->get_member();
        $type = new MemberModel();
        $type = $type->type;

        //进行中的订单
        $class = new AllClass();
        $all = $class->match();
        $match = new MatchOrderModel();

        //下单参数
        $set = parent::set();
        $mode = $member['mode'] == '10' ? $set['goodsTop1'] : $set['goodsTop0'];
        $amount = $set['goodsTotal'];

        $result = [
            'notice' => $notice,
            'type' => $type,
            'member' => $member,
            'status' => $match->status,
            'all' => $all,
            'popup3' => self::popup3_re(),
            'amount' => $amount,
            'mode' => $mode,
            'cover' => $set['goodsCover'],
        ];

        return parent::views('homepage', $result);
    }

    public function popup()
    {
        $set = parent::set();

        $index = new IndexClass();

        $member = $index->get_member();

        $mode = $member['mode'] == '10' ? $set['goodsTop1'] : $set['goodsTop0'];
        $time = $member['mode'] == '10' ? $set['goodsType1'] : $set['goodsType0'];
        $inPro = $member['type'] == '20' ? $set['typePro0'] : $set['typePro1'];

        $result = [
            'member' => $member,
            'set' => $set,
            'mode' => $mode,
            'time' => $time,
            'inPro' => $inPro,
        ];
//dd($result);
        return parent::views('popup', $result);
    }

    public function buy_list()
    {
        $class = new BuyClass();

        $result = $class->buy_list();

        $re = [
            'count' => $result['total'],
            'message' => $result['message'],
        ];

        return parent::tables(['data' => $re]);
    }

    public function sell_list()
    {
        $class = new SellClass();

        $result = $class->sell_list();

        $re = [
            'count' => $result['total'],
            'message' => $result['message'],
        ];

        return parent::tables(['data' => $re]);
    }

    public function popup3()
    {
        $result = self::popup3_re();

        return parent::views('popup3', $result);
    }

    public function popup3_re()
    {
        $class = new BuyClass();

        $member = $class->get_member();

        $m = [
            'auto_buy' => $member['auto_buy'],
            'auto_number' => $member['auto_number'],
            'auto_time' => $member['auto_time'],
        ];

        $set = $class->auto_set();

        $list = ($member['auto_buy'] == '10') ? $class->auto_list($member['auto_number'], $member['auto_time']) : [];

//        $set['goodsTotal'] *= $member['auto_number'];

        $result = [
//            'set' => $set,
            'member' => $m,
            'list' => json_encode($list),
        ];

        return $result;
    }

    public function popup2()
    {
        $class = new IndexClass();

        $member = $class->get_member();

        $result = [
            'member' => $member,
        ];

        return parent::views('popup2',$result);
    }
}
