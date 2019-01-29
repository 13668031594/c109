<?php

use Illuminate\Database\Seeder;

class DefaultCustomer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new \App\Models\Customer\CustomerModel();

        $test = $model->find(1);

        if (is_null($test)){

            $model->young_nickname = '系统客服';
            $model->young_text = '还未上线';
            $model->save();
        }

    }
}
