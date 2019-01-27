<?php

use Illuminate\Database\Seeder;

class DefaultMemberRank extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new \App\Models\Member\MemberRankModel();
        $test = $model->count();

        if ($test > 0) return;

        $insert = [
            [
                'young_name' => '会员',
                'young_sort' => '1',
                'young_child' => '0',
                'young_discount' => '100',
                'young_wage' => '0',
            ], [
                'young_name' => '10人团队长',
                'young_sort' => '10',
                'young_child' => '10',
                'young_discount' => '95',
                'young_wage' => '0',
            ], [
                'young_name' => '20人团队长',
                'young_sort' => '20',
                'young_child' => '20',
                'young_discount' => '90',
                'young_wage' => '0',
            ], [
                'young_name' => '30人团队长',
                'young_sort' => '30',
                'young_child' => '30',
                'young_discount' => '85',
                'young_wage' => '0',
            ], [
                'young_name' => '50人团队长',
                'young_sort' => '40',
                'young_child' => '50',
                'young_discount' => '80',
                'young_wage' => '0',
            ], [
                'young_name' => '100人团队长',
                'young_sort' => '50',
                'young_child' => '100',
                'young_discount' => '75',
                'young_wage' => '0',
            ], [
                'young_name' => '200人团队长',
                'young_sort' => '60',
                'young_child' => '200',
                'young_discount' => '70',
                'young_wage' => '0',
            ], [
                'young_name' => '500人团队长',
                'young_sort' => '70',
                'young_child' => '500',
                'young_discount' => '65',
                'young_wage' => '0',
            ], [
                'young_name' => '1000人团队长',
                'young_sort' => '80',
                'young_child' => '1000',
                'young_discount' => '60',
                'young_wage' => '0',
            ], [
                'young_name' => '3333人团队长',
                'young_sort' => '90',
                'young_child' => '3333',
                'young_discount' => '55',
                'young_wage' => '0',
            ], [
                'young_name' => '10000人团队长',
                'young_sort' => '99',
                'young_child' => '10000',
                'young_discount' => '50',
                'young_wage' => '0',
            ],
        ];

        $model->insert($insert);
    }
}
