<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/14
 * Time: 下午6:34
 */

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait ImageTrait
{
    /**
     * 裁剪图片并保存
     *
     * @param $url
     * @param $length
     * @param $img_name
     * @return string|array
     */
    public function cut($url, $length, $img_name = null)
    {
        //判断图片是否存在
        if (!Storage::has($url)) return ['裁剪图片获取失败'];

        //判断裁剪宽度
        if ($length <= 0) return ['裁剪长度不得小于或等于零'];

        //为文件后缀赋值
        list($name, $suffix) = explode('.', $url);

        //图片后缀数组
        $image_suffix_array = ['jpeg', 'png', 'bmp', 'gif', 'svg', 'jpg'];

        //判断该文件是否为图片
        if (!in_array($suffix, $image_suffix_array)) return ['裁剪文件不是图片'];

        //读取图片信息
        $image = Image::make(Storage::get($url));

        //获取图片宽度
        $image_width = $image->width();

        //获取图片高度
        $image_height = $image->height();

        //判断并裁剪
        if ($image_width >= $length) {

            //宽度超过,以宽度为准裁剪

            //获取剪裁后的宽度比例
            $proportion = $length / $image_width;

            //获取等比例的高度,取整
            $height = floor($image_height * $proportion);

            //裁剪图片
            $new_image = $image->resize($length, $height);
        } elseif ($image_height >= $length) {

            //宽度未超过，高度超过，以高度为准裁剪

            //获取剪裁后的高度比例
            $proportion = $length / $image_height;

            //获取等比例的高度,取整
            $width = floor($image_width * $proportion);

            //裁剪图片
            $new_image = $image->resize($width, $length);
        } else {

            //宽高皆未超过,不裁剪

            //原图赋值
            $new_image = $image;
        }

        //判断是否传入名称
        $name = is_null($img_name) ? $name : $img_name;

        //新的文件名
        $new_url = $name . '_' . $length . '.' . $suffix;

        //保存裁剪图片
        Storage::put($new_url, $new_image->encode());

        //删除临时图片
        Storage::delete($url);

        //返回新的文件路由
        return $new_url;
    }

    /**
     * 确保文件是否存在
     *
     * @param string $url
     * @return \Illuminate\Config\Repository|mixed|string
     */
    public function ensure_url($url = '')
    {
        return file_exists($url) ? $url : config('young.default_image');
    }
}