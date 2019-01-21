<?php

namespace App\Vendor\ApiCaptcha;

use App\Http\Controllers\Controller;

class ApiCaptchaController extends Controller
{
    /**
     * get CAPTCHA
     *
     * @param ApiCaptchaService $captcha
     * @param string $config
     * @return \Intervention\Image\ImageManager
     */
    public function getCaptcha(ApiCaptchaService $captcha, $config = 'default')
    {
        return $captcha->create($config);
    }
}
