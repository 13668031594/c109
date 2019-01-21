<?php

namespace App\Vendor\ApiCaptcha;

use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Hashing\BcryptHasher as Hasher;
use Illuminate\Session\Store as Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Mews\Captcha\Captcha;

class ApiCaptchaService extends Captcha
{
    private $code_number;

    public function __construct(Filesystem $files, Repository $config, ImageManager $imageManager, Session $session, Hasher $hasher, Str $str)
    {
        //获取或创建识别码
        $this->code_number = is_null(Input::get('code_number')) ? md5(random_bytes(8) . $_SERVER["REMOTE_ADDR"]) : Input::get('code_number');

        parent::__construct($files, $config, $imageManager, $session, $hasher, $str);
    }

    protected function generate()
    {
        $characters = str_split($this->characters);

        $bag = '';
        for ($i = 0; $i < $this->length; $i++) {
            $bag .= $characters[rand(0, count($characters) - 1)];
        }

        $hash = $this->hasher->make($bag);
        Cache::put($this->code_number, json_encode([
            'sensitive' => $this->sensitive,
            'key' => $this->hasher->make($this->sensitive ? $bag : $this->str->lower($bag))
        ]), 5);

//        return $bag;
        return [
            'value'     => $bag,
            'sensitive' => $this->sensitive,
            'key'       => $hash
        ];
    }

    public function src($config = null)
    {
        //创建路由信息
        $url = url('api/captcha' . ($config ? '/' . $config : '/default')) . '?' . $this->str->random(8);

        //返回信息
        return [
            'code_number' => $this->code_number,
            'url' => $url . '&code_number=' . $this->code_number,
        ];
    }

    public function check($value)
    {
        //判断变量类型,子元素
        if (!is_array($value) || !isset($value['code']) || !isset($value['code_number']) || is_null($value['code_number']) || is_null($value['code'])) {

            return false;
        }

        //将识别码赋值
        $code_number = $value['code_number'];

        //获取缓存captcha信息
        $cache = Cache::get($code_number);

        //缓存获取情况
        if (is_null($cache)) {

            //失败

            //返回false
            return false;
        } else {

            //成功

            $cache = json_decode($cache, true);
        }

        //判断缓存中的子元素信息
        if (!isset($cache['key']) || !isset($cache['sensitive']) || is_null($cache['key']) || is_null($cache['sensitive'])) {

            return false;
        }

        $key = $cache['key'];
        $sensitive = $cache['sensitive'];
        $value = $value['code'];

        if (!$sensitive) {
            $value = $this->str->lower($value);
        }

        //进行验证
        if ($this->hasher->check($value, $key)) {

            //通过

            //删除缓存
            Cache::forget($code_number);

            //返回成功
            return true;
        } else {

            //未通过

            //返回失败
            return false;
        }
    }
}
