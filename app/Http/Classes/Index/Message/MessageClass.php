<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/3/2
 * Time: 下午3:11
 */

namespace App\Http\Classes\Index\Message;

use App\Http\Classes\Index\IndexClass;
use App\Http\Traits\MessageTrait;
use App\Models\Message\MessageModel;

class MessageClass extends IndexClass
{
    public function index()
    {
        $member = parent::get_member();

        $where = [
            ['uid', '=', $member['uid']],
        ];

        $type = \request()->get('type');

        if (!empty($type)) {

            $where[] = ['young_type', '=', $type];
        }

        $select = ['id','young_status','young_type','young_message','created_at'];

        $other = [
            'where' => $where,
            'orderBy' => [
                'young_status' => 'asc',
                'created_at' => 'desc',
            ],
            'select' => $select,
        ];

        $result = parent::list_page('message', $other);

        return $result;
    }

    public function read($id)
    {
        $member = parent::get_member();

        MessageModel::whereId($id)->where('uid', '=', $member['uid'])->update(['young_status' => '20']);
    }

    public function news()
    {
        $member = parent::get_member();

        return MessageModel::whereYoungStatus(10)->where('uid', '=', $member['uid'])->count();
    }
}