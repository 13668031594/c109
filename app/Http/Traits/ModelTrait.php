<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/9
 * Time: 下午6:25
 */

namespace App\Http\Traits;

use Illuminate\Support\Facades\DB;

trait ModelTrait
{
    private $suffix = '_models';
    private $table = null;

    //初始化table
    protected function table(string $tableName)
    {
        if (empty($tableName)) exit('not have tableName');

        $this->table = DB::table($tableName . $this->suffix);
    }

    //统一查询筛选方法
    protected function sql_group(array $other = [])
    {
        if (is_null($this->table)) exit('please initial table');

        if (isset($other['select'])) self::select($other['select']);
        if (isset($other['where'])) self::where($other['where']);
        if (isset($other['whereIn'])) self::where_in($other['whereIn']);
        if (isset($other['orderBy'])) self::order_by($other['orderBy']);
    }

    //筛选需要查询的字段
    protected function select($select = '*')
    {
        if (is_null($this->table)) exit('please initial table');

        $this->table = $this->table->select($select);
    }

    //进行where筛选
    protected function where($where)
    {
        if (is_null($this->table)) exit('please initial table');

        if (!empty($where)) $this->table = $this->table->where($where);
    }

    //进行whereIn筛选
    protected function where_in($whereIn = [])
    {
        if (is_null($this->table)) exit('please initial table');

        foreach ($whereIn as $k => $v) {

            if (!is_array($v)) continue;

            $this->table = $this->table->whereIn($k, $v);
        }
    }

    //进行排序
    protected function order_by($orderBy = [])
    {
        if (is_null($this->table)) exit('please initial table');

        foreach ($orderBy as $k => $v) {

            if (!is_array($v)) continue;

            $this->table = $this->table->orderBy($k, $v);
        }
    }

    //获取分页
    protected function paginate()
    {
        $number = (int)\request()->get('limit');

        return $this->table->paginate((empty($number) ? 20 : $number))->toArray();
    }

    //获取所有信息
    protected function all()
    {
        return $this->table->get()->toArray();
    }
}