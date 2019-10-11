<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/2/11
 * Time: 下午3:23
 */

namespace App\Http\Classes\Index\Notice;

use App\Http\Classes\Index\IndexClass;
use App\Http\Traits\FwbTrait;
use App\Models\Notice\NoticeModel;

class NoticeClass extends IndexClass
{
    use FwbTrait;

    public function index()
    {
        $select = ['id', 'young_title', 'young_man', 'created_at'];

        $where = [
            ['young_status', '=', '10'],
        ];

        $orderBy = [
            'young_sort' => 'asc'
        ];

        $other = [
            'where' => $where,
            'orderBy' => $orderBy,
            'select' => $select,
        ];

        $result = parent::list_page('notice', $other);

        return $result;
    }

    public function show($id)
    {
        $notice = NoticeModel::whereId($id)->first();

        if (is_null($notice)) parent::error_json('没有内容');

        $content = $this->completion_location($notice->young_content);

        return $content;
    }

    public function web_show()
    {
        $notice = NoticeModel::whereId(request()->get('id'))->first();

        if (is_null($notice)) parent::error_json('没有内容');

        $notice = parent::delete_prefix($notice->toArray());

        $notice['content'] = $this->completion_location($notice['content']);

        return $notice;
    }
}