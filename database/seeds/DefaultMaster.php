<?php

use Illuminate\Database\Seeder;

class DefaultMaster extends Seeder
{
    private $date;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->date = date('Y-m-d H:i:s');

        //id从10w开始
        \Illuminate\Support\Facades\DB::select("ALTER TABLE young_master_models AUTO_INCREMENT = 100000");
        \Illuminate\Support\Facades\DB::select("ALTER TABLE young_master_power_models AUTO_INCREMENT = 100000");

        //超级管理员
        self::super_master();

        //初始权限组
        $name = self::default_power();

        //初始管理员
        self::default_master($name);

        //创建客服权限组
        self::customer_power();
    }

    //创建超级管理员账号
    private function super_master()
    {
        $test = \App\Models\Master\MasterModel::find(1);

        if (!is_null($test)) return;

        $insert = [
            'mid' => '1',
            env('DB_COLUMN_PREFIX') . 'nickname' => '洋洋',
            env('DB_COLUMN_PREFIX') . 'account' => 'yangyang',
            'password' => \Illuminate\Support\Facades\Hash::make('asdasd123'),
            env('DB_COLUMN_PREFIX') . 'power_id' => 0,
            env('DB_COLUMN_PREFIX') . 'power_name' => '超级管理组',
            'created_at' => $this->date,
            'updated_at' => $this->date,
        ];

        \App\Models\Master\MasterModel::insert($insert);
    }

    //创建初始权限组
    private function default_power()
    {
        $test = \App\Models\Master\MasterPowerModel::find(100000);

        if (!is_null($test)) return $test->young_name;

        $insert = [
            'id' => '100000',
            env('DB_COLUMN_PREFIX') . 'name' => '超级管理组',
            env('DB_COLUMN_PREFIX') . 'note' => '全权限管理组，请勿随意删除',
            env('DB_COLUMN_PREFIX') . 'content' => '-1',
            'created_at' => $this->date,
            'updated_at' => $this->date,
        ];

        \App\Models\Master\MasterPowerModel::insert($insert);

        return $insert[env('DB_COLUMN_PREFIX') . 'name'];
    }

    //创建初始管理员
    private function default_master($name)
    {
        $test = \App\Models\Master\MasterModel::find(100000);

        if (!is_null($test)) return;

        $insert = [
            'mid' => '100000',
            env('DB_COLUMN_PREFIX') . 'nickname' => '超级管理员',
            env('DB_COLUMN_PREFIX') . 'account' => 'admins',
            'password' => \Illuminate\Support\Facades\Hash::make('123456'),
            env('DB_COLUMN_PREFIX') . 'power_id' => 100000,
            env('DB_COLUMN_PREFIX') . 'power_name' => $name,
            'created_at' => $this->date,
            'updated_at' => $this->date,
        ];

        \App\Models\Master\MasterModel::insert($insert);
    }

    private function customer_power()
    {
        $test = \App\Models\Master\MasterPowerModel::find(100001);

        if (!is_null($test)) return $test->young_name;

        $insert = [
            'id' => '100001',
            env('DB_COLUMN_PREFIX') . 'name' => '客服组',
            env('DB_COLUMN_PREFIX') . 'note' => '客服所在权限组',
            env('DB_COLUMN_PREFIX') . 'content' => '-1',
            'created_at' => $this->date,
            'updated_at' => $this->date,
        ];

        \App\Models\Master\MasterPowerModel::insert($insert);
    }
}
