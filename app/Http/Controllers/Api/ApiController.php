<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    //json方式返回成功
    protected function success($data = null, $message = '操作成功', $other = [])
    {
        $result = [
            'status' => 'success',
            'data' => $data,
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
