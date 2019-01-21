<?php

namespace App\Http\Controllers\Admin;

use App\Http\Classes\Admin\Master\MasterPowerClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    protected $static = '/static/admin/';
    protected $view = 'Admin.';
    protected $view_dir = '';

    //渲染页面
    protected function views(string $url, array $param = [])
    {
        $url = $this->view . $this->view_dir . $url;//组合文件路径

        $param['static'] = $param['static'] ?? $this->static;//静态文件基础文件夹
        $param['powers'] = self::powers();

        return parent::views($url, $param);
    }

    //获取管理员的权限
    private function powers()
    {
        $master = auth('master')->user();

        if (is_null($master))return [];

        if ($master->mid == '1') return ['-1'];

        $power_class = new MasterPowerClass();

        return $power_class->get_storage_power($master->young_power_id);
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
}
