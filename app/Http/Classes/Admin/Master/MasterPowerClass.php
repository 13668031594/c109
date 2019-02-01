<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/12
 * Time: 下午1:55
 */

namespace App\Http\Classes\Admin\Master;

use App\Http\Classes\Admin\AdminClass;
use App\Models\Master\MasterPowerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MasterPowerClass extends AdminClass implements \App\Http\Classes\ListInterface
{
    private $storage_map = 'item/MasterPower/';

    public function __construct()
    {
    }

    public function index()
    {
        // TODO: Implement index() method.
    }

    public function show($id)
    {
        // TODO: Implement show() method.
    }

    public function create()
    {
        // TODO: Implement create() method.
    }

    public function store(Request $request)
    {
        // TODO: Implement store() method.
    }

    public function edit($id)
    {
        // TODO: Implement edit() method.
    }

    public function update($id, Request $request)
    {
        // TODO: Implement update() method.
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }

    public function validator_store(Request $request)
    {
        // TODO: Implement validator_store() method.
    }

    public function validator_update($id, Request $request)
    {
        // TODO: Implement validator_update() method.
    }

    public function validator_delete($id)
    {
        // TODO: Implement validator_delete() method.
    }

    /**
     * 为权限组添加文件储存
     *
     * @param $id
     */
    public function power_storage($id)
    {
        $power = MasterPowerModel::find($id);

        //判断是否有模型
        if (!is_null($power)) {

            if ($id == '100001') {

                $content = self::customer();
            } else {

                //获取权限数组
                $content = is_null($power->young_content) ? [] : explode('|', $power->young_content);
            }

            //添加权限信息文件
            Storage::put($this->storage_map . $id, json_encode($content));
        }
    }

    /**
     * 返回权限组的权限列表(json字段)
     *
     * @param $id
     * @return null
     */
    public function get_storage_power($id)
    {
        if ($id == '100001') return self::customer();

        //判断权限组文件是否存在
        if (!Storage::exists($this->storage_map . $id)) {

            //不存在

            //马上储存权限组权限文件
            self::power_storage($id);
        }

        //返回权限组权限文件
        return json_decode(Storage::get($this->storage_map . $id), true);
    }

    private function customer()
    {
        return [
            'member', 'member.index', 'member.create', 'member.edit', 'member.act', 'member.wallet', 'member.record',
            'order','buy.index', 'buy.abn','sell.index','trad.index',
        ];
    }
}