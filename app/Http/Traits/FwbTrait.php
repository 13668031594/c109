<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/17
 * Time: 下午5:48
 */

namespace App\Http\Traits;

use App\Models\Publics\FwbImagesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait FwbTrait
{
    //上传文件
    public function images_fwb(Request $request)
    {
        //保存图片
        $location = $request->file('file')->store('public/Fwb');

        //转换展示路径
        $url = Storage::url($location);

        //添加到数据库
        $model = new FwbImagesModel();
        $model->young_location = $location;
        $model->young_url = $url;
        if (!$model->save()) return '上传失败';

        return [
            'src' => $url,
        ];
    }

    //保存使用记录
    public function store_fwb($keyword, $contents)
    {
        preg_match_all('/<img src="(.*?)"/', $contents, $result);

        $model = new FwbImagesModel();
        $model->where('young_keyword', '=', $keyword)->update(['young_keyword' => null]);//清空旧有信息
        if (count($result[1]) > 0) $model->whereIn('young_url', $result[1])->update(['young_keyword' => $keyword]);//添加新的绑定关系

        $date = date('Y-m-d H:i:s', strtotime('-3 day'));//3天前

        $deletes = $model->where('young_keyword', '=', null)->where('created_at', '<', $date)->get();//过期的图片

        self::destroy_fwb($deletes);
    }

    public function delete_fwb($keyword)
    {
        $model = new FwbImagesModel();

        $deletes = $model->where('young_keyword', '=', $keyword)->get();//需要删除的图片

        self::destroy_fwb($deletes);
    }

    private function destroy_fwb($deletes)
    {
        if (count($deletes) <= 0) return;
        $delete_id = $deletes->pluck('id');//需要删除的id
        $delete_location = $deletes->pluck('young_location');//需要删除的文件
        Storage::delete($delete_location->all());//删除文件
        FwbImagesModel::destroy($delete_id->all());//删除数据
    }

    //补全网址
    public function completion_location($contents)
    {
        preg_match_all('/<img src="(.*?)"/', $contents, $result);

        foreach ($result[1] as $v){

            $location = 'http://' . env('LOCALHOST') . $v;

            $contents = str_replace($v,$location,$contents);
        }

        return $contents;
    }
}