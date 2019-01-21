<?php

use Illuminate\Database\Seeder;

class DefaultMemberAccount extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new \App\Models\Member\MemberAccountModel();
        $test = $model->first();

        if (is_null($test)) {

            $model->young_account = '100000';
            $model->save();
        }
    }
}
