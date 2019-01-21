<?php

namespace App\Http\Controllers\Admin\Login;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Traits\FwbTrait;
use Illuminate\Http\Request;

class FwbController extends AdminController
{
    use FwbTrait;

    public function images(Request $request)
    {
        $src = $this->images_fwb($request);

        if (!is_array($src)) {

            $result = [
                'code' => '1',
                'msg' => $src,
                'data' => [
                    'src' => '',
                    'total' => ''
                ]
            ];
        } else {

            $result = [
                'code' => '0',
                'msg' => '',
                'data' => $src
            ];
        }

        return response()->json($result);
    }
}
