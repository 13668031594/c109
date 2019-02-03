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

        $name = self::add_suffix($tableName);

        $this->table = DB::table($name);
    }

    //统一查询筛选方法
    protected function sql_group(array $other = [])
    {
        if (is_null($this->table)) exit('please initial table');

        if (isset($other['leftJoin'])) self::leftJoin($other['leftJoin']);
        if (isset($other['select'])) self::select($other['select']);
        if (isset($other['where'])) self::where($other['where']);
        if (isset($other['orWhere'])) self::orWhere($other['orWhere']);
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

    //orWhere筛选
    protected function orWhere($where)
    {
        if (is_null($this->table)) exit('please initial table');

        if (!empty($where)) $this->table = $this->table->orWhere($where);
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

            if (!is_string($v)) continue;
            if (!is_string($k)) continue;

            $this->table = $this->table->orderBy($k, $v);
        }
    }

    //连表查询
    protected function leftJoin($leftJoin = [])
    {
        if (is_null($this->table)) exit('please initial table');

        foreach ($leftJoin as $v) {

            if (!isset($v['table']) || !isset($v['where'])) continue;

            $name = self::add_suffix($v['table']);
            $where = $v['where'];

            $this->table = $this->table->leftJoin($name, $where[0], $where[1], $where[2]);
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

    //批量更新
    protected function table_update($tableName = "", $multipleData = array(), $referenceColumn = 'id')
    {
        if ($tableName && !empty($multipleData)) {

            $tableName = env('DB_PREFIX') . $tableName;

            $multipleData = array_values($multipleData);

            // column or fields to update
            $updateColumn = array_keys($multipleData[0]);
            unset($updateColumn[$referenceColumn]);
            $whereIn = "";

            $q = "UPDATE " . $tableName . " SET ";
            foreach ($updateColumn as $uColumn) {
                $q .= $uColumn . " = CASE ";

                foreach ($multipleData as $data) {
                    $q .= "WHEN " . $referenceColumn . " = " . $data[$referenceColumn] . " THEN '" . $data[$uColumn] . "' ";
                }
                $q .= "ELSE " . $uColumn . " END, ";
            }
            foreach ($multipleData as $data) {
                $whereIn .= "'" . $data[$referenceColumn] . "', ";
            }
            $q = rtrim($q, ", ") . " WHERE " . $referenceColumn . " IN (" . rtrim($whereIn, ', ') . ")";

            // Update
            return DB::update(DB::raw($q));

        } else {
            return false;
        }
    }

    private function add_suffix(string $tableName)
    {
        $location = strpos($tableName, ' as');

        if (!$location) return $tableName . $this->suffix;

        $table = substr($tableName, 0, $location);

        $name = str_replace($table, ($table . $this->suffix), $tableName);

        return $name;
    }
}