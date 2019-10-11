<?php

namespace App\Http\Controllers\Web;

use App\Http\Classes\Index\Notice\NoticeClass;
use App\Http\Classes\Set\SetClass;
use App\Http\Controllers\Controller;

class WebController extends Controller
{
    protected $static = '/static/web/';
    protected $view = 'Web.';
    protected $view_dir = '';

    //渲染页面
    protected function views(string $url, array $param = [])
    {
        $url = $this->view . $this->view_dir . $url;//组合文件路径

        $param['static'] = $param['static'] ?? $this->static;//静态文件基础文件夹

        $param['set'] = self::set();

        return parent::views($url, $param);
    }

    //json方式返回成功
    protected function success($url = '', $message = '操作成功', $other = [])
    {
        $result = [
            'status' => 'success',
            'url' => $url,
            'message' => $message,
        ];

        return response()->json(array_merge($result, $other));
    }

    /**
     * 列表数据
     *
     * @param array $result
     * @param array $other
     * @return string
     */
    protected function tables($result = [], $other = [])
    {
        if (!empty($other)) $result = array_merge($result, $other);

        $result['status'] = 'success';

        return json_encode($result);
    }

    protected function set()
    {
        $set = new SetClass();
        return $set->index();
    }
}
