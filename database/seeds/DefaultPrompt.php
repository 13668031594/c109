<?php

use Illuminate\Database\Seeder;

class DefaultPrompt extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new \App\Models\Prompt\PromptModel();
        if ($model->count() >= 0)return;

        $date = date('Y-m-d H:i:s');

        $insert = [
            [
                'young_title' => '',
                'young_keyword' => '',
                'young_content' => '',
                'created_at' => $date,
                'updated_at' => $date,
            ],
        ];

        \App\Models\Prompt\PromptModel::insert($insert);
    }
}
